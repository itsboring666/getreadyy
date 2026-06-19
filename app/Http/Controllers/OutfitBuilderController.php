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

        if (!$outerwear) {
            $outerwearQuery = Product::where('status', 'active');
            if ($selectedCategoryId) {
                $outerwearQuery->where('category_id', $selectedCategoryId);
            }
            if ($outerwearCategories->isNotEmpty()) {
                $outerwearQuery->whereIn('category_id', $outerwearCategories);
            }
            $outerwear = $outerwearQuery->inRandomOrder()->first();

            // Fallback if no matching item
            if (!$outerwear) {
                $outerwearFallbackQuery = Product::where('status', 'active');
                if ($selectedCategoryId) {
                    $outerwearFallbackQuery->where('category_id', $selectedCategoryId);
                }
                $outerwear = $outerwearFallbackQuery->inRandomOrder()->first();
            }
        }

        if (!$top) {
            $topQuery = Product::where('status', 'active');
            if ($selectedCategoryId) {
                $topQuery->where('category_id', $selectedCategoryId);
            }
            if ($topCategories->isNotEmpty()) {
                $topQuery->whereIn('category_id', $topCategories);
            }
            if ($outerwear) {
                $topQuery->where('id', '!=', $outerwear->id);
            }
            $top = $topQuery->inRandomOrder()->first();

            // Fallback
            if (!$top) {
                $topFallbackQuery = Product::where('status', 'active');
                if ($selectedCategoryId) {
                    $topFallbackQuery->where('category_id', $selectedCategoryId);
                }
                if ($outerwear) {
                    $topFallbackQuery->where('id', '!=', $outerwear->id);
                }
                $top = $topFallbackQuery->inRandomOrder()->first();
            }
        }

        if (!$bottom) {
            $bottomQuery = Product::where('status', 'active');
            if ($selectedCategoryId) {
                $bottomQuery->where('category_id', $selectedCategoryId);
            }
            if ($bottomCategories->isNotEmpty()) {
                $bottomQuery->whereIn('category_id', $bottomCategories);
            }
            $excludeIds = collect([$outerwear?->id, $top?->id])->filter()->toArray();
            if (!empty($excludeIds)) {
                $bottomQuery->whereNotIn('id', $excludeIds);
            }
            $bottom = $bottomQuery->inRandomOrder()->first();

            // Fallback
            if (!$bottom) {
                $bottomFallbackQuery = Product::where('status', 'active');
                if ($selectedCategoryId) {
                    $bottomFallbackQuery->where('category_id', $selectedCategoryId);
                }
                if (!empty($excludeIds)) {
                    $bottomFallbackQuery->whereNotIn('id', $excludeIds);
                }
                $bottom = $bottomFallbackQuery->inRandomOrder()->first();
            }
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
