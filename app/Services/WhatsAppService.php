<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $sid;
    protected $token;
    protected $twilioNumber;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid') ?: env('TWILIO_SID');
        $this->token = config('services.twilio.token') ?: env('TWILIO_TOKEN');
        $this->twilioNumber = config('services.twilio.whatsapp_from') ?: env('TWILIO_WHATSAPP_NUMBER');
    }

    /**
     * Send order confirmation and invoice via WhatsApp
     *
     * @param Order $order
     * @return bool
     */
    public function sendInvoice(Order $order)
    {
        if (!$this->sid || !$this->token || !$this->twilioNumber) {
            Log::warning('WhatsAppService: Twilio credentials not configured.');
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
            
            // Get the full public URL of the saved PDF
            // Note: In local dev, asset() might return localhost which Twilio cannot reach.
            $mediaUrl = asset('storage/' . $filename);

            // 3. Compose the WhatsApp message body
            $body = "Hi {$order->name},\n\n";
            $body .= "Thank you for shopping with GET READY! 🛍️\n";
            $body .= "Your order *{$order->order_id}* has been confirmed.\n\n";
            $body .= "Total Amount: ₹" . number_format($order->total_amount, 2) . "\n";
            $body .= "We have attached your official invoice to this message.\n\n";
            $body .= "Track your order on our website. Stay stylish! 😎";

            // 4. Send the WhatsApp message via Twilio REST API
            $response = Http::withBasicAuth($this->sid, $this->token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json", [
                    'From' => "whatsapp:" . $this->twilioNumber,
                    'To' => "whatsapp:" . $phone,
                    'Body' => $body,
                    'MediaUrl' => $mediaUrl,
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp invoice sent successfully to {$phone} for Order {$order->order_id}");
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
