<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\don_hang;


class OrderDonHangXacNhan extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    
    public function __construct(don_hang $donHang)
    {
        $this->donHang = $donHang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác Nhận Đơn Hàng')
                    ->view('email.admin.order_donhangxacnhan') // Chỉ định view cho email
                    ->with([
                        'donHang' => $this->donHang,
                    ]);
    }
}
