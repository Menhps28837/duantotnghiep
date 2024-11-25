<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation2;
use App\Models\don_hang; // Sử dụng model thực tế của bạn
use App\Models\don_hang_chi_tiet;
use App\Models\yeu_cau_tra_hang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\yeucautrahang;
use App\Models\Danh_Gia;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;

class OrderTrackingController extends Controller
{
    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr  );
    }   
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = DB::table('don_hang')
            ->where('id_user', auth()->id())
            ->orderBy('thoi_diem_mua_hang', 'desc')
            ->get();
    
        // Lấy các yêu cầu trả hàng của người dùng
        $returnRequests = DB::table('yeu_cau_tra_hang')
            ->where('id_user', auth()->id());
            // ->pluck('status', 'id_dh'); // Lấy trạng thái theo id_dh
    
        return view('user.donhang.order_tracking_index', compact('orders', 'returnRequests')); 
    }
    
    // Hiển thị thông tin chi tiết của đơn hàng
    public function show($id)
    {
        $donHang = don_hang::where('id', $id)
        ->where('id_user', auth()->id())
        ->first();

    if (!$donHang) {
        return redirect('/')->with('thongbao', 'Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.');
    }

    // Lấy chi tiết đơn hàng
    $orderDetails = don_hang_chi_tiet::where('id_dh', $id)->get();

    $productId = $orderDetails->first()->id_sp;

    $returnRequest = DB::table('yeu_cau_tra_hang')
    ->where('id_dh', $id)
    ->where('id_user', auth()->id())
    ->first();

    return view('user.donhang.order_tracking', compact('donHang', 'orderDetails', 'returnRequest','productId'));
    }
    public function cancel($id)
    {
        // Lấy đơn hàng dựa trên ID và kiểm tra quyền truy cập
        $donHang = don_hang::where('id', $id)
            ->where('id_user', auth()->id())
            ->first();

        if (!$donHang) {
            return redirect('/')->with('thongbao', 'Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.');
        }
        // Kiểm tra trạng thái đơn hàng
        if ($donHang->trang_thai == 2) {
            return redirect()->route('user.donhang.order.tracking.index')->with('thongbao', 'Đơn hàng này đã hủy rồi.');
        }

        // Cập nhật trạng thái đơn hàng thành hủy
        $donHang->trang_thai = 2 ; // Hoặc giá trị trạng thái phù hợp
        $donHang->save();

        return redirect()->route('user.donhang.order.tracking.index')->with('thongbao2', 'Đơn hàng đã được hủy thành công.');
    }
    public function mualai($id)
{
    // Lấy đơn hàng dựa trên ID và kiểm tra quyền truy cập
    $donHang = don_hang::with('don_hang_chi_tiets')->where('id', $id)
        ->where('id_user', auth()->id())
        ->first();

    if (!$donHang) {
        return redirect('/')->with('thongbao', 'Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.');
    }

    // Kiểm tra trạng thái của đơn hàng
    if ($donHang->trang_thai == 2) {
        // Nếu trạng thái là 2 (Đã hủy), phục hồi trạng thái
        $donHang->trang_thai = 0; // Đang chờ xác minh
        $donHang->save();

        return redirect()->route('user.donhang.order.tracking.index')->with('thongbao2', 'Đơn hàng đã được phục hồi thành công.');
    } elseif ($donHang->trang_thai == 4 || $donHang->trang_thai == 5) {
        // Nếu trạng thái là 4 hoặc 5, tạo đơn hàng mới
        $newOrder = new don_hang();
        $newOrder->id_user = $donHang->id_user;
        $newOrder->ten_nguoi_nhan = $donHang->ten_nguoi_nhan;
        $newOrder->email = $donHang->email;
        $newOrder->dien_thoai = $donHang->dien_thoai;
        $newOrder->dia_chi_giao = $donHang->dia_chi_giao;
        $newOrder->thoi_diem_mua_hang = now();
        $newOrder->tong_so_luong = $donHang->tong_so_luong;
        $newOrder->tong_tien = $donHang->tong_tien;
        $newOrder->trang_thai = 0; // Đang chờ xác minh
        $newOrder->loai_thanh_toan = $donHang->loai_thanh_toan; // Giữ nguyên phương thức thanh toán

        // Lưu đơn hàng mới
        $newOrder->save();

        // Kiểm tra nếu chi tiết đơn hàng tồn tại trước khi lặp
        if ($donHang->don_hang_chi_tiets) {
            foreach ($donHang->don_hang_chi_tiets as $detail) {
                $newDetail = new don_hang_chi_tiet();
                $newDetail->id_dh = $newOrder->id; // Sửa lại tên trường nếu cần
                $newDetail->id_sp = $detail->id_sp;
                $newDetail->so_luong = $detail->so_luong;
                $newDetail->gia_km = $detail->gia_km;
                $newDetail->ten_sp = $detail->ten_sp;
                $newDetail->hinh = $detail->hinh;
                $newDetail->save();
            }
        }
        
        return redirect()->route('user.donhang.order.tracking.index')->with('thongbao2', 'Đơn hàng mới đã được tạo thành công.');
    }
    
    return redirect()->route('user.donhang.order.tracking.index')->with('thongbao', 'Không thể mua lại đơn hàng này.');
}

public function yeucautrahang(Request $request, $id)
{
    $request->validate([
        'lydo' => 'required|string|max:255',
        'reasons' => 'array',
        'reasons.*' => 'string|max:255',
    ]);

    // Lấy đơn hàng
    $donHang = don_hang::where('id', $id)->where('id_user', auth()->id())->first();

    if (!$donHang) {
        return redirect()->back()->with('error', 'Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.');
    }

    // Tính thời gian đã qua kể từ khi mua hàng
    
    if (now()->diffInDays($donHang->thoi_diem_mua_hang) > 2) {
        return redirect()->back()->with('thongbao', 'Không thể yêu cầu trả hàng vì đã quá 2 ngày kể từ thời điểm đặt hàng.');
    }

    // Xử lý yêu cầu trả hàng
    $trahang = new yeu_cau_tra_hang();
    $trahang->id_dh = $donHang->id;
    $trahang->lydo = $request->lydo;
    $trahang->reasons = json_encode($request->reasons); // Lưu lý do dưới dạng JSON
    $trahang->id_user = auth()->id();
    $trahang->save();

    // Cập nhật trạng thái đơn hàng
    $donHang->trang_thai = 6; // Giả sử trạng thái 6 là "Đang chờ xử lý trả hàng"
    $donHang->save();

    // Gửi email
    Mail::to($donHang->email)->send(new yeucautrahang($donHang, $request->reasons, $trahang));

    // Trả về view với biến checktime
    return redirect()->route('user.donhang.order.tracking.index')->with('thongbao2', 'Yêu cầu trả hàng đã được gửi thành công.');

}

// Thêm đánh giá
public function danhgia(Request $request, $orderId)
{
    // Kiểm tra id_sp và id_dh hợp lệ
    if (!$request->has('id_sp') || !$request->has('id_dh') || !is_array($request->id_sp) || count($request->id_sp) == 0) {
        return back()->with('error', 'Sản phẩm hoặc đơn hàng không hợp lệ.');
    }

    // Validate dữ liệu
    $request->validate([
        'rating' => 'required|array',  // Đảm bảo rating là mảng
        'rating.*' => 'in:0,1,2',      // Đảm bảo các giá trị rating là hợp lệ
        'comment' => 'required|array', // Đảm bảo comment là mảng
        'comment.*' => 'string|max:255', // Đảm bảo comment hợp lệ
    ]);

    // Lấy đơn hàng từ bảng don_hang
    $order = don_hang::find($orderId);

    if (!$order) {
        return back()->with('error', 'Đơn hàng không tồn tại.');
    }

    // Lặp qua các sản phẩm trong chi tiết đơn hàng
    foreach ($order->don_hang_chi_tiets as $index => $orderDetail) {
        // Kiểm tra id_sp trong request có hợp lệ
        if (isset($request->id_sp[$index])) {
            $review = new Danh_Gia();
            $review->id_user = auth()->id();
            $review->id_sp = $request->id_sp[$index];  // Sản phẩm
            $review->id_dh = $request->id_dh;          // Đơn hàng
            $review->rating = $request->rating[$index]; // Mức đánh giá
            $review->comment = $request->comment[$index]; // Bình luận cho sản phẩm
            $review->save();
        }
    }

    return back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được gửi cho tất cả sản phẩm trong đơn hàng.');
}

public function xemdanhgia($id)
{
    $reviews = Danh_Gia::where('id_sp', $id)->get(); // Lấy tất cả các đánh giá cho sản phẩm
    $reviewCount = $reviews->count(); // Tổng số lượt đánh giá

    return view('user.sanpham.chitiet', compact( 'reviews', 'reviewCount'));
}





}

