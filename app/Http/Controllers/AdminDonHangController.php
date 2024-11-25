<?php

namespace App\Http\Controllers;
use App\Models\Danh_Gia;
use App\Models\User;
use App\Models\don_hang;
use App\Models\don_hang_chi_tiet;
use App\Models\san_pham;
use App\Models\yeu_cau_tra_hang;
use App\Models\so_luong_ton_kho;
use App\Models\lien_he;
use App\Models\binh_luan;
use App\Models\Doanh_thu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDonHangXacNhan;
use App\Mail\Orderxacnhan;
use App\Mail\Orderdagiao;
use App\Mail\Orderguilai;
use App\Mail\PaymentReminder;
use App\Mail\Trahang;
use App\Mail\Traloitrahang;
use App\Mail\Tuchoitrahang;

use App\Models\thuoc_tinh;

use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

use Illuminate\Http\Request;

class AdminDonHangController extends Controller
{
    public function __construct()
    {
        $canh_bao_san_pham = $this->getCanhBaoSanPham();
        $canh_bao_tra_hang = $this->getCanhBaoTraHang();
        $canh_bao_khach_hang_moi = $this->getKhachHangMoi();
        $canh_bao_don_hang_moi = $this->getDonHangMoi();
        $canh_bao_lien_he_moi = $this->getLienHeMoi();
        $canh_bao_binh_luan_moi = $this->getBinhLuanMoi();
        $canh_bao_danh_gia_moi = $this->getDanhGiaMoi();

    
        $tongtatca = count($canh_bao_san_pham) + count($canh_bao_tra_hang) +
                     count($canh_bao_khach_hang_moi) + count($canh_bao_don_hang_moi) +
                     count($canh_bao_lien_he_moi) + count($canh_bao_binh_luan_moi) + count($canh_bao_danh_gia_moi);
    
        View::share('tongtatca', $tongtatca);
        View::share('canh_bao_san_pham', $canh_bao_san_pham);
        View::share('canh_bao_tra_hang', $canh_bao_tra_hang);
        View::share('canh_bao_khach_hang_moi', $canh_bao_khach_hang_moi);
        View::share('canh_bao_don_hang_moi', $canh_bao_don_hang_moi);
        View::share('canh_bao_lien_he_moi', $canh_bao_lien_he_moi);
        View::share('canh_bao_binh_luan_moi', $canh_bao_binh_luan_moi);
        View::share('canh_bao_danh_gia_moi', $canh_bao_danh_gia_moi);
    }
    
    protected function getCanhBaoSanPham() {
        $canh_bao_san_pham = [];
        $san_phams = san_pham::where('an_hien', 1)->get();
    
        foreach ($san_phams as $sp) {
            $ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first();
            if ($ton_kho && $ton_kho->so_luong_con_lai <= 10) {
                $canh_bao_san_pham[] = "Sản phẩm <a href='" . route('sanpham.canh_bao') . "'>{$sp->ten_sp}</a> còn {$ton_kho->so_luong_con_lai} cái. Đang hiện";
            }
        }
    
        return $canh_bao_san_pham;
    }
    
    protected function getCanhBaoTraHang() {
        $canh_bao_tra_hang = [];
        $yeu_cau_tra_hang = don_hang::where('trang_thai', 6)->get();
    
        foreach ($yeu_cau_tra_hang as $donHang) {
            $canh_bao_tra_hang[] = "Có yêu cầu trả hàng từ khách hàng " . $donHang->ten_nguoi_nhan;
        }
    
        return $canh_bao_tra_hang;
    }
    
    protected function getKhachHangMoi() {
        $tong_kh_moi = User::where('created_at', '>=', now()->subHours(24))->count();
    
        if ($tong_kh_moi > 0) {
            $message = "Có {$tong_kh_moi} khách hàng mới.";
            session()->put('canh_bao_khach_hang_moi', [$message]); // Lưu vào session
            return [$message];
        } else {
            // Nếu không còn bình luận mới, xóa thông báo trong session
            session()->forget('canh_bao_khach_hang_moi');
        }
    
        return session()->get('canh_bao_khach_hang_moi', []);
    }

    private function getBinhLuanMoi() {
        $tong_binhluan_moi = binh_luan::where('thoi_diem', '>=', now()->subHours(24))->count();
        if ($tong_binhluan_moi > 0) {
            $message = "Có {$tong_binhluan_moi} bình luận mới.";
            session()->put('canh_bao_binh_luan_moi', [$message]); // Lưu vào session
        } else {
            // Nếu không còn bình luận mới, xóa thông báo trong session
            session()->forget('canh_bao_binh_luan_moi');
        }
    
        return session()->get('canh_bao_binh_luan_moi', []);
    }
    private function getDanhGiaMoi() {
        $tong_danh_gia_moi = Danh_Gia::where('created_at', '>=', now()->subHours(24))->count();
        if ($tong_danh_gia_moi > 0) {
            $message = "Có {$tong_danh_gia_moi} đánh giá mới.";
            session()->put('canh_bao_danh_gia_moi', [$message]); // Lưu vào session
        } else {
            // Nếu không còn bình luận mới, xóa thông báo trong session
            session()->forget('canh_bao_danh_gia_moi');
        }
    
        return session()->get('canh_bao_danh_gia_moi', []);
    }
    
    protected function getDonHangMoi() {
        $tong_don_hang_moi = don_hang::where('thoi_diem_mua_hang', '>=', now()->subHours(24))
        ->where('trang_thai', '0') // Chỉ lấy các đơn hàng có trạng thái '0'
        ->count();

        if ($tong_don_hang_moi === 0) {
            session()->forget('canh_bao_don_hang_moi');
        } else {
            $message = "Có {$tong_don_hang_moi} đơn hàng mới.";
            session()->put('canh_bao_don_hang_moi', [$message]);
        }
        
        return session()->get('canh_bao_don_hang_moi', []);
    }
    
    protected function getLienHeMoi() {
        $canh_bao_lien_he_moi = [];
        $tong_lien_he_moi = lien_he::where('created_at', '>=', now()->subDay())->count();
    
        if ($tong_lien_he_moi > 0) {
            $canh_bao_lien_he_moi[] = "Có {$tong_lien_he_moi} yêu cầu liên hệ mới.";
        }
    
        return $canh_bao_lien_he_moi;
    }


    public function index(Request $request)
    {
        $perpage = env('PER_PAGE');
    
        // Lấy từ khóa tìm kiếm từ request
        $query = $request->input('search');
    
        // Lấy danh sách đơn hàng
        $donhang = don_hang::where('trang_thai', 0);
    
        // Nếu có từ khóa tìm kiếm, lọc danh sách đơn hàng
        if ($query) {
            $donhang = $donhang->where(function($q) use ($query) {
                $q->Where('id', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('dien_thoai', 'LIKE', "%{$query}%")
                  ->orwhere('ten_nguoi_nhan', 'LIKE', "%{$query}%");
            });
        }
    
        $donhang = $donhang->paginate($perpage)->withQueryString();
        $thoiGianMoi = now()->subDay();
    
        return view('admin/donhang_ds', compact('donhang', 'thoiGianMoi', 'query'));
    }
    
    public function daxacnhan()
    {
        $donhang = don_hang::where('trang_thai', 1)->paginate(10)->withQueryString();
        return view('admin/donhang_ds_xacnhan', compact('donhang'));
    }
    public function dahuy()
    {
        $donhang = don_hang::where('trang_thai', 2)->paginate(10)->withQueryString();
        return view('admin/donhang_dahuy', compact('donhang'));
    }
    public function quashipper()
    {
        $donhang = don_hang::where('trang_thai', 3)->paginate(10)->withQueryString();
        return view('admin/donhang_quashipper', compact('donhang'));
    }
    // public function dagiao()
    // {
    //     $donhang = don_hang::where('trang_thai', 4)->paginate(10)->withQueryString();
    //     return view('admin/donhang_dagiao', compact('donhang'));
    // }
    public function khdaxacnhan()
    {
        $donhang5 = don_hang::where('trang_thai', 5)->paginate(10)->withQueryString();
        $donhang4 = don_hang::where('trang_thai', 4)->paginate(10)->withQueryString();
        return view('admin/donhang_daxong', compact('donhang5','donhang4'));
    }

    public function yeucautralai(){
        $donhang = don_hang::where('trang_thai', 6)
        ->with('yeu_cau_tra_hang')
        ->paginate(10)->withQueryString();
        $thoiGianMoi = now()->subDay();
        return view('admin/donhang_tralai', compact('donhang','thoiGianMoi'));
    }

    public function dachopheptralai(){
        $donhang = don_hang::where('trang_thai', 7)->paginate(10)->withQueryString();
        return view('admin/donhang_dachopheptralai', compact('donhang'));
    }

    public function datuchoi(){
        $donhang = don_hang::where('trang_thai', 8)->paginate(10)->withQueryString();
        return view('admin/donhang_datuchoi', compact('donhang'));
    }


    public function create()
    {
        return view('admin/donhang_them');
    }

    public function store(Request $request)
    {
        $obj = new  don_hang;
        $obj->ten_nguoi_nhan = $request['ten_nguoi_nhan'];
        $obj->email = $request['email'];
        $obj->dien_thoai = $request['dien_thoai'];
        $obj->dia_chi_giao = $request['dia_chi_giao'];
        $obj->trang_thai = (int) $request['trang_thai'];
        $obj->save();
        return redirect(route('donhang.index'))->with('thongbao2','Thêm thành công');
    }

    public function show(string $id)
    {
       
    }

    public function edit(don_hang $donhang)
    {
        return view('admin.donhang_chinh', compact('donhang'));
    }

    public function update(Request $request, string $id)
    {
        $obj = don_hang::find($id);
        $obj->ten_nguoi_nhan = $request['ten_nguoi_nhan'];
        $obj->email = $request['email'];
        $obj->dien_thoai = $request['dien_thoai'];
        $obj->dia_chi_giao = $request['dia_chi_giao'];
        $obj->trang_thai = (int) $request['trang_thai'];


        $obj->save();
        return redirect(route('donhang.index'))->with('thongbao2', 'Cập nhập thành công');
    }

    public function destroy(Request $request,  string $id)
    {
        $cokhong = don_hang::where('id', $id)->exists();
        if ($cokhong==false) {
            $request->session()->flash('thongbao','Đơn hàng không tồn tại');
            return redirect('/admin/donhang');
        }
        don_hang::where('id', $id)->delete();
        $request->session()->flash('thongbao2', 'Đã xóa đơn hàng');
        return redirect('/admin/donhang');
    }

    public function chitiet(Request $request, string $id)
    {
        $ctdh = don_hang_chi_tiet::where("id_dh", $id)->get();
        return view('admin.ctdh_ds', compact('ctdh'));
    }
    public function chitietxacnhan(Request $request, string $id)
    {
        $ctdh = don_hang_chi_tiet::where("id_dh", $id)->get();
        return view('admin.ctdh_ds_xacnhan', compact('ctdh'));
    }

    public function xacnhan(string $id)
    {
        $ctdh = don_hang::find($id);
        if ($ctdh->trang_thai == 1) {
            return redirect('/admin/donhangxacnhan')->with('info', 'Đơn hàng đã được xác nhận trước đó!');
        }

        $ctdh->trang_thai = 1;
        // $ctdh->trang_thai_thanh_toan = 2;
         // Cập nhật trạng thái thanh toán dựa trên loại thanh toán
        if ($ctdh->loai_thanh_toan == 0) {
            $ctdh->trang_thai_thanh_toan = 0; // Đã thanh toán bằng tiền mặt
        } elseif ($ctdh->loai_thanh_toan == 1) {
            $ctdh->trang_thai_thanh_toan = 2; // Đã chuyển khoản nhưng chưa xác minh
        }

        $ctdh->save();

         // Gửi email xác nhận
        // $this->sendOrderConfirmationEmail($ctdh);

        Mail::to($ctdh->email)->send(new OrderDonHangXacNhan($ctdh));
                
        return redirect('/admin/donhangxacnhan')->with('thongbao2','Đơn hàng đã được xác nhận');
        // return $this->createInvoice($ctdh);
    }
    // private function createInvoice($donhang)
    // {
    //     $ctdh = don_hang_chi_tiet::where('id_dh', $donhang->id)->get();

    //     // Tính tổng tiền
    //     $tongTien = $ctdh->sum(function ($item) {
    //         return $item->gia_km * $item->so_luong;
    //     });

    //     // Trả về view hóa đơn
    //     return view('admin.invoice', compact('donhang', 'ctdh', 'tongTien'));
    // }
    public function createInvoice($id)
    {
        $donhang = don_hang::find($id);
        $ctdh = don_hang_chi_tiet::where('id_dh', $donhang->id)->get();

        // Tính tổng tiền
        $tongTien = $ctdh->sum(function ($item) {
            return $item->gia_km * $item->so_luong;
        });

        // Trả về view hóa đơn
        return view('admin.invoice', compact('donhang', 'ctdh', 'tongTien'));
    }


    public function requestPayment(Request $request, $id)
{
    // Lấy thông tin đơn hàng
    $order = don_hang::find($id);
    
    // Kiểm tra nếu đơn hàng tồn tại
    if (!$order) {
        return redirect()->back()->with('thongbao', 'Đơn hàng không tồn tại.');
    }

    // Kiểm tra số lần đã gửi yêu cầu trong session
    $soLanGuiYeuCau = $request->session()->get("so_lan_gui_yeu_cau_{$id}", 0);

    if ($soLanGuiYeuCau >= 3) {
        // Hủy đơn hàng
        $order->trang_thai = 'huy'; // Hoặc trạng thái phù hợp với bạn
        $order->save();
        $request->session()->flash('thongbao', 'Đơn hàng đã bị hủy sau 3 lần yêu cầu chuyển khoản lại.');
        return redirect()->back();
    }

    // Tăng số lần gửi yêu cầu
    $request->session()->put("so_lan_gui_yeu_cau_{$id}", $soLanGuiYeuCau + 1);
    $soLanGuiYeuCau += 1; // Cập nhật số lần đã gửi

    // Gửi email nhắc nhở
    Mail::to($order->email)->send(new PaymentReminder($order));

    $request->session()->flash('thongbao2', "Đã gửi yêu cầu chuyển khoản lại lần thứ $soLanGuiYeuCau đến khách hàng.");

    return redirect()->back();
}



    public function giaohang(Request $request, string $id)
    {
        // Kiểm tra xem đơn hàng có tồn tại không
        $donHang = don_hang::find($id);
        if ($donHang->trang_thai == 3) {
            return redirect('/admin/donhangquashipper')->with('info', 'Đơn hàng đã chuyển qua shipper trước đó!');
        }
        
        $donHang->trang_thai = 3;
        $donHang->save();
    
        // Gửi email thông báo
        Mail::to($donHang->email)->send(new Orderxacnhan($donHang));
    
        $request->session()->flash('thongbao2', 'Đơn hàng đã chuyển qua shipper và gửi email thông báo cho khách hàng');
        return redirect('/admin/donhangquashipper');
    }
    public function datoi(Request $request, string $id)
    {
        // Kiểm tra xem đơn hàng có tồn tại không
        $donHang = don_hang::find($id);
        if ($donHang->trang_thai == 4) {
            return redirect('/admin/donhangdaxong')->with('info', 'Đơn hàng đã giao thành công trước đó!');
        }
        
        $donHang->trang_thai = 4;
        $donHang->save();

         // Cập nhật doanh thu
        $thang = now()->month;
        $nam = now()->year;

        $tongDoanhThuThang = don_hang::whereIn('trang_thai', [4, 5])
        ->whereMonth('thoi_diem_mua_hang', $thang)
        ->whereYear('thoi_diem_mua_hang', $nam)
        ->sum('tong_tien');

        // Kiểm tra xem đã có doanh thu cho tháng và năm này chưa
        $doanhThu = doanh_thu::where('thang', $thang)->where('nam', $nam)->first();

        if ($doanhThu) {
            $doanhThu->tong_doanh_thu = $tongDoanhThuThang;
        } else {
            $doanhThu = new doanh_thu();
            $doanhThu->thang = $thang;
            $doanhThu->nam = $nam;
            $doanhThu->tong_doanh_thu = $tongDoanhThuThang;
        }
        $doanhThu->so_luong_don_hang += 1; 
        $doanhThu->save();
    
        $orderDetails = don_hang_chi_tiet::where('id_dh', $id)->get();
        // Gửi email thông báo
        Mail::to($donHang->email)->send(new Orderdagiao($donHang, $orderDetails));
    
        $request->session()->flash('thongbao2', 'Đơn hàng đã giao thành công và gửi email thông báo cho khách hàng');
        return redirect('/admin/donhangdaxong');
    }
    public function guilai(Request $request, string $id)
    {
        // Kiểm tra xem đơn hàng có tồn tại không
        $donHang = don_hang::find($id);

        // Kiểm tra số lần đã gửi email trong session
        $soLanGuiEmail = $request->session()->get("so_lan_gui_email_{$id}", 0);

        if ($soLanGuiEmail >= 3) {
            $request->session()->flash('thongbao', 'Đã gửi email xác nhận 3 lần. Không thể gửi thêm.');
            return redirect('/admin/donhangdaxong');
        }

        // Gửi email thông báo
        $orderDetails = don_hang_chi_tiet::where('id_dh', $id)->get();
        Mail::to($donHang->email)->send(new Orderguilai($donHang, $orderDetails));

        // Tăng số lần gửi email
        $request->session()->put("so_lan_gui_email_{$id}", $soLanGuiEmail + 1);
        $soLanGuiEmail += 1; // Cập nhật số lần đã gửi

        $request->session()->flash('thongbao2', "Gửi email thông báo lần thứ $soLanGuiEmail cho khách hàng thành công");
        return redirect('/admin/donhangdaxong');
    }

    public function thanhtoanvaxacnhan(Request $request, string $id)
    {
        // Kiểm tra xem đơn hàng có tồn tại không
        $donHang = don_hang::find($id);
        if (!$donHang || $donHang->trang_thai != 4) {
            return redirect('/admin/donhangdaxong')->with('error', 'Đơn hàng không tồn tại hoặc chưa được giao!');
        }
        
        // Thay đổi trạng thái đơn hàng từ 4 sang 5
        $donHang->trang_thai = 5;
        $donHang->trang_thai_thanh_toan = 2;
        $donHang->save();

        $request->session()->flash('thongbao3', 'Đơn hàng đã được xác nhận!');
        return redirect('/admin/donhangdaxong');
    }

    public function traloitrahang(Request $request, $id)
    {
        $request->validate([
            'cauHoi' => 'required|string|max:255',
        ]);

        // Tìm đơn hàng
        $donHang = don_hang::findOrFail($id);

        $yeuCauTraHang = yeu_cau_tra_hang::where('id_dh', $id)->first();
        $reasons = json_decode($yeuCauTraHang->reasons, true);  

        // Gửi email tới khách hàng với câu hỏi
        Mail::to($donHang->email)->send(new Traloitrahang($donHang, $request->cauHoi, $reasons, $yeuCauTraHang));

        return redirect()->back()->with('thongbao2', 'Đã gửi câu hỏi cho khách hàng.');
    }


    public function chopheptralai($id){
        // Lấy yêu cầu trả hàng (giả sử bạn có model tương ứng)
    $cptrahang = yeu_cau_tra_hang::where('id_dh', $id)->first();

    if (!$cptrahang) {
        return redirect()->back()->with('error', 'Yêu cầu trả hàng không tồn tại.');
    }

    // Cập nhật trạng thái đơn hàng
    $donHang = don_hang::find($id);
    if (!$donHang) {
        return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
    }

    if (!$donHang) {
        return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
    }

    // Cập nhật trạng thái đơn hàng
    $donHang->trang_thai = 7; 
    $donHang->save();

      // Cập nhật doanh thu: giảm doanh thu khi trả hàng
      $thang = now()->month;
      $nam = now()->year;
  
      // Tìm doanh thu cho tháng và năm hiện tại
      $doanhThu = doanh_thu::where('thang', $thang)->where('nam', $nam)->first();
  
      if ($doanhThu) {
          // Giảm doanh thu và số lượng đơn hàng
          $doanhThu->tong_doanh_thu -= $donHang->tong_tien; // Giảm tổng doanh thu
          $doanhThu->so_luong_don_hang -= 1; // Giảm số lượng đơn hàng
          // Nếu số lượng đơn hàng bằng 0, có thể xóa doanh thu, nếu cần
          if ($doanhThu->so_luong_don_hang <= 0) {
              $doanhThu->delete();
          } else {
              $doanhThu->save();
          }
      }

    Mail::to($donHang->email)->send(new Trahang($donHang));

    return redirect('/admin/donhangdachopheptralai')->with('thongbao2', 'Yêu cầu trả hàng đã được xác nhận.');
    }

    public function tuchoitralai($id){
        $cptrahang = yeu_cau_tra_hang::where('id_dh', $id)->first();

        if (!$cptrahang) {
            return redirect()->back()->with('error', 'Yêu cầu trả hàng không tồn tại.');
        }
    
        // Cập nhật trạng thái đơn hàng
        $donHang = don_hang::find($id);
        if (!$donHang) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
    
        if (!$donHang) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
    
        // Cập nhật trạng thái đơn hàng
        $donHang->trang_thai = 8; 
        $donHang->save();
    
        Mail::to($donHang->email)->send(new Tuchoitrahang($donHang));
    
        return redirect('/admin/donhangdatuchoi')->with('thongbao', 'Yêu cầu trả hàng không được chấp nhận.');
    }
    


    




    // public function sendOrderConfirmationEmail(don_hang $order)
    // {
    //     Mail::to($order->email)->send(new Orderxacnhan($order));
    // }

}
