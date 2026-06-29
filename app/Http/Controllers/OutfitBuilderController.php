<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class OutfitBuilderController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategoryId = $request->get('category_id');

        // Fetch all active categories to display in the filter dropdown
        $categories = Category::where('status', 'active')->get();

        // 1. Check if slots are locked
        $outerwear = null;
        $top = null;
        $bottom = null;

        if ($request->filled('lock_outerwear')) {
            $outerwear = Product::with('sizes')->where('status', 'active')->find($request->lock_outerwear);
        }
        if ($request->filled('lock_top')) {
            $top = Product::with('sizes')->where('status', 'active')->find($request->lock_top);
        }
        if ($request->filled('lock_bottom')) {
            $bottom = Product::with('sizes')->where('status', 'active')->find($request->lock_bottom);
        }

        // 2. Query for non-locked slots
        // Define common categories for a full outfit
        $topCategories = Category::where(function($query) {
            $query->where('name', 'like', '%Tee%')
                  ->orWhere('name', 'like', '%Shirt%')
                  ->orWhere('name', 'like', '%Sweater%')
                  ->orWhere('name', 'like', '%Top%');
        })->pluck('id');
            
        $bottomCategories = Category::where(function($query) {
            $query->where('name', 'like', '%Jean%')
                  ->orWhere('name', 'like', '%Pant%')
                  ->orWhere('name', 'like', '%Short%')
                  ->orWhere('name', 'like', '%Bottom%');
        })->pluck('id');
            
        $outerwearCategories = Category::where(function($query) {
            $query->where('name', 'like', '%Jacket%')
                  ->orWhere('name', 'like', '%Coat%')
                  ->orWhere('name', 'like', '%Outerwear%');
        })->pluck('id');

        $usedIds = [];
        if ($outerwear) $usedIds[] = $outerwear->id;
        if ($top) $usedIds[] = $top->id;
        if ($bottom) $usedIds[] = $bottom->id;

        // Outerwear Slot
        if (!$outerwear) {
            $outerwearQuery = Product::where('status', 'active');
            if (!empty($usedIds)) $outerwearQuery->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $outerwearQuery->where('category_id', $selectedCategoryId);
            if ($outerwearCategories->isNotEmpty()) $outerwearQuery->whereIn('category_id', $outerwearCategories);
            
            $outerwear = $outerwearQuery->inRandomOrder()->first();

            if (!$outerwear) { // Fallback to any available product
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
                if ($selectedCategoryId) $fb->where('category_id', $selectedCategoryId);
                $outerwear = $fb->inRandomOrder()->first();
            }
            if ($outerwear) $usedIds[] = $outerwear->id;
        }

        // Top Slot
        if (!$top) {
            $topQuery = Product::where('status', 'active');
            if (!empty($usedIds)) $topQuery->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $topQuery->where('category_id', $selectedCategoryId);
            if ($topCategories->isNotEmpty()) $topQuery->whereIn('category_id', $topCategories);
            
            $top = $topQuery->inRandomOrder()->first();

            if (!$top) { // Fallback
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
                if ($selectedCategoryId) $fb->where('category_id', $selectedCategoryId);
                $top = $fb->inRandomOrder()->first();
            }
            if ($top) $usedIds[] = $top->id;
        }

        // Bottom Slot
        if (!$bottom) {
            $bottomQuery = Product::where('status', 'active');
            if (!empty($usedIds)) $bottomQuery->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $bottomQuery->where('category_id', $selectedCategoryId);
            if ($bottomCategories->isNotEmpty()) $bottomQuery->whereIn('category_id', $bottomCategories);
            
            $bottom = $bottomQuery->inRandomOrder()->first();

            if (!$bottom) { // Fallback
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
                if ($selectedCategoryId) $fb->where('category_id', $selectedCategoryId);
                $bottom = $fb->inRandomOrder()->first();
            }
            if ($bottom) $usedIds[] = $bottom->id;
        }

        $outfit = collect([$outerwear, $top, $bottom])->filter();

        // Calculate total price
        $totalPrice = $outfit->sum(function($item) {
            return $item->sizes->min('price') ?? $item->price ?? 0;
        });

        if ($request->wantsJson()) {
            return response()->json([
                'outfit' => $outfit->map(function($item) {
                    if (!$item) return null;
                    $availableSizes = $item->sizes->where('stock', '>', 0);
                    $hasStock = $availableSizes->count() > 0;
                    $defaultPrice = $hasStock ? $availableSizes->min('price') : ($item->price ?? 0);
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'image' => asset('storage/' . $item->image),
                        'images' => array_map(function ($img) {
                            return asset('storage/' . $img);
                        }, array_values(array_filter([$item->image, $item->image_2, $item->image_3, $item->image_4]))),
                        'view_url' => route('product.view', $item->id),
                        'category_name' => $item->category->name ?? 'GET READY',
                        'price' => $defaultPrice,
                        'has_stock' => $hasStock,
                        'sizes' => $availableSizes->map(function($sz) {
                            return [
                                'size' => $sz->size,
                                'price' => $sz->price
                            ];
                        })->values()
                    ];
                })->values(),
                'totalPrice' => $totalPrice
            ]);
        }

        return view('frontend.outfit-builder', compact('outfit', 'totalPrice', 'top', 'bottom', 'outerwear', 'categories', 'selectedCategoryId'));
    }
}
