<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $phoneNumberId;
    protected $accessToken;
    protected $templateName;

    public function __construct()
    {
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $this->accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $this->templateName = env('WHATSAPP_TEMPLATE_NAME', 'order_update'); // The template name approved in Meta
    }

    public function sendUpdateWithInvoice(Order $order)
    {
        if (!$this->phoneNumberId || !$this->accessToken) {
            Log::warning('WhatsAppService: Meta Cloud API credentials not configured in .env');
            return false;
        }

        try {
            // 1. Format the customer's phone number (Meta requires country code without the + symbol)
            $phone = preg_replace('/[^0-9]/', '', $order->phone);
            if (strlen($phone) == 10) {
                $phone = '91' . $phone;
            }

            // 2. Generate PDF Invoice
            $pdf = Pdf::loadView('frontend.invoice', compact('order'));
            $filename = 'invoices/invoice_' . $order->order_id . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            $mediaUrl = asset('storage/' . $filename);

            // 3. Send the WhatsApp Template message via Meta Cloud API
            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v20.0/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $phone,
                    'type' => 'template',
                    'template' => [
                        'name' => env('WHATSAPP_TEMPLATE_NAME', 'order_successful'),
                        'language' => [
                            'code' => 'en'
                        ],
                        'components' => [
                            [
                                'type' => 'header',
                                'parameters' => [
                                    [
                                        'type' => 'document',
                                        'document' => [
                                            'link' => $mediaUrl,
                                            'filename' => "Invoice_{$order->order_id}.pdf"
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'type' => 'body',
                                'parameters' => [
                                    ['type' => 'text', 'text' => $order->name],
                                    ['type' => 'text', 'text' => $order->order_id]
                                ]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                Log::info("Meta WhatsApp update sent successfully to {$phone} for Order {$order->order_id}");
                return true;
            } else {
                Log::error("Meta WhatsApp API Error for Order {$order->order_id}: " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("WhatsAppService Error for Order {$order->order_id}: " . $e->getMessage());
            return false;
        }
    }
}
