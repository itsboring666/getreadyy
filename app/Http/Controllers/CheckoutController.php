<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartItem::with(['product.sizes'])->where('user_id', Auth::id())->get();

        // Attach correct price to each item
        foreach ($items as $item) {
            $sizeObj = $item->product->sizes->firstWhere('size', $item->size);
            $item->unit_price = $sizeObj ? $sizeObj->price : 0;
        }

        $subtotal = $items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        // Location-based shipping fee (calculated on page load with default ₹75 until city/state filled)
        $shipping_fee_base = 75.00; // default (Tamil Nadu, non-Chennai)
        $shipping = $shipping_fee_base;

        $discountAmount = 0.00;
        $couponCode = null;
        if (session()->has('applied_coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('applied_coupon'))->first();
            if ($coupon && $coupon->isValidFor($subtotal)) {
                $discountAmount = $coupon->getDiscountAmount($subtotal);
                $couponCode = $coupon->code;
            } else {
                session()->forget('applied_coupon');
            }
        }

        $grandTotal = max(0.00, $subtotal + $shipping - $discountAmount);
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->latest()->get();

        return view('frontend.checkout', compact('items', 'subtotal', 'shipping', 'discountAmount', 'couponCode', 'grandTotal', 'addresses'));
    }

    public function process(Request $request)
    {

        $validated = $request->validate([
            'name'           => ['required', 'string', 'min:2', 'max:100'],
            'email'          => ['required', 'email', 'max:255'],
            'phone'          => ['required', 'regex:/^[6-9]\d{9}$/'],
            'city'           => ['required', 'string', 'max:50'],
            'state'          => ['required', 'string', 'max:50'],
            'zip'            => ['required', 'regex:/^\d{5,6}$/'],
            'address'        => ['required', 'string', 'min:10', 'max:255'],
            'payment_method' => ['required', 'in:razorpay'],
            'save_address'   => ['nullable', 'boolean'],
            'address_name'   => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'phone.regex' => 'Enter a valid Indian mobile number.',
            'zip.regex' => 'ZIP code should be 5 or 6 digits.',
            'address.min' => 'Address should be at least 10 characters.',
            'payment_method.in' => 'Please select a valid payment method.',
        ]);

        $userId = Auth::id();

        if ($request->has('save_address') && $request->save_address == 1) {
            $user = Auth::user();
            $exists = $user->addresses()->where([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip']
            ])->exists();

            if (!$exists) {
                $isFirst = $user->addresses()->count() === 0;
                $addressName = $request->input('address_name') ?: 'Home';
                
                $savedAddress = new \App\Models\UserAddress([
                    'address_name' => $addressName,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zip' => $validated['zip'],
                    'is_default' => $isFirst
                ]);
                $savedAddress->user_id = $user->id;
                $savedAddress->save();
            }
        }
        $items = CartItem::with('product')->where('user_id', $userId)->get();

        if ($items->isEmpty()) {
            return redirect()->route('products.all')->withErrors(['msg' => 'Your cart is empty.']);
        }

        $subtotal = $items->sum(function ($item) {
            $sizePrice = $item->product->sizes->firstWhere('size', $item->size)?->price ?? 0;
            return $sizePrice * $item->quantity;
        });

        // Location-based shipping fee
        $city  = strtolower(trim($validated['city']));
        $state = strtolower(trim($validated['state']));

        $localCities = ['chennai', 'chengalpattu', 'chengalpet', 'chengalpatu'];
        $tamilNaduVariants = ['tamil nadu', 'tamilnadu', 'tn'];

        if (in_array($city, $localCities)) {
            $shipping = 60.00; // Chennai / Chengalpattu
        } elseif (in_array($state, $tamilNaduVariants)) {
            $shipping = 75.00; // Rest of Tamil Nadu
        } else {
            $shipping = 140.00; // Other states
        }

        $discountAmount = 0.00;
        $couponCode = null;
        if (session()->has('applied_coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('applied_coupon'))->first();
            if ($coupon && $coupon->isValidFor($subtotal)) {
                $discountAmount = $coupon->getDiscountAmount($subtotal);
                $couponCode = $coupon->code;
            } else {
                session()->forget('applied_coupon');
            }
        }

        $grandTotal = max(0.00, $subtotal + $shipping - $discountAmount);

        $appId = config('services.cashfree.app_id');
        $secretKey = config('services.cashfree.secret_key');
        $env = config('services.cashfree.env');
        $orderId = 'ORDER_' . uniqid();

        $data = [
            "order_id" => $orderId,
            "order_amount" => $grandTotal,
            "order_currency" => "INR",
            "customer_details" => [
                "customer_id" => (string) $userId,
                "customer_name" => $validated['name'],
                "customer_email" => $validated['email'],
                "customer_phone" => $validated['phone'],
            ],
            "order_meta" => [
                "return_url" => route('checkout.verify') . '?order_id={order_id}', // ✅ Verification callback
            ]
        ];

        // Save order
        $order = Order::create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'total_amount' => $grandTotal,
            'shipping_fee' => $shipping,
            'coupon_code' => $couponCode,
            'discount_amount' => $discountAmount,
            'status' => 'pending', // will be updated after payment
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
            'address' => $validated['address'],
        ]);

        // Save order items
        foreach ($items as $item) {
            $sizePrice = $item->product->sizes->firstWhere('size', $item->size)?->price ?? 0;

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'size'         => $item->size,
                'quantity'     => $item->quantity,
                'price'        => $sizePrice, // ✅ CORRECT PRICE BY SIZE
            ]);
        }

        // 🟢 IF RAZORPAY PAYMENTS
        if ($validated['payment_method'] === 'razorpay') {
            return redirect()->route('checkout.razorpay', ['orderId' => $orderId]);
        }

        // 🟢 MOCK ONLINE PAYMENT FOR LOCAL TESTING (If dummy keys are used)
        if ($appId === 'YOUR_TEST_APP_ID' || empty($appId)) {
            $order->status = 'paid';
            $order->save();

            // Create Payment Log
            \App\Models\PaymentLog::create([
                'order_id' => $order->id,
                'payment_gateway' => 'cashfree',
                'transaction_id' => 'cf_mock_' . uniqid(),
                'amount' => $order->total_amount,
                'status' => 'successful',
                'raw_response' => json_encode(['mock' => true, 'status' => 'PAID'])
            ]);

            // Deduct stock
            foreach ($items as $item) {
                $productSize = $item->product->sizes->firstWhere('size', $item->size);
                if ($productSize) {
                    $productSize->stock = max(0, $productSize->stock - $item->quantity);
                    $productSize->save();
                }
            }

            // Clear Cart
            CartItem::where('user_id', $userId)->delete();

            // Send Email
            try {
                Mail::to($order->email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Order Confirmation Email Failed: ' . $e->getMessage());
            }

            // Send WhatsApp Invoice
            (new WhatsAppService())->sendUpdateWithInvoice($order);

            return redirect()->route('checkout.thankyou', ['orderId' => $orderId])
                             ->with('success', 'Payment successful (Simulated for testing).');
        }

        $apiUrl = $env === 'production' 
            ? 'https://api.cashfree.com/pg/orders' 
            : 'https://sandbox.cashfree.com/pg/orders';

        $response = Http::withHeaders([
            'x-api-version' => '2022-09-01',
            'x-client-id' => $appId,
            'x-client-secret' => $secretKey,
        ])->withoutVerifying()->post($apiUrl, $data);

        $json = $response->json();

        if (!isset($json['payment_session_id'])) {
            return back()->withErrors(['cashfree' => 'Cashfree Error: ' . json_encode($json)]);
        }

        $sessionId = $json['payment_session_id'];
        return view('frontend.cashfree', compact('sessionId'));
    }

    public function verify(Request $request)
    {
        $orderId = $request->query('order_id');
        if (!$orderId) {
            return redirect()->route('products.all')->withErrors(['msg' => 'Invalid order ID.']);
        }

        $appId = config('services.cashfree.app_id');
        $secretKey = config('services.cashfree.secret_key');
        $env = config('services.cashfree.env');

        $apiUrl = $env === 'production' 
            ? "https://api.cashfree.com/pg/orders/{$orderId}" 
            : "https://sandbox.cashfree.com/pg/orders/{$orderId}";

        $response = Http::withHeaders([
            'x-api-version' => '2022-09-01',
            'x-client-id' => $appId,
            'x-client-secret' => $secretKey,
        ])->get($apiUrl);

        $json = $response->json();

        if (isset($json['order_status']) && $json['order_status'] === 'PAID') {
            $order = Order::where('order_id', $orderId)->first();
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();

                // Create Payment Log
                \App\Models\PaymentLog::create([
                    'order_id' => $order->id,
                    'payment_gateway' => 'cashfree',
                    'transaction_id' => $json['cf_order_id'] ?? null,
                    'amount' => $order->total_amount,
                    'status' => 'successful',
                    'raw_response' => json_encode($json)
                ]);

                // Deduct stock for each item
                foreach ($order->items as $item) {
                    $productSize = $item->product->sizes()->where('size', $item->size)->first();
                    if ($productSize) {
                        $productSize->stock = max(0, $productSize->stock - $item->quantity);
                        $productSize->save();
                    }
                }

                // Clear user's cart
                CartItem::where('user_id', $order->user_id)->delete();

                // Send Email
                try {
                    Mail::to($order->email)->send(new OrderConfirmationMail($order));
                } catch (\Exception $e) {
                    Log::error('Order Confirmation Email Failed: ' . $e->getMessage());
                }

                // Send WhatsApp Invoice
                (new WhatsAppService())->sendUpdateWithInvoice($order);
            }
            return redirect()->route('checkout.thankyou', ['orderId' => $orderId])->with('success', 'Payment successful and order placed.');
        }

        return redirect()->route('checkout')->withErrors(['cashfree' => 'Payment failed or is pending. Please try again.']);
    }

    public function thankYou($orderId)
    {
        $order = Order::with(['items.product'])->where('order_id', $orderId)->firstOrFail();

        // ✅ Ensure the logged-in user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        if ($order->status !== 'paid') {
            return redirect()->route('checkout')->withErrors(['cashfree' => 'Payment has not been completed. Please try again.']);
        }


        return view('frontend.thankyou', compact('order'));
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with(['items.product'])->where('order_id', $orderId)->firstOrFail();

        $logoPath = public_path('assets/images/invoice-header.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $pdf = Pdf::loadView('frontend.invoice', compact('order', 'logoBase64'));

        return $pdf->download('invoice_' . $orderId . '.pdf');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid coupon code.');
        }

        $userId = Auth::id();
        $items = CartItem::with('product.sizes')->where('user_id', $userId)->get();

        $subtotal = $items->sum(function ($item) {
            $sizeObj = $item->product->sizes->firstWhere('size', $item->size);
            return ($sizeObj ? $sizeObj->price : 0) * $item->quantity;
        });

        if (!$coupon->isValidFor($subtotal)) {
            return redirect()->back()->with('error', 'Coupon is expired or order subtotal is below minimum value of ₹' . number_format($coupon->min_order_value, 2) . '.');
        }

        session(['applied_coupon' => $coupon->code]);

        return redirect()->back()->with('success', 'Coupon code applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return redirect()->back()->with('success', 'Coupon removed.');
    }

    public function razorpayCheckout($orderId)
    {
        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'paid') {
            return redirect()->route('checkout.thankyou', ['orderId' => $orderId]);
        }

        $razorpayKey = config('services.razorpay.key') ?: env('RAZORPAY_KEY');
        $razorpaySecret = config('services.razorpay.secret') ?: env('RAZORPAY_SECRET');
        
        $isMock = app()->environment('testing') || empty($razorpayKey) || empty($razorpaySecret) || str_contains($razorpayKey, 'your_key_id') || str_contains($razorpaySecret, 'your_secret_key');

        if ($isMock) {
            $razorpayOrderId = 'mock_order_' . uniqid();
            return view('frontend.razorpay', compact('order', 'razorpayKey', 'razorpayOrderId'));
        }

        try {
            $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);
            $razorpayOrder = $api->order->create([
                'receipt' => $order->order_id,
                'amount' => round($order->total_amount * 100), // in paise
                'currency' => 'INR'
            ]);
            $razorpayOrderId = $razorpayOrder['id'];
        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Failed: ' . $e->getMessage());
            return back()->withErrors(['razorpay' => 'Razorpay Error: ' . $e->getMessage()]);
        }

        return view('frontend.razorpay', compact('order', 'razorpayKey', 'razorpayOrderId'));
    }

    public function razorpayProcess(Request $request, $orderId)
    {
        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'paid') {
            return redirect()->route('checkout.thankyou', ['orderId' => $orderId]);
        }

        $razorpayKey = config('services.razorpay.key') ?: env('RAZORPAY_KEY');
        $razorpaySecret = config('services.razorpay.secret') ?: env('RAZORPAY_SECRET');

        $isMock = app()->environment('testing') || empty($razorpayKey) || empty($razorpaySecret) || str_contains($razorpayKey, 'your_key_id') || str_contains($razorpaySecret, 'your_secret_key');

        $paymentId = $request->input('razorpay_payment_id');
        $razorpayOrderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        if ($isMock) {
            $transactionId = $paymentId ?: 'pay_mock_' . uniqid();
            $rawResponse = [
                'status' => 'captured',
                'method' => 'card',
                'order_id' => $razorpayOrderId ?: 'order_mock_' . uniqid(),
            ];
        } else {
            if (!$paymentId || !$razorpayOrderId || !$signature) {
                return redirect()->route('checkout.razorpay', $orderId)->withErrors(['razorpay' => 'Signature verification failed: Missing details.']);
            }

            try {
                $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);
                // Verify signature
                $attributes = [
                    'razorpay_order_id' => $razorpayOrderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature
                ];
                $api->utility->verifyPaymentSignature($attributes);
                $transactionId = $paymentId;
                $rawResponse = $attributes;
            } catch (\Exception $e) {
                Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
                return redirect()->route('checkout.razorpay', $orderId)->withErrors(['razorpay' => 'Payment Signature verification failed.']);
            }
        }

        // Mark order as paid
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

        // Create Payment Log
        \App\Models\PaymentLog::create([
            'order_id' => $order->id,
            'payment_gateway' => 'razorpay',
            'transaction_id' => $transactionId,
            'amount' => $order->total_amount,
            'status' => 'successful',
            'raw_response' => json_encode($rawResponse)
        ]);

        // Clear cart
        CartItem::where('user_id', Auth::id())->delete();

        // Send Email
        try {
            Mail::to($order->email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::error('Order Confirmation Email Failed: ' . $e->getMessage());
        }

        // Send WhatsApp Invoice
        (new WhatsAppService())->sendUpdateWithInvoice($order);

        return redirect()->route('checkout.thankyou', ['orderId' => $orderId])
            ->with('success', $isMock ? 'Razorpay sandbox payment successful!' : 'Razorpay payment successful!');
    }
}
