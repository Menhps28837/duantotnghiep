<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Traloitrahang extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;
    public $cauHoi;
    public $reasons;
    public $yeuCauTraHang;

    public function __construct($donHang, $cauHoi, $reasons, $yeuCauTraHang)
    {
        $this->donHang = $donHang;
        $this->cauHoi = $cauHoi; 
        $this->reasons = $reasons; // Lưu lý do

        $this->yeuCauTraHang = $yeuCauTraHang;
    }

    public function build()
    {
        return $this->subject('Câu hỏi về yêu cầu trả hàng')
                    ->view('email.admin.traloitrahang')
                    ->with([
                        'tenKhachHang' => $this->donHang->ten_nguoi_nhan,
                        'emailKhachHang' => $this->donHang->email,
                        'cauHoi' => $this->cauHoi,
                        'idDonHang' => $this->donHang->id,
                        'reasons' => $this->reasons, // Truyền lý do vào view
                        'lydo' => $this->yeuCauTraHang->lydo,
                    ]);
    }

}
