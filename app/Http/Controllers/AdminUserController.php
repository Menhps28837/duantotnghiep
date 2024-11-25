<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\don_hang;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\themValid;
use Illuminate\Support\Facades\View;
use App\Models\Danh_Gia;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;
use App\Models\lien_he;
use App\Models\binh_luan;


use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();
use Illuminate\Http\Request;

class AdminUserController extends Controller
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
        $search = $request->input('search');

        if ($search) {
            $user = User::where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->paginate($perpage);
        } else {
            $user = User::paginate($perpage);
        }
    
        $thoiGianMoi = now()->subDay();
        return view('admin/user_ds', compact('user','thoiGianMoi'));
    }
    public function create()
    {
        return view('admin/user_them');
    }

    public function store(Request $request)
    {
        $obj = new  User;
        $obj->name = trim(strip_tags($request['name']));
        $obj->email = strtolower(trim(strip_tags($request['email'])));
        $obj->password = Hash::make($request['mk1']);
        $obj->dien_thoai = $request['dien_thoai'];
        $obj->dia_chi = $request['dia_chi'];
        $obj->role = (int) $request['role'];
        $obj->save();
        return redirect(route('user.index'))->with('thongbao2','Thêm user thành công');
    }

    public function show(string $id)
    {
       
    }

    public function edit(User $user)
    {
        return view('admin.user_chinh', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $obj = User::find($id);
        $obj->name = $request['name'];
        $obj->email = $request['email'];
        // $obj->password = $request['password'];
        $obj->dien_thoai = $request['dien_thoai'];
        $obj->dia_chi = $request['dia_chi'];
        $obj->role = (int) $request['role'];
        $obj->save();
        return redirect(route('user.index'))->with('thongbao2', 'Cập nhập thành công');
    }

    public function destroy(Request $request,  string $id)
    {
        $cokhong = User::where('id', $id)->exists();
        if ($cokhong==false) {
            $request->session()->flash('thongbao','User không tồn tại');
            return redirect(route('user.index'));
        }
        // Lấy user để có thể xóa các bản ghi liên quan
        $user = User::find($id);

        // Xóa các đơn hàng liên quan
        don_hang::where('id_user', $user->id)->delete();

        // Xóa user
        $user->delete();
        $request->session()->flash('thongbao', 'Đã xóa user');
        return redirect(route('user.index'));
    }
}
