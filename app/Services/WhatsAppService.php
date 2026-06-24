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
     * @return bool
     */
    public function sendInvoice(Order $order)
    {
        // Disabled UltraMsg API per user request to use free Click-to-Chat instead.
        return false;
    }
}
