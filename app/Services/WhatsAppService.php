<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $instanceId;
    protected $token;

    public function __construct()
    {
        $this->instanceId = config('services.ultramsg.instance_id') ?: env('ULTRAMSG_INSTANCE_ID');
        $this->token = config('services.ultramsg.token') ?: env('ULTRAMSG_TOKEN');
    }

    /**
     * Send order confirmation and invoice via WhatsApp
     *
     * @param Order $order
    public function sendUpdateWithInvoice(Order $order)
    {
        if (!$this->instanceId || !$this->token) {
            Log::warning('WhatsAppService: UltraMsg credentials not configured.');
            return false;
        }

        try {
            // 1. Format the customer's phone number
            $phone = $order->phone;
            if (strlen($phone) == 10) {
                $phone = '+91' . $phone;
            } elseif (!str_starts_with($phone, '+')) {
                $phone = '+' . $phone;
            }

            // 2. Generate PDF Invoice
            $pdf = Pdf::loadView('frontend.invoice', compact('order'));
            
            $filename = 'invoices/invoice_' . $order->order_id . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            
            $mediaUrl = asset('storage/' . $filename);

            // 3. Compose the WhatsApp message body based on status
            $body = "Hi {$order->name},\n\n";
            $body .= "Thank you for shopping with GET READY! 🛍️\n";
            $body .= "Your order *{$order->order_id}* is currently: *" . strtoupper($order->status) . "*.\n\n";
            if ($order->tracking_number) {
                $body .= "Tracking AWB: *{$order->tracking_number}*\n\n";
            }
            $body .= "We have attached your official invoice to this message.\n\n";
            $body .= "Track your order on our website. Stay stylish! 😎";

            // 4. Send the WhatsApp message via UltraMsg REST API
            $response = Http::asForm()->post("https://api.ultramsg.com/{$this->instanceId}/messages/document", [
                'token' => $this->token,
                'to' => $phone,
                'document' => $mediaUrl,
                'filename' => "invoice_{$order->order_id}.pdf",
                'caption' => $body,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp update sent successfully to {$phone} for Order {$order->order_id}");
                return true;
            } else {
                Log::error("WhatsAppService API Error for Order {$order->order_id}: " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("WhatsAppService Error for Order {$order->order_id}: " . $e->getMessage());
            return false;
        }
    }
}
