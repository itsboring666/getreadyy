<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = Order::with(['items.product', 'user'])->where('order_id', $orderId)->firstOrFail();
        return view('admin.orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        $logoPath = public_path('assets/images/invoice-header.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $pdf = Pdf::loadView('orders.invoice', compact('order', 'logoBase64'));
        return $pdf->download('Invoice_' . $order->order_id . '.pdf');
    }

    public function updateStatus(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:pending,paid,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $originalStatus = $order->status;
        $order->status  = $request->status;

        if ($request->has('tracking_number')) {
            $order->tracking_number = $request->tracking_number;
        }
        $order->save();

        // Send shipped email when status changes to shipped
        if ($originalStatus !== 'shipped' && $order->status === 'shipped' && $order->email) {
            try {
                Mail::to($order->email)->send(new \App\Mail\OrderShippedMail($order));
            } catch (\Exception $e) {
                Log::error('Order Shipped Email Failed: ' . $e->getMessage());
            }
        }

        // Automatically send WhatsApp update with invoice
        (new \App\Services\WhatsAppService())->sendUpdateWithInvoice($order);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Manually send order confirmation email to customer.
     */
    public function sendConfirmationEmail(Order $order)
    {
        if (!$order->email) {
            return redirect()->back()->with('error', 'No email address found for this order.');
        }

        try {
            Mail::to($order->email)->send(new \App\Mail\OrderConfirmationMail($order));
            return redirect()->back()->with('success', 'Order confirmation email sent successfully to ' . $order->email);
        } catch (\Exception $e) {
            Log::error('Admin Manual Confirmation Email Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
