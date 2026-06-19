<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $wishlistItems = Wishlist::with('product')->where('user_id', $userId)->latest()->get();
        return view('frontend.wishlist', compact('wishlistItems'));
    }

    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);
        $userId = Auth::id();

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $msg = 'Product removed from your wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $msg = 'Product added to your wishlist!';
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'in_wishlist' => !$existing
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }
}
