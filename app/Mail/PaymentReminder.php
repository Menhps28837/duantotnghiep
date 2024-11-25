<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yêu Cầu Chuyển Khoản lại!',
        );
    }

    public function build()
    {
        return $this->view('email.admin.nhacnhothanhtoan')
                    ->with([
                        'orderId' => $this->order->id,
                        'customerName' => $this->order->ten_nguoi_nhan,
                    ]);
    }
}
