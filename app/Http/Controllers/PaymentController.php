<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showCheckout()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum('total_price');
        $taxAmount = $subtotal * 0.08; // 8% tax
        $shippingAmount = 10.00; // Fixed shipping
        $totalAmount = $subtotal + $taxAmount + $shippingAmount;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('checkout', compact('cartItems', 'subtotal', 'taxAmount', 'shippingAmount', 'totalAmount'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal,cash_on_delivery',
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string',
            'shipping_address.street' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.zip' => 'required|string',
            'shipping_address.country' => 'required|string',
            'billing_address' => 'required|array',
            'billing_address.name' => 'required|string',
            'billing_address.street' => 'required|string',
            'billing_address.city' => 'required|string',
            'billing_address.state' => 'required|string',
            'billing_address.zip' => 'required|string',
            'billing_address.country' => 'required|string',
        ]);

        $cartItems = auth()->user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum('total_price');
        $taxAmount = $subtotal * 0.08;
        $shippingAmount = 10.00;
        $totalAmount = $subtotal + $taxAmount + $shippingAmount;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $totalAmount,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->product->current_price,
                'total_price' => $cartItem->total_price,
                'size' => $cartItem->size,
                'color' => $cartItem->color,
            ]);
        }

        // Process payment based on method
        switch ($request->payment_method) {
            case 'stripe':
                return $this->processStripePayment($order, $request);
            case 'paypal':
                return $this->processPayPalPayment($order, $request);
            case 'cash_on_delivery':
                return $this->processCashOnDelivery($order);
        }
    }

    private function processStripePayment($order, $request)
    {
        // For now, we'll simulate a successful payment
        // In production, you would integrate with Stripe API here
        $order->update([
            'payment_status' => 'completed',
            'status' => 'processing',
        ]);

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Payment processed successfully! Order placed.');
    }

    private function processPayPalPayment($order, $request)
    {
        // For now, we'll simulate a successful payment
        // In production, you would integrate with PayPal API here
        $order->update([
            'payment_status' => 'completed',
            'status' => 'processing',
        ]);

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Payment processed successfully! Order placed.');
    }

    private function processCashOnDelivery($order)
    {
        $order->update([
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed! Payment will be collected on delivery.');
    }

    public function paymentSuccess($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.success', compact('order'));
    }

    public function paymentCancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.cancel', compact('order'));
    }
}