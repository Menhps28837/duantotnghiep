<?php
namespace App\Http\Controllers;

use App\Http\Requests\dangnhapValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App\Models\loai;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;
use App\Models\don_hang;
use App\Models\lien_he;
use App\Models\User;
use App\Models\yeu_cau_tra_hang;
use App\Models\binh_luan;
use App\Models\Danh_Gia;
use App\Models\Doanh_thu;
use App\Models\TinTuc;
use Session;

use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

class AdminController extends Controller {
    
    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien', 1)->orderBy('thu_tu')->get();
        View::share('loai_arr', $loai_arr);
    
        $this->shareCanhBao();
    }
    
    protected function shareCanhBao() {
        $canh_bao_san_pham = $this->getCanhBaoSanPham();
        $canh_bao_tra_hang = $this->getCanhBaoTraHang();
        $canh_bao_khach_hang_moi = $this->getKhachHangMoi();
        $canh_bao_don_hang_moi = $this->getDonHangMoi();
        $canh_bao_lien_he_moi = $this->getLienHeMoi();
        $canh_bao_binh_luan_moi = $this->getBinhLuanMoi();
        $canh_bao_danh_gia_moi = $this->getDanhGiaMoi();

    
        $tongtatca = count($canh_bao_san_pham) + count($canh_bao_tra_hang) +
                     count($canh_bao_khach_hang_moi) + count($canh_bao_don_hang_moi) +
                     count($canh_bao_lien_he_moi) + count($canh_bao_binh_luan_moi) + 
                     count($canh_bao_danh_gia_moi);
    
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
                $canh_bao_san_pham[] = "Sản phẩm <a href='" .  route('sanpham.canh_bao') . "'>{$sp->ten_sp}</a> còn {$ton_kho->so_luong_con_lai} cái. Đang hiện";
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

    // public function deleteNotification(Request $request)
    // {
    //     // Xóa thông báo khỏi session
    //     session()->forget('has_viewed_customer_notification');
    
    //     return response()->json(['success' => true]);
    // }


    function index() { 
        $canh_bao_san_pham = $this->checkSanPhamWarning();
        $canh_bao_tra_hang = $this->checkTraHangWarning();
        $canh_bao_khach_hang_moi = $this->checkKhachHangMoi();
        $canh_bao_don_hang_moi = $this->checkDonHangMoi();
        $canh_bao_lien_he_moi = $this->checkLienHeMoi();
        $canh_bao_binh_luan_moi = $this->checkBinhLuanMoi();
        $canh_bao_danh_gia_moi = $this->checkDanhGiaMoi();

    
        $tongtatca = count($canh_bao_san_pham) + count($canh_bao_tra_hang) + count($canh_bao_khach_hang_moi) +
                     count($canh_bao_don_hang_moi) + count($canh_bao_lien_he_moi) + count($canh_bao_binh_luan_moi)+
                     count($canh_bao_danh_gia_moi);


        $tong_loai = loai::count(); 
        $tong_sanpham = san_pham::count();
        $tong_sanpham_saphethang = so_luong_ton_kho::where('so_luong_con_lai', '<=', 10)->count();
        $tong_donhang = don_hang::count();
        $tong_donhang_dahuy = don_hang::whereIn('trang_thai', [2])->count();
        $tong_donhang_dangchuanbi = don_hang::whereIn('trang_thai', [1, 3,])->count();
        $tong_donhang_daxong = don_hang::whereIn('trang_thai', [4, 5])->count();
        $tong_kh = User::count();
        $tong_lh = lien_he::count();
        $tong_trahang = yeu_cau_tra_hang::count();
        $tong_trahang_chophep = don_hang::whereIn('trang_thai',[7])->count();
        $tong_trahang_tuchoi = don_hang::whereIn('trang_thai',[8])->count();
        $tong_binhluan = binh_luan::count();
        $tong_tintuc = TinTuc::count();
        $tong_danhgia = Danh_Gia::count();
        $tong_doanhthu =Doanh_thu::sum('tong_doanh_thu');
    
        return view("admin/index", compact('canh_bao_san_pham', 'canh_bao_tra_hang', 
            'tongtatca', 'canh_bao_khach_hang_moi', 'canh_bao_don_hang_moi', 'canh_bao_lien_he_moi',

        'tong_loai', 'tong_sanpham', 'tong_sanpham_saphethang',
        'tong_donhang', 'tong_donhang_dahuy', 'tong_donhang_dangchuanbi', 'tong_donhang_daxong', 
        'tong_kh', 'tong_lh', 
        'tong_trahang', 'tong_trahang_chophep', 'tong_trahang_tuchoi',
        'tong_binhluan', 'tong_tintuc','tong_danhgia','tong_doanhthu')); 
    }
    
    private function checkSanPhamWarning() {
        $warnings = [];
        $san_phams = san_pham::where('an_hien', 1)->get();
        foreach ($san_phams as $sp) {
            $ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first();
            if ($ton_kho && $ton_kho->so_luong_con_lai <= 10) {
                $warnings[] = "Sản phẩm <a href='" .  route('sanpham.canh_bao') . "'>{$sp->ten_sp}</a> còn {$ton_kho->so_luong_con_lai} cái.";
            }
        }
        return $warnings;
    }
    
    private function checkTraHangWarning() {
        $warnings = [];
        $yeu_cau_tra_hang = don_hang::where('trang_thai', 6)->get();
        foreach ($yeu_cau_tra_hang as $donHang) {
            $warnings[] = "Có yêu cầu trả hàng từ khách hàng " . $donHang->ten_nguoi_nhan;
        }
        return $warnings;
    }
    
    private function checkKhachHangMoi() {
        $tong_kh_moi = User::where('created_at', '>=', now()->subHours(24))->count();
    
        if ($tong_kh_moi > 0) {
            $message = "Có {$tong_kh_moi} khách hàng mới.";
            session()->put('canh_bao_khach_hang_moi', [$message]); 
            return [$message];
        } else {
            session()->forget('canh_bao_khach_hang_moi');
        }
    
        return session()->get('canh_bao_khach_hang_moi', []);
    }
    private function checkBinhLuanMoi() {
        $tong_binhluan_moi = binh_luan::where('thoi_diem', '>=', now()->subHours(24))->count();
        if ($tong_binhluan_moi > 0) {
            $message = "Có {$tong_binhluan_moi} bình luận mới.";
            session()->put('canh_bao_binh_luan_moi', [$message]); 
        } else {
            session()->forget('canh_bao_binh_luan_moi');
        }
    
        return session()->get('canh_bao_binh_luan_moi', []);
    }

    private function checkDanhGiaMoi() {
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
 
    private function checkDonHangMoi() {
        $tong_don_hang_moi = don_hang::where('thoi_diem_mua_hang', '>=', now()->subHours(24))
        ->where('trang_thai', '0') 
        ->count();

        if ($tong_don_hang_moi === 0) {
            session()->forget('canh_bao_don_hang_moi');
        } else {
            $message = "Có {$tong_don_hang_moi} đơn hàng mới.";
            session()->put('canh_bao_don_hang_moi', [$message]);
        }
        
        return session()->get('canh_bao_don_hang_moi', []);
    }
    
    private function checkLienHeMoi() {
        $warnings = [];
        $tong_lien_he_moi = lien_he::where('thoi_gian', '>=', now()->subHours(24))->count();
        if ($tong_lien_he_moi > 0) {
            $warnings[] = "Có {$tong_lien_he_moi} yêu cầu liên hệ mới.";
        }
        return $warnings;
    }

    // public function deleteNotification() {
    //     session()->forget('canh_bao_khach_hang_moi');
        
    //     return redirect()->back()->with('thongbao2', 'Thông báo đã được xóa.');
    // }
    

    function dangnhap(){ return view("admin/login"); }
    function dangnhap_( dangnhapValid $request){
        if(auth()->guard('admin') ->attempt(['email'=>$request['email'],'password'=>$request['password']])){
            $user = auth()->guard('admin')->user();
            if($user->role == 1)
            {
                auth()->login($user, true);
                return redirect()->intended('admin/');
            } 
            elseif($user->role==0)
            {
                auth()->login($user, true);
                return redirect('/');
            }
            // else return back()->with('thongbao','Bạn không phải admin');
            // else auth()->guard('web');
        }
        else return back()->with('thongbao','Email hoặc Password không đúng');
        // if(auth()->guard('web')
        // ->attempt(['email'=>$request['email'],'password'=>$request['password']])){
        //     $user = auth()->guard('web')->user();
        //     if($user->role == 1) return redirect('admin/');
           
        //     else return redirect('/');
        // }
        // else return back()->with('thongbao','Email hoặc Password không đúng');
    } 
    

    
    public function thoat() {
        Auth::guard('admin')->logout();
        
        Auth::guard('web')->logout();
    
        request()->session()->forget('cart');
    
        return redirect('admin/dangnhap')->with('thongbao2', 'Bạn đã thoát thành công');
    }

    public function canhbao() {
        $san_phams = san_pham::all(); 
        $canh_bao = [];
    
        foreach ($san_phams as $sp) {
            $ton_kho = so_luong_ton_kho::where('id_sp', $sp->id)->first(); 
            if ($ton_kho && $ton_kho->so_luong_con_lai <= 10) {
                $canh_bao[] = [
                    'ten_sp' => $sp->ten_sp, 
                    'hinh' => $sp->hinh, 
                    'gia' => $sp->gia, 
                    'gia_km' => $sp->gia_km,
                    'ngay' => $sp->ngay,
                    'an_hien' => $sp->an_hien,
                    'hot' => $sp->hot,
                    'so_luong_con_lai' => $ton_kho->so_luong_con_lai, 
                    'edit_link' => route('sanpham.edit', $sp->id),
                ];
            }
        }
    
        return view('admin.canh_bao', compact('canh_bao')); 
    }

    public function quanLyBinhLuan(Request $request)
{
    $perpage = env('PER_PAGE');
    $thoiGianMoi = now()->subDay();
    $search = $request->input('search');

    $binhLuanArr = binh_luan::with(['san_pham', 'user', 'replies'])
    ->orderBy('thoi_diem', 'desc');

    if ($search) {
        $binhLuanArr->where(function($q) use ($search) {
            // Tìm kiếm theo tên sản phẩm
            $q->whereHas('san_pham', function($query) use ($search) {
                $query->where('ten_sp', 'LIKE', "%{$search}%");
            })
            
            // Tìm kiếm theo tên người dùng
            ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });
        });
    }

    // if ($query) {
    //     $binhLuanArr = $binhLuanArr->where(function($q) use ($query) {
    //         $q->whereHas('san_pham', function($query) use ($query) {
    //             $query->where('ten_sp', 'LIKE', "%{$query}%");
    //         })
    //           ->orWhere('id_user', 'LIKE', "%{$query}%");
    //     });
    // }
    $binhLuanArr = $binhLuanArr->paginate($perpage)->withQueryString();

    $this->checkBinhLuanMoi();
    
    return view('admin.quan_ly_binh_luan', compact('binhLuanArr', 'thoiGianMoi'));
}

public function xoaBinhLuan($id)
{
    $binhLuan = binh_luan::find($id);
    if ($binhLuan) {
        $binhLuan->delete();
        return redirect()->back()->with('thongbao2', 'Bình luận đã được xóa.');
    }
    return redirect()->back()->with('thongbao', 'Bình luận không tồn tại.');
}

public function luuPhanHoi(Request $request, $id)
{
    $request->validate([
        'noi_dung' => 'required|string',
    ]);

    $binhLuan = binh_luan::find($id);
    
    if ($binhLuan) {
        $binhLuan->noi_dung .=  ' <br><strong>Admin:</strong> ' .e($request->noi_dung); 
        $binhLuan->thoi_diem = now();
        $binhLuan->save(); 

        return redirect()->back()->with('thongbao2', 'Đã gửi phản hồi!');
    }

    return redirect()->back()->with('thongbao', 'Bình luận không tồn tại.');
}



 // Hàm hiển thị danh sách tin tức
 public function tinTucIndex()
 {
    $perpage = env('PER_PAGE');
     $tinTucs = TinTuc::orderBy('ngay_dang', 'desc')->paginate($perpage)->withQueryString();
     return view('admin.tin_tuc_index', compact('tinTucs'));
 }

 // Hàm tạo mới tin tức
 public function tinTucCreate()
 {
     return view('admin.tin_tuc_create');
 }

 // Thêm tin tức mới
 public function tinTucStore(Request $request)
{
    // Validate input data
    $request->validate([
        'tieu_de' => 'required|string|max:255',
        'noi_dung' => 'required|string',
        'ngay_dang' => 'required|date',  // Kiểm tra ngày tháng
        'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   // Chỉ lưu tên ảnh
    ]);

    // Khởi tạo đối tượng tin tức mới
    $tinTuc = new TinTuc();
    $tinTuc->tieu_de = $request->tieu_de;
    $tinTuc->noi_dung = $request->noi_dung;
    $tinTuc->ngay_dang = $request->ngay_dang;

    if ($request->hasFile('anh')) {
        // Lưu ảnh vào thư mục public/tin_tuc
        // $imagePath = $request->file('anh')->store( 'public/tin_tuc');
        // $tinTuc->anh = $imagePath;

        $filename = $request->file('anh')->getClientOriginalName();
        $path = $request->file('anh')->storeAs('public/tin_tuc/', $filename);

        // Cập nhật tên ảnh trong cơ sở dữ liệu
        $tinTuc->anh = basename($path);
    }
    // Lưu tin tức vào cơ sở dữ liệu
    $tinTuc->save();

    // Quay lại trang danh sách tin tức với thông báo thành công
    return redirect()->route('admin.tin_tuc.index')->with('thongbao2', 'Tin tức đã được thêm mới!');
}


 // Hàm sửa tin tức
 public function tinTucEdit($id)
 {
     $tinTuc = TinTuc::findOrFail($id);
     return view('admin.tin_tuc_edit', compact('tinTuc'));
 }

 // Cập nhật tin tức
 public function tinTucUpdate(Request $request, $id)
 {
     $request->validate([
         'tieu_de' => 'required|string|max:255',
         'noi_dung' => 'required|string',
         'ngay_dang' => 'required|date',
         'anh' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
     ]);

     $tinTuc = TinTuc::findOrFail($id);
     $tinTuc->tieu_de = $request->tieu_de;
     $tinTuc->noi_dung = $request->noi_dung;
     $tinTuc->ngay_dang = $request->ngay_dang;

     // Lưu ảnh nếu có và xóa ảnh cũ
     if ($request->hasFile('anh')) {
        //  // Xóa ảnh cũ nếu có
        //  if ($tinTuc->anh && file_exists(storage_path('app/public/tin_tuc/' . $tinTuc->anh))) {
        //     unlink(storage_path('app/public/tin_tuc/' . $tinTuc->anh));
        // }

        // Lưu ảnh mới vào thư mục
        $filename = $request->file('anh')->getClientOriginalName();
        $path = $request->file('anh')->storeAs('public/tin_tuc/', $filename);

        // Cập nhật tên ảnh trong cơ sở dữ liệu
        $tinTuc->anh = basename($path);
     }

     $tinTuc->save();

     return redirect()->route('admin.tin_tuc.index')->with('thongbao2', 'Tin tức đã được cập nhật!');
 }

 // Xóa tin tức
 public function tinTucDestroy($id)
 {
     $tinTuc = TinTuc::findOrFail($id);

     // Xóa ảnh nếu có
     if ($tinTuc->anh) {
         Storage::disk('public')->delete($tinTuc->anh);
     }

     $tinTuc->delete();

     return redirect()->route('admin.tin_tuc.index')->with('thongbao2', 'Tin tức đã được xóa!');
 }
   
    
}
