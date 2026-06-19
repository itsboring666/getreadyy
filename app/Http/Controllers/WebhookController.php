<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\PaymentLog;
use App\Mail\OrderConfirmationMail;
use Razorpay\Api\Api;

class WebhookController extends Controller
{
    public function razorpayWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

        if (empty($webhookSecret)) {
            Log::warning('Razorpay Webhook Secret is not set in .env');
            return response()->json(['error' => 'Webhook secret not configured'], 400);
        }

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $api->utility->verifyWebhookSignature($payload, $signature, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook Signature Verification Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $data = json_decode($payload, true);

        if (isset($data['event']) && $data['event'] === 'payment.captured') {
            $paymentEntity = $data['payload']['payment']['entity'];
            $razorpayOrderId = $paymentEntity['order_id'];
            $transactionId = $paymentEntity['id'];

            // Find order by Razorpay Order ID (which we stored in payment log)
            // Wait, we didn't store razorpay_order_id in the Order table directly.
            // But we can find it through PaymentLog, OR we can use the notes if we passed receipt.
            // Let's use the receipt we passed during order creation:
            $orderId = $paymentEntity['notes']['receipt'] ?? null;

            if (!$orderId) {
                // If notes is empty, sometimes we can extract it from the database if we stored the razorpay_order_id somewhere.
                // Wait, in CheckoutController we passed 'receipt' => $order->order_id!
                // Let's just find the order by order_id.
            }
            
            // Let's check if the order exists
            $order = Order::where('order_id', $orderId)->first();

            // If receipt wasn't in notes, fallback to finding by payment log if we stored it
            if (!$order) {
                $paymentLog = PaymentLog::where('transaction_id', $razorpayOrderId)->orWhere('raw_response', 'LIKE', '%"razorpay_order_id":"'.$razorpayOrderId.'"%')->first();
                if ($paymentLog) {
                    $order = Order::find($paymentLog->order_id);
                }
            }

            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();

                // Deduct inventory
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $productSize = $item->product->sizes->firstWhere('size', $item->size);
                        if ($productSize) {
                            $productSize->stock = max(0, $productSize->stock - $item->quantity);
                            $productSize->save();
                        }
                    }
                }

                // Create Payment Log if it doesn't exist for this successful webhook
                PaymentLog::create([
                    'order_id' => $order->id,
                    'payment_gateway' => 'razorpay_webhook',
                    'transaction_id' => $transactionId,
                    'amount' => $order->total_amount,
                    'status' => 'successful',
                    'raw_response' => $payload
                ]);

                // Clear cart for the user
                CartItem::where('user_id', $order->user_id)->delete();

                // Send Email
                try {
                    Mail::to($order->email)->send(new OrderConfirmationMail($order));
                } catch (\Exception $e) {
                    Log::error('Order Confirmation Email Failed via Webhook: ' . $e->getMessage());
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
