<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Trahang extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    public function __construct($donHang)
    {
        $this->donHang = $donHang;
    }

    public function build()
    {
        return $this->subject('Yêu cầu trả hàng đã được chấp nhận')
                    ->view('email.admin.chopheptrahang'); // Tạo view này trong bước tiếp theo
    }
}
