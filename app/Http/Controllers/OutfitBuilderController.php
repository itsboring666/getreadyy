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
        $usedIds = [];
        if ($outerwear) $usedIds[] = $outerwear->id;
        if ($top) $usedIds[] = $top->id;
        if ($bottom) $usedIds[] = $bottom->id;

        // Outerwear Slot
        if (!$outerwear) {
            $query = Product::where('status', 'active');
            if (!empty($usedIds)) $query->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $query->where('category_id', $selectedCategoryId);
            
            $outerwear = $query->inRandomOrder()->first();

            if (!$outerwear) { // Fallback if selected category has no items left
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
                $outerwear = $fb->inRandomOrder()->first();
            }
            if ($outerwear) $usedIds[] = $outerwear->id;
        }

        // Top Slot
        if (!$top) {
            $query = Product::where('status', 'active');
            if (!empty($usedIds)) $query->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $query->where('category_id', $selectedCategoryId);
            
            $top = $query->inRandomOrder()->first();

            if (!$top) { // Fallback if selected category has no items left
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
                $top = $fb->inRandomOrder()->first();
            }
            if ($top) $usedIds[] = $top->id;
        }

        // Bottom Slot
        if (!$bottom) {
            $query = Product::where('status', 'active');
            if (!empty($usedIds)) $query->whereNotIn('id', $usedIds);
            if ($selectedCategoryId) $query->where('category_id', $selectedCategoryId);
            
            $bottom = $query->inRandomOrder()->first();

            if (!$bottom) { // Fallback if selected category has no items left
                $fb = Product::where('status', 'active');
                if (!empty($usedIds)) $fb->whereNotIn('id', $usedIds);
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
