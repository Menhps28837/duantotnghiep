<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\don_hang;
use App\Models\don_hang_chi_tiet;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $orderDetails;
    public function __construct(don_hang $order, $orderDetails)
    {
        $this->order = $order;
        $this->orderDetails = $orderDetails; 
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đặt hàng thành công',
        );
    }

    public function build()
    {
        return $this->subject('Xác Nhận Đơn Hàng')
                    ->view('email.dathang_thanhcong'); 
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.dathang_thanhcong',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
