<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class yeucautrahang extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;
    public $reasons;
    public $yeuCauTraHang;

    public function __construct($donHang, $reasons, $yeuCauTraHang)
    {
        $this->donHang = $donHang;
        $this->reasons = $reasons; // Lưu lý do
        $this->yeuCauTraHang = $yeuCauTraHang;
        
    }

    public function build()
    {
        return $this->subject('Yêu cầu trả hàng đã được gửi')
                    ->view('email.yeucautrahang')
                    ->with([
                        'tenKhachHang' => $this->donHang->ten_nguoi_nhan,
                        'emailKhachHang' => $this->donHang->email,
                        'trangThai' => 'Đang chờ quản trị viên duyệt',
                        'reasons' => $this->reasons, // Truyền lý do vào view
                        'lydo' => $this->yeuCauTraHang->lydo,
                    ]);
    }
}
