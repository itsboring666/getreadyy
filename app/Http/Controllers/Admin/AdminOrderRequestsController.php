<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class AdminOrderRequestsController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->whereIn('status', ['cancel_requested', 'return_requested'])
            ->latest()
            ->get();

        return view('admin.orders.requests', compact('orders'));
    }

    public function approve($id)
    {
        $order = Order::with('items.product.sizes')->findOrFail($id);
        $originalStatus = $order->status;

        if ($originalStatus === 'cancel_requested') {
            $order->status = 'cancelled';
            $order->save();

            // Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $productSize = $item->product->sizes->firstWhere('size', $item->size);
                    if ($productSize) {
                        $productSize->stock += $item->quantity;
                        $productSize->save();
                    }
                }
            }

            $successfulPayment = PaymentLog::where('order_id', $order->id)->where('status', 'successful')->first();
            $gateway = $successfulPayment ? $successfulPayment->payment_gateway : 'razorpay';

            // Create refund payment log entry
            PaymentLog::create([
                'order_id' => $order->id,
                'payment_gateway' => $gateway,
                'transaction_id' => 'ref_mock_' . uniqid(),
                'amount' => $order->total_amount,
                'status' => 'refunded',
                'raw_response' => json_encode(['status' => 'refunded', 'amount' => $order->total_amount])
            ]);

            return redirect()->back()->with('success', 'Cancellation request approved. Order cancelled and stock restored.');
        }

        if ($originalStatus === 'return_requested') {
            $order->status = 'returned';
            $order->save();

            // Restore stock for returns
            foreach ($order->items as $item) {
                if ($item->product) {
                    $productSize = $item->product->sizes->firstWhere('size', $item->size);
                    if ($productSize) {
                        $productSize->stock += $item->quantity;
                        $productSize->save();
                    }
                }
            }

            $successfulPayment = PaymentLog::where('order_id', $order->id)->where('status', 'successful')->first();
            $gateway = $successfulPayment ? $successfulPayment->payment_gateway : 'razorpay';

            // Create refund payment log
            PaymentLog::create([
                'order_id' => $order->id,
                'payment_gateway' => $gateway,
                'transaction_id' => 'ref_mock_' . uniqid(),
                'amount' => $order->total_amount,
                'status' => 'refunded',
                'raw_response' => json_encode(['status' => 'refunded', 'amount' => $order->total_amount])
            ]);

            return redirect()->back()->with('success', 'Return request approved. Order marked as returned and stock restored.');
        }

        return redirect()->back()->with('error', 'This order request cannot be processed.');
    }

    public function reject($id)
    {
        $order = Order::findOrFail($id);
        $originalStatus = $order->status;

        if ($originalStatus === 'cancel_requested') {
            $order->status = 'paid';
            $order->save();
            return redirect()->back()->with('success', 'Cancellation request rejected. Order reverted to Paid.');
        }

        if ($originalStatus === 'return_requested') {
            $order->status = 'delivered';
            $order->save();
            return redirect()->back()->with('success', 'Return request rejected. Order reverted to Delivered.');
        }

        return redirect()->back()->with('error', 'This order request cannot be processed.');
    }
}
