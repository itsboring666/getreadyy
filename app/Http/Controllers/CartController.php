<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // 👉 Check if stock is available
        $sizeData = ProductSize::where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if (!$sizeData || $sizeData->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stock not available for the selected size.');
        }

        // Check if item already exists
        $existing = CartItem::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $request->quantity;
            if ($newQty > $sizeData->stock) {
                return redirect()->back()->with('error', 'Cannot add more — only ' . $sizeData->stock . ' available in this size (you have ' . $existing->quantity . ' in cart).');
            }
            $existing->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity,
            ]);
        }

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('cart');
        }

        return redirect()->back()->with('success', 'Product added to your cart!');
    }

    public function remove($id)
    {
        $item = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($item) {
            $item->delete();
            return redirect()->route('cart')->with('success', 'Item removed from cart.');
        }

        return redirect()->route('cart')->with('error', 'Item not found or unauthorized.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($item) {
            // Check stock
            $sizeData = ProductSize::where('product_id', $item->product_id)
                ->where('size', $item->size)
                ->first();

            if (!$sizeData || $sizeData->stock < $request->quantity) {
                return redirect()->route('cart')->with('error', 'Only ' . ($sizeData->stock ?? 0) . ' available in this size.');
            }

            $item->update(['quantity' => $request->quantity]);
            return redirect()->route('cart')->with('success', 'Cart updated successfully.');
        }

        return redirect()->route('cart')->with('error', 'Item not found or unauthorized.');
    }

    public function addMultiple(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.size' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $addedCount = 0;
        $errors = [];

        foreach ($request->items as $itemData) {
            if (!isset($itemData['selected']) || !$itemData['selected']) {
                continue;
            }

            $productId = $itemData['product_id'];
            $size = $itemData['size'];
            $quantity = $itemData['quantity'];

            $sizeData = ProductSize::where('product_id', $productId)
                ->where('size', $size)
                ->first();

            if (!$sizeData || $sizeData->stock < $quantity) {
                $product = Product::find($productId);
                $errors[] = "Stock not available for " . ($product->name ?? 'item') . " in size " . $size . ".";
                continue;
            }

            $existing = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->where('size', $size)
                ->first();

            if ($existing) {
                $newQty = $existing->quantity + $quantity;
                if ($newQty > $sizeData->stock) {
                    $product = Product::find($productId);
                    $errors[] = "Cannot add more of " . ($product->name ?? 'item') . " — only " . $sizeData->stock . " available.";
                    continue;
                }
                $existing->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }
            $addedCount++;
        }

        if ($addedCount === 0) {
            return redirect()->back()->with('error', 'No items were selected to be added.');
        }

        if (count($errors) > 0) {
            $msg = "Added " . $addedCount . " items to cart. Errors: " . implode(" ", $errors);
            return redirect()->route('cart')->with('error', $msg);
        }

        return redirect()->route('cart')->with('success', 'Selected items added to your cart!');
    }

    public function view()
    {
        if (!Auth::check()) {
            $items = collect();
        } else {
            $items = CartItem::with(['product.sizes'])->where('user_id', Auth::id())->get();

            // Inject correct price for each item based on size
            foreach ($items as $item) {
                $sizeObj = $item->product->sizes->firstWhere('size', $item->size);
                $item->unit_price = $sizeObj ? $sizeObj->price : 0;
            }
        }

        return view('frontend.cart', compact('items'));
    }
}
