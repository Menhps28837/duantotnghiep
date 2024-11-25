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

class Orderxacnhan extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $orderDetails;
    public function __construct(don_hang $order)
    {
        $this->order = $order;
        // $this->orderDetails = $orderDetails; // Lưu thông tin chi tiết đơn hàng
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đơn hàng đã được xác nhận và chuyển qua shipper',
        );
    }

    public function build()
    {
        return $this->subject('Đơn hàng đã được xác nhận và chuyển qua shipper')
                    ->view('email.admin.order_shipper') // Tạo view cho email
                    ->with(['order' => $this->order]); 
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.admin.order_shipper',
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
