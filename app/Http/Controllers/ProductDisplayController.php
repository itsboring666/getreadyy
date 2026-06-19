<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductDisplayController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'sizes']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Always only show active products on the frontend
        $query->where('status', 'active');

        // Get products first (pagination comes later)
        $products = $query->get();

        // Apply sorting manually based on sizes
        if ($request->filled('sort')) {
            if ($request->sort === 'low') {
                $products = $products->sortBy(function ($product) {
                    return $product->sizes->min('price') ?? PHP_INT_MAX;
                });
            } elseif ($request->sort === 'high') {
                $products = $products->sortByDesc(function ($product) {
                    return $product->sizes->min('price') ?? 0;
                });
            }
        } else {
            // Default sort by latest
            $products = $products->sortByDesc('created_at');
        }

        // Manually paginate the collection
        $perPage = 30;
        $page = request()->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage($page, $perPage)->values(),
            $products->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $categories = Category::all();

        return view('frontend.all-products', [
            'products' => $paginated,
            'categories' => $categories,
        ]);
    }

    public function showAll()
    {
        $products = Product::where('status', 'active')->latest()->get();
        $categories = Category::all();

        return view('frontend.all-products', compact('products', 'categories'));
    }

    public function view($id)
    {
        $product = Product::with(['category', 'sizes', 'reviews.user'])->findOrFail($id);
        return view('frontend.view-product', compact('product'));
    }

    public function autocomplete(\Illuminate\Http\Request $request)
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with(['category', 'sizes'])
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->take(6)
            ->get();

        $formatted = $products->map(function($product) {
            // Find starting price
            $minPrice = $product->sizes->where('stock', '>', 0)->min('price') 
                ?? $product->sizes->min('price') 
                ?? $product->price 
                ?? 0;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->name ?? 'GET READY',
                'image' => asset('storage/' . $product->image),
                'price' => '₹' . number_format($minPrice, 2),
                'url' => route('product.view', $product->id)
            ];
        });

        return response()->json($formatted);
    }
}
