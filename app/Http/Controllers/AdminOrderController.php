<?php
namespace App\Http\Controllers;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\don_hang;
use Illuminate\Support\Facades\Mail;
use App\Mail\Orderdanhan;
use App\Mail\OrderReceivedConfirmation;
use Illuminate\Support\Facades\View;
use App\Models\san_pham;
use App\Models\User;
use App\Models\lien_he;
use App\Models\so_luong_ton_kho;
use App\Models\binh_luan;
use Session;

class AdminOrderController extends AdminController {
//     public function danhanDonHang(string $id)
// {
//     // Tìm đơn hàng
//     $donHang = don_hang::find($id);
//     if (!$donHang) {
//         return redirect('/')->with('thongbao', 'Đơn hàng không tồn tại');
//     }

//     // Gửi email thông báo cho admin
//     Mail::to('tieuanhcuong2004@gmail.com')->send(new Orderdanhan($donHang)); 

//     // Gửi email xác nhận cho khách hàng
//     Mail::to($donHang->email)->send(new OrderConfirmation($donHang));
 
//     return redirect()->route('thank.you')->with('thongbao2', 'Cảm ơn! Đơn hàng của bạn đã được xác nhận.');
// }
public function __construct() {
    parent::__construct(); // Gọi constructor của lớp cha
}


public function confirmReceived(string $id)
{
    // Tìm đơn hàng
    $donHang = don_hang::find($id);
    if (!$donHang) {
        return redirect('/')->with('thongbao', 'Đơn hàng không tồn tại');
    }

    // Gửi email cho admin xác nhận
    Mail::to($donHang->email)->send(new OrderReceivedConfirmation($donHang));

    return redirect()->route('thank.you')->with('thongbao2', 'Cảm ơn! Bạn đã xác nhận nhận hàng.');
}

}
