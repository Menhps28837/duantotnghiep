<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\don_hang;

class Orderdanhan extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public function __construct(don_hang $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Khách hàng đã nhận được hàng',
        );
    }

    public function build()
    {
        return $this->subject('Khách hàng đã nhận được hàng')
                    ->view('order_danhan'); // Tạo view cho email
    }

    public function content(): Content
    {
        return new Content(
            view: 'order_danhan',
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