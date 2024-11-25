<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\san_pham;
use App\Models\Danh_Gia;
use App\Models\User;
use App\Models\loai;
use App\Models\thuoc_tinh;
use App\Models\lien_he;
use App\Models\so_luong_ton_kho;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\don_hang;
use App\Models\binh_luan;


use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();


class AdminSPController extends Controller {
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
    
    public function index(Request $request) {
        $id_loai = $request->input('id_loai', -1);
        $trangthai = $request->input('trangthai', 'chuaxoa');
        $query = $request->input('search'); 
        $perpage = env('PER_PAGE');
        $loai_arr = loai::all();
    
        // Lấy danh sách sản phẩm
        $sanpham_arr = san_pham::query();
    
        // Lọc theo trạng thái
        if ($trangthai == "daxoa") {
            $sanpham_arr = $sanpham_arr->onlyTrashed();
        }
    
        // Lọc theo loại
        if ($id_loai > 0) {
            $sanpham_arr = $sanpham_arr->where('id_loai', $id_loai);
        }
    
        // Tìm kiếm
        if ($query) {
            $sanpham_arr = $sanpham_arr->where(function($q) use ($query) {
                $q->where('ten_sp', 'LIKE', "%{$query}%")
                  ->orWhere('mo_ta', 'LIKE', "%{$query}%");
            });
        }
    
        $sanpham_arr = $sanpham_arr->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    
        // Lấy thông tin tồn kho cho từng sản phẩm
        foreach ($sanpham_arr as $sp) {
            $sp->ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first()->so_luong_con_lai ?? 0;
        }
    
        if ($trangthai == "daxoa") {
            // Trả về view sanpham_daxoa khi lọc sản phẩm đã xóa
            return view('admin.sanpham_daxoa', compact(['trangthai', 'id_loai', 'sanpham_arr', 'loai_arr', 'query']));
        } else {
            // Trả về view sanpham_ds cho sản phẩm chưa xóa
            return view('admin.sanpham_ds', compact(['trangthai', 'id_loai', 'sanpham_arr', 'loai_arr', 'query']));
        }
    }
    
    public function create()
    {
        $loai_arr = DB::table('loai')->orderBy('thu_tu')->get();
        return view('admin.sanpham_them',compact('loai_arr'));
    }
    public function store(Request $request)
    {
        $obj = new  san_pham;
        $obj->ten_sp = $request['ten_sp'];
        $obj->slug = Str::slug($obj->ten_sp);
        $obj->gia = (int) $request['gia'];
        $obj->gia_km = (int) $request['gia_km'];
        $obj->id_loai = (int) $request['id_loai'];
        $obj->ngay = $request['ngay'];  
        $obj->hinh = $request['hinh'];
        $obj->an_hien = $request['an_hien'];
        $obj->tinh_chat = (int) $request['tinh_chat'];
        $obj->an_hien = (int) $request['an_hien'];
        $obj->hot = (int) $request['hot'];
        $obj->mo_ta = $request['mo_ta'];   
        $obj->save();

           // Thêm số lượng tồn kho
        $tonKho = new so_luong_ton_kho;
        $tonKho->id_sp = $obj->id; 
        $tonKho->so_luong_con_lai = (int) $request['so_luong_con_lai']; 
        $tonKho->so_luong_canh_bao = 10; 
        $tonKho->save();

        return redirect(route('sanpham.index'))->with('thongbao2','Thêm thành công');
    
    }
    
    public function show(string $id)
    {
        //
    }
    public function edit( Request $request , string $id) {
        $sp = san_pham::where('id', $id)->first();
        if ($sp==null){
            $request->session()->flash('thongbao','Không có sản phẩm này: '. $id);
            return redirect('/admin/sanpham');
        }

        $ton_kho = so_luong_ton_kho::where('id_sp', $id)->first();
        $sp->ton_kho = $ton_kho->so_luong_con_lai ?? 0;
        
        $loai_arr = DB::table('loai')->orderBy('thu_tu')->get();
        return view('admin/sanpham_chinh' , compact(['sp','loai_arr']));
    }
    
    public function update(Request $request, string $id) {
        $obj = san_pham::find($id);
        $obj->ten_sp = $request['ten_sp'];
        $obj->slug = Str::slug($obj->ten_sp);     
        $obj->gia = (int) $request['gia'];
        $obj->gia_km = (int) $request['gia_km'];
        $obj->an_hien = (int) $request['an_hien'];
        $obj->hot = (int) $request['hot'];
        $obj->id_loai = (int) $request['id_loai'];
        $obj->tinh_chat = (int) $request['tinh_chat'];
        $obj->ngay = $request['ngay']; 
        $obj->hinh = $request['hinh']; 
        $obj->mo_ta = $request['mo_ta'];

        $ton_kho = so_luong_ton_kho::where('id_sp', $id)->first();
        if ($ton_kho) {
            $ton_kho->so_luong_con_lai = (int) $request['ton_kho'];
            $ton_kho->save();
        } else {
            // Nếu chưa có bản ghi tồn kho, tạo mới
            so_luong_ton_kho::create([
                'id_sp' => $id,
                'so_luong_con_lai' => (int) $request['ton_kho'],
            ]);
        }

        $obj->save();
        return redirect(route('sanpham.index'))->with('thongbao2', 'Cập nhập thành công');
    }
    
    public function destroy(Request $request,  string $id)
    {
        $cokhong = san_pham::where('id', $id)->exists();
        if ($cokhong==false) {
            $request->session()->flash('thongbao','Sản phẩm không tồn tại');
            return redirect('/admin/sanpham');
        }
        san_pham::where('id', $id)->delete();
        $request->session()->flash('thongbao', 'Sản phẩm đã được xóa mềm');
        return redirect('/admin/sanpham');

    }
     // Hiển thị sản phẩm khuyến mãi
     public function showKhuyenMai(Request $request) {
        $khuyenmai_arr = DB::table('khuyen_mai')
            ->join('san_pham', 'khuyen_mai.id_sp', '=', 'san_pham.id')
            ->select('khuyen_mai.*', 'san_pham.ten_sp')
            ->paginate(env('PER_PAGE'));

        return view('admin.khuyenmai', compact('khuyenmai_arr'));
    }

    // Cập nhật thông tin khuyến mãi
    public function updateKhuyenMai(Request $request) {
        $request->validate([
            'id' => 'required|integer',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'gia_km' => 'required|numeric',
        ]);

        DB::table('khuyen_mai')
            ->where('id', $request->id)
            ->update([
                'ngay_bat_dau' => $request->ngay_bat_dau,
                'ngay_ket_thuc' => $request->ngay_ket_thuc,
                'gia_km' => $request->gia_km,
            ]);

        return redirect()->route('admin.khuyenmai')->with('success', 'Cập nhật thành công!');
    }
    public function khoiphuc($id) {
        // Tìm sản phẩm đã bị xóa
        $sp = san_pham::withTrashed()->find($id);
    
        if ($sp == null) {
            return redirect('/thongbao')->with('thongbao', 'Sản phẩm không tồn tại.');
        }
    
        // Khôi phục sản phẩm
        $sp->restore();
    
        // Lấy lại các tham số từ request (có thể là từ form lọc, tìm kiếm)
        $id_loai = request('id_loai', -1);  // Lấy id_loai từ query string
        $trangthai = request('trangthai', 'chuaxoa'); // Trạng thái mặc định là "chuaxoa"
        $query = request('search'); // Tìm kiếm nếu có
        $perpage = env('PER_PAGE'); // Số lượng sản phẩm trên mỗi trang
        $loai_arr = loai::all();  // Lấy danh sách loại sản phẩm
    
        // Lấy danh sách sản phẩm (cùng với các điều kiện lọc)
        $sanpham_arr = san_pham::query();
    
        // Lọc theo trạng thái
        if ($trangthai == "daxoa") {
            $sanpham_arr = $sanpham_arr->onlyTrashed();
        }
    
        // Lọc theo loại
        if ($id_loai > 0) {
            $sanpham_arr = $sanpham_arr->where('id_loai', $id_loai);
        }
    
        // Tìm kiếm
        if ($query) {
            $sanpham_arr = $sanpham_arr->where(function($q) use ($query) {
                $q->where('ten_sp', 'LIKE', "%{$query}%")
                  ->orWhere('mo_ta', 'LIKE', "%{$query}%");
            });
        }
    
        // Phân trang
        $sanpham_arr = $sanpham_arr->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    
        // Lấy thông tin tồn kho cho từng sản phẩm
        foreach ($sanpham_arr as $sp) {
            $sp->ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first()->so_luong_con_lai ?? 0;
        }
    
        // Trả về view với các biến cần thiết
        return view('admin.sanpham_ds', compact('trangthai', 'id_loai', 'sanpham_arr', 'loai_arr', 'query'))->with('thongbao2','Khôi phục sản phẩm thành công!');
    }
    
    // function xoavinhvien($id) {
    //     $sp = san_pham::withTrashed()->find($id);
    //     if ($sp == null) return redirect('/thongbao');

    //     $tt = thuoc_tinh::where('id_sp', $id);
    //     if($tt!=null) $tt->delete();
    //     $sp->forceDelete();
    //     return redirect('/admin/sanpham?trangthai=daxoa');
    // }

    public function xoavinhvien($id, Request $request)
    {
        // Tìm sản phẩm đã bị xóa (soft delete) hoặc không có
        $sp = san_pham::withTrashed()->find($id);
        if ($sp == null) {
            return redirect('/thongbao')->with('thongbao', 'Sản phẩm không tồn tại.');
        }
    
        // Kiểm tra số lượng tồn kho của sản phẩm
        $ton_kho = so_luong_ton_kho::where('id_sp', $id)->first();
        if ($ton_kho && $ton_kho->so_luong_con_lai > 10) {
            // Nếu còn tồn kho lớn hơn 10, không cho phép xóa
            session()->flash('thongbao', 'Không thể xóa vĩnh viễn sản phẩm vì còn tồn kho.');
            return redirect('/admin/sanpham?trangthai=daxoa');
        }
    
        // Xóa các thuộc tính liên quan đến sản phẩm (nếu có)
        $tt = thuoc_tinh::where('id_sp', $id);
        if ($tt->exists()) {
            $tt->delete(); // Xóa các thuộc tính của sản phẩm
        }
    
        // Xóa vĩnh viễn sản phẩm
        $sp->forceDelete();
    
        // Các dữ liệu cần trả về cho view
        $trangthai = $request->input('trangthai', 'chuaxoa');
        $id_loai = $request->input('id_loai', -1);
        $loai_arr = loai::all();
        $query = $request->input('search', '');
    
        // Lấy danh sách sản phẩm sau khi xóa
        $sanpham_arr = san_pham::query();
    
        // Lọc theo trạng thái
        if ($trangthai == "daxoa") {
            $sanpham_arr = $sanpham_arr->onlyTrashed();
        }
    
        // Lọc theo loại
        if ($id_loai > 0) {
            $sanpham_arr = $sanpham_arr->where('id_loai', $id_loai);
        }
    
        // Tìm kiếm
        if ($query) {
            $sanpham_arr = $sanpham_arr->where(function($q) use ($query) {
                $q->where('ten_sp', 'LIKE', "%{$query}%")
                  ->orWhere('mo_ta', 'LIKE', "%{$query}%");
            });
        }
    
        $sanpham_arr = $sanpham_arr->orderBy('id', 'desc')->paginate(env('PER_PAGE'))->withQueryString();
    
        // Lấy thông tin tồn kho cho từng sản phẩm
        foreach ($sanpham_arr as $sp) {
            $sp->ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first()->so_luong_con_lai ?? 0;
        }
    
        // Trả về view với thông báo và các dữ liệu cần thiết
        return view('admin.sanpham_ds', compact('trangthai', 'id_loai', 'sanpham_arr', 'loai_arr', 'query'))->with('thongbao2', 'Xóa sản phẩm vĩnh viễn thành công!');
    }
    

}
