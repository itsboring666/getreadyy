<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $logoPath = public_path('assets/images/official-logo.jpg');
        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.invoice', [
            'order' => $this->order,
            'logoBase64' => $logoBase64
        ]);

        return $this->subject('Order Confirmation: ' . $this->order->order_id . ' | GET READY')
                    ->view('emails.order-confirmation')
                    ->attachData($pdf->output(), 'invoice_' . $this->order->order_id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
