<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Tuchoitrahang extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    public function __construct($donHang)
    {
        $this->donHang = $donHang;
    }

    public function build()
    {
        return $this->subject('Yêu cầu trả hàng không được chấp nhận')
                    ->view('email.admin.tuchoitrahang'); // Tạo view này trong bước tiếp theo
    }
}
