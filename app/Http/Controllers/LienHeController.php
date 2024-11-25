<?php

namespace App\Http\Controllers;

use App\Http\Requests\lienheValid;
use Illuminate\Http\Request;
use App\Models\lien_he;
use App\Models\User;
use App\Models\binh_luan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Models\san_pham;
use App\Models\don_hang;
use App\Models\so_luong_ton_kho;
use App\Mail\Lienhe;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

class LienHeController extends Controller
{
    public function __construct()
    {
        $loai_arr = DB::table('loai')->where('an_hien', 1)->orderBy('thu_tu')->get();
        View::share('loai_arr', $loai_arr);
        
        $canh_bao_san_pham = $this->getCanhBaoSanPham();
        $canh_bao_tra_hang = $this->getCanhBaoTraHang();
        $canh_bao_khach_hang_moi = $this->getKhachHangMoi();
        $canh_bao_don_hang_moi = $this->getDonHangMoi();
        $canh_bao_lien_he_moi = $this->getLienHeMoi();
        $canh_bao_binh_luan_moi = $this->getBinhLuanMoi();

    
        $tongtatca = count($canh_bao_san_pham) + count($canh_bao_tra_hang) +
                     count($canh_bao_khach_hang_moi) + count($canh_bao_don_hang_moi) +
                     count($canh_bao_lien_he_moi) + count($canh_bao_binh_luan_moi);
    
        View::share('tongtatca', $tongtatca);
        View::share('canh_bao_san_pham', $canh_bao_san_pham);
        View::share('canh_bao_tra_hang', $canh_bao_tra_hang);
        View::share('canh_bao_khach_hang_moi', $canh_bao_khach_hang_moi);
        View::share('canh_bao_don_hang_moi', $canh_bao_don_hang_moi);
        View::share('canh_bao_lien_he_moi', $canh_bao_lien_he_moi);
        View::share('canh_bao_binh_luan_moi', $canh_bao_binh_luan_moi);
    }
    
    protected function getCanhBaoSanPham() {
        $canh_bao_san_pham = [];
        $san_phams = san_pham::where('an_hien', 1)->get();
    
        foreach ($san_phams as $sp) {
            $ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first();
            if ($ton_kho && $ton_kho->so_luong_con_lai <= 10) {
                $canh_bao_san_pham[] = "Sản phẩm <a href='" . route('sanpham.edit', $sp->id) . "'>{$sp->ten_sp}</a> còn {$ton_kho->so_luong_con_lai} cái. Đang hiện";
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
        $warnings = [];
        $tong_lien_he_moi = lien_he::where('thoi_gian', '>=', now()->subHours(24))->count();
        if ($tong_lien_he_moi > 0) {
            $warnings[] = "Có {$tong_lien_he_moi} yêu cầu liên hệ mới.";
        }
        return $warnings;
    }


  

    public function create()
    {
        return view('user.trangchu.lienhe');
    }

    public function store(lienheValid $request)
    {
        $data = [
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'dien_thoai' => $request->dien_thoai,
            'noi_dung' => $request->noi_dung,
            'thoi_gian' => now(),
        ];
    
        lien_he::create($data);
    
        // Gửi email cho admin
        Mail::to('tieuanhcuong2004@gmail.com')->send(new Lienhe($data));
    
        return redirect()->back()->with('thongbao', 'Thông tin liên hệ đã được gửi!');
    }

    public function index(Request $request)
    {
        $perpage = env('PER_PAGE');
        $lienHe = lien_he::orderBy('thoi_gian', 'desc');
        $query = $request->input('search');

        if ($query) {
            $lienHe = $lienHe->where(function($q) use ($query) {
                $q->Where('ho_ten', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            });
        }
        $lienHe = $lienHe->paginate($perpage)->withQueryString();

        $thoiGianMoi = now()->subDay();
        return view('admin.lienhe', compact('lienHe','thoiGianMoi', 'query'));
    }
    public function destroy($id)
    {
        $lienHe = lien_he::findOrFail($id);
        $lienHe->delete();

        return redirect()->back()->with('thongbao', 'Liên hệ đã được xóa thành công!');
    }
    public function traloi(Request $request, $id)
    {
        $request->validate([
            'noi_dung' => 'required|string',
        ]);

        $lienHe = lien_he::findOrFail($id);

        // Gửi email trả lời
        Mail::to($lienHe->email)->send(new \App\Mail\TraLoiLienHe($request->noi_dung));

        return redirect()->back()->with('thongbao', 'Email trả lời đã được gửi thành công!');
    }
}
