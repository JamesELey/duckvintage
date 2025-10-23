<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum('total_price');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active
        if (!$product->is_active) {
            return redirect()->back()->withErrors(['product' => 'This product is not available.']);
        }

        // Check if product is in stock
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock available. Only ' . $product->stock_quantity . ' items left.']);
        }

        // Check if item already exists in cart
        $existingItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        CartItem::where('id', $request->cart_item_id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
}


