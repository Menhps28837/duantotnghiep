<?php
namespace App\Http\Controllers;

use App\Mail\Dangky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();
use Illuminate\Support\Arr;
use App\Models\TinTuc;
use App\Models\binh_luan;
use App\Models\Danh_Gia;
use App\Models\don_hang;
use App\Models\don_hang_chi_tiet;
use App\Models\khuyen_mai;
use App\Models\loai;
use App\Models\User;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;
use App\Models\thuoc_tinh;
use Carbon\Carbon;

class SanphamController extends Controller
{
    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr  );
    }   
    function index(){
        $today = Carbon::now();

        // $khuyen_mai_ids = DB::table('khuyen_mai')
        // ->where('ngay_bat_dau', '<=', $today)
        // ->where('ngay_ket_thuc', '>=', $today)
        // ->pluck('id_sp');

       $spnoibat_arr = DB::table('san_pham')
       ->where('an_hien', 1)
       ->where('hot',1)
    //    ->whereNotIn('id', $khuyen_mai_ids)
       ->orderBy('luot_xem', 'desc')
       ->orderBy('ngay','desc')
       ->limit(8)->get();
       
       $spgiamsoc_arr = DB::table('san_pham')
        ->where('an_hien', 1)
        ->where('tinh_chat', 2)
        // ->whereNotIn('id', $khuyen_mai_ids)
        ->orderBy('ngay','desc')
        ->limit(8)->get();  

       $spgiare_arr = DB::table('san_pham')
        ->where('an_hien', 1)
        ->where('tinh_chat', 1)
        // ->whereNotIn('id', $khuyen_mai_ids)
        ->orderBy('gia_km', 'asc')
        ->orderBy('ngay','desc')
        ->limit(8)->get();  

        $spluotxemcao_arr = DB::table('san_pham')
        ->where('an_hien', 1)
        // ->whereNotIn('id', $khuyen_mai_ids)
        ->orderBy('luot_xem', 'desc')
        ->limit(8)
        ->get();

         // Lấy thông tin khuyến mãi kết hợp với sản phẩm
        // $khuyen_mai_arr = DB::table('khuyen_mai')
        //     ->join('san_pham', 'khuyen_mai.id_sp', '=', 'san_pham.id')
        //     ->select('san_pham.*', 'khuyen_mai.ngay_bat_dau', 'khuyen_mai.ngay_ket_thuc', 'khuyen_mai.giam_gia')
        //     ->where('khuyen_mai.ngay_bat_dau', '<=', $today)
        //     ->where('khuyen_mai.ngay_ket_thuc', '>=', $today)
        //     ->get();

        // // Tính giá sau giảm
        // foreach ($khuyen_mai_arr as $item) {
        //     $item->gia_saukhigiam = $item->gia_km * (1 - ($item->giam_gia / 100));
        // }

        //  // Kiểm tra và xử lý session
        // if ($khuyen_mai_arr->isEmpty()) {
        //     session()->forget('sp_khuyenmai'); // Xóa session nếu không có sản phẩm khuyến mãi
        // } else {
        //     session(['sp_khuyenmai' => $khuyen_mai_arr]); // Lưu vào session nếu có sản phẩm
        // }

        $tinTucs = TinTuc::orderBy('ngay_dang', 'desc')->limit(3)->get();
        // return view('tin_tuc.index', compact('tinTucs'));


        return view ('user.trangchu.home' , compact(['spnoibat_arr','spgiamsoc_arr', 'spgiare_arr', 'spluotxemcao_arr', 'tinTucs']));

    }
    function chitiet($id = 0){
        $sp = DB::table('san_pham')->where('id', '=', $id)->first();
        $lt = DB::table('loai')->where('id', $sp->id_loai)->first();
        
        if ($sp == null || $sp->an_hien == 0) {
            return back()->with(['thongbao' => 'Không có sản phẩm này hoặc sản phẩm đang ẩn.']);
        }

        $tonkho = so_luong_ton_kho::where('id_sp', $id)->first();
      
        $thuoc_tinh = thuoc_tinh::where('id_sp', $id)->first();
        
        $danh_gia_arr = Danh_Gia::with('user') // Chắc chắn rằng quan hệ user đã được thiết lập trong model Danh_Gia
        ->where('id_sp', $id)
        ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
        ->get();
        $reviewCount = $danh_gia_arr->count();
        // Kiểm tra thông tin khuyến mãi
        // $khuyen_mai = khuyen_mai::where('id_sp', $id)
        // ->where('ngay_bat_dau', '<=', now())
        // ->where('ngay_ket_thuc', '>=', now())
        // ->first();
        // // Tính giá sau khi giảm nếu có khuyến mãi
        // if ($khuyen_mai) {
        //     $khuyen_mai->gia_saukhigiam = $sp->gia_km * (1 - ($khuyen_mai->giam_gia / 100));
        // }

        $splienquan_arr = san_pham::where('id_loai', $sp->id_loai)
        ->where('tinh_chat', $sp->tinh_chat)
        ->where('an_hien', '=', 1)
        ->orderBy('ngay','desc')
        ->limit(4)->get()
        ->except($id);  

        $binh_luan_arr = binh_luan::with('replies')  // Dùng with để lấy bình luận trả lời
        ->where('id_sp', $id)
        ->orderBy('thoi_diem','asc')
        ->get();

        return view('user.sanpham.chitiet',compact(['sp', 'lt', 'thuoc_tinh', 'splienquan_arr','danh_gia_arr', 'reviewCount', 'binh_luan_arr', 'tonkho']));
    }
    
    
    function sptrongloai(Request $request, $id_loai = 0){
        $per_page= env('PER_PAGE'); //9

         // Lấy tham số lọc từ request
        $gia_km = $request->input('gia_km');
        $ram = $request->input('ram');
        $bo_nho = $request->input('bo_nho');
        $mau_sac = $request->input('mau_sac');
        $camera_chinh = $request->input('camera_chinh');
        $pin = $request->input('pin');
        // $cpu = $request->input('cpu');
        $sort = $request->input('sort');
        $search_product = $request->input('search_product');

        $query = san_pham::where('an_hien', '=', 1)->where('id_loai', $id_loai);

        if ($search_product) {
            // Nếu có tham số search_product, chỉ tìm kiếm sản phẩm trùng với ID đó
            $query->where('id', $search_product);
        }

        if ($gia_km) {
            [$min, $max] = explode('-', $gia_km); // Tách giá thành min và max
            $query->whereBetween('gia_km', [(int)$min, (int)$max]);
        }

        if ($ram) {
            $query->whereHas('thuoc_tinh', function ($q) use ($ram) {
                $q->where('ram', $ram);
            });
        }
        if ($bo_nho) {
            $query->whereHas('thuoc_tinh', function ($q) use ($bo_nho) {
                $q->where('bo_nho', $bo_nho);
            });
        }
        if ($mau_sac) {
            $query->whereHas('thuoc_tinh', function ($q) use ($mau_sac) {
                $q->where('mau_sac', $mau_sac);
            });
        }
        if ($camera_chinh) {
            $query->whereHas('thuoc_tinh', function ($q) use ($camera_chinh) {
                $q->where('camera_chinh', $camera_chinh);
            });
        }
        if ($pin) {
            $query->whereHas('thuoc_tinh', function ($q) use ($pin) {
                $q->where('pin', $pin);
            });
        }

        // if ($cpu) {
        //     $query->whereHas('thuoc_tinh', function ($q) use ($cpu) {
        //         $q->where('cpu', $cpu);
        //     });
        // }

        if ($sort === 'asc') {
            $query->orderBy('gia_km', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('gia_km', 'desc');
        } elseif ($sort == 'views_desc') {
            $query->orderBy('luot_xem', 'desc');
        }

        $sptrongloai_arr = $query->paginate($per_page)->withQueryString();
        $ten_loai = DB::table('loai')->where ('id', $id_loai)->value('ten_loai');

        $noProducts = $sptrongloai_arr->isEmpty();
        
        return view ('user.sanpham.sptrongloai', compact(['id_loai', 'ten_loai', 'sptrongloai_arr', 'noProducts']));
    }
    public function luubinhluan($id_user)
    {
        $arr = request()->post(); 
        $id_sp = Arr::get($arr, 'id_sp', '-1');
        $noi_dung = Arr::get($arr, 'noi_dung', '');
        $parent_id = Arr::get($arr, 'parent_id', null);
    
        if ($id_sp <= -1) {
            return response()->json(['error' => "Không biết sản phẩm $id_sp"], 400);
        }
        if ($noi_dung == "") {
            return response()->json(['error' => 'Nội dung không có'], 400);
        }
    
        $binhLuan = binh_luan::create([
            'id_user' => $id_user,
            'id_sp' => $id_sp,
            'noi_dung' => $noi_dung,
            'thoi_diem' => now(),
            'parent_id' => $parent_id,
        ]);
    
        return response()->json([
            'user_name' => $binhLuan->user->name,
            'thoi_diem' => gmdate('d/m/Y H:i:s', strtotime($binhLuan->thoi_diem) + 3600 * 7),
            'noi_dung' => $binhLuan->noi_dung,
            'parent_id' => $parent_id,
        ]);
    }
    

    function themvaogio(Request $request, $id_sp = 0, $soluong = 1)
    {
    // Lấy thông tin sản phẩm
    $product = san_pham::find($id_sp);
    
    // Kiểm tra xem sản phẩm có tồn tại không
    if (!$product) {
        return response()->json(['error' => 'Sản phẩm không tồn tại.'], 404);
    }

    // Kiểm tra số lượng tồn kho
    $tonkho = so_luong_ton_kho::where('id_sp', $id_sp)->first();
    if (!$tonkho || $tonkho->so_luong_con_lai <= 0) {
        return response()->json(['error' => 'Sản phẩm này đã hết hàng.'], 400);
    }

    // Lấy giỏ hàng từ session hoặc khởi tạo là mảng rỗng nếu không có
    $cart = $request->session()->get('cart', []);

    // Đảm bảo $cart là một mảng
    if (!is_array($cart)) {
        $cart = [];
    }

    // Tìm chỉ số của sản phẩm trong giỏ hàng
    $index = array_search($id_sp, array_column($cart, 'id_sp'));

     if ($index !== false) { // Nếu sản phẩm đã có trong giỏ hàng
        // Cập nhật số lượng
        $newQuantity = $cart[$index]['soluong'] + $soluong;

        // Kiểm tra số lượng tồn kho
        if ($newQuantity > $tonkho->so_luong_con_lai) {
            return response()->json(['error' => 'Không đủ hàng trong kho.'], 400);
        }

        $cart[$index]['soluong'] = $newQuantity;
    } else { // Nếu sản phẩm chưa có trong giỏ hàng
        if ($soluong > $tonkho->so_luong_con_lai) {
            return response()->json(['error' => 'Không đủ hàng trong kho.'], 400);
        }

        $cart[] = ['id_sp' => $id_sp, 'soluong' => $soluong];
    }

    // Cập nhật giỏ hàng trong session
    $request->session()->put('cart', $cart);

     // Trả về phản hồi JSON
     return response()->json([
        'status' => 'success',
        'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công.',
        'cart_count' => count($cart) // Trả về số lượng sản phẩm trong giỏ hàng
    ]);

    // return back()->with('thongbaothem','Thêm sản phẩm vào giỏ hàng thành công');
    }

    function hiengiohang(Request $request ){
        $cart =  $request->session()->get('cart');
        $tongtien = 0;   
        $tongsoluong=0;
        
         // Lấy thông tin khách hàng từ session
    $customerInfo = $request->session()->get('customer_info', []);

        if($cart){
            for ( $i=0; $i<count($cart) ; $i++) {
              $sp = $cart[$i]; // $sp = [ 'id_sp' =>100, 'soluong'=>4, ]
              $ten_sp = DB::table('san_pham')->where('id', $sp['id_sp'] )->value('ten_sp');
              $gia_km = DB::table('san_pham')->where('id', $sp['id_sp'] )->value('gia_km');
              $hinh = DB::table('san_pham')->where('id', $sp['id_sp'] )->value('hinh');
              $thanhtien = $gia_km*$sp['soluong'];
              $tongsoluong+=$sp['soluong'];
              $tongtien += $thanhtien;
          
              $sp['ten_sp'] = $ten_sp;
              $sp['gia'] = $gia_km;
              $sp['hinh'] = $hinh;
              $sp['thanhtien'] = $thanhtien;
              $cart[$i] = $sp;
            }
            $request->session()->put('cart', $cart);
            return view('user.donhang.hiengiohang', compact(['cart', 'tongsoluong','tongtien']));
        }else{
            $cart=[];
            return view('user.donhang.hiengiohang', compact(['cart', 'tongsoluong','tongtien']));
        }

    }

    public function timKiem(Request $request, $id_loai = 0)
    {
        $per_page= env('PER_PAGE',); //12

        // Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');
    
        // Kiểm tra nếu người dùng không nhập gì
        if (trim($search) === '') {
            return back();
        }
    
        // Kiểm tra nếu có loại sản phẩm trùng với từ khóa tìm kiếm
        $loai = loai::where('ten_loai', 'like', "%{$search}%")->first();
    
        if ($loai) {
            return redirect()->route('sanpham.loai', ['id' => $loai->id]);
        }
    
        // Tìm tất cả sản phẩm có tên giống từ khóa tìm kiếm (sử dụng get() thay vì paginate())
        $sptrongloai_arr = san_pham::where('ten_sp', 'like', "%{$search}%")
                                    ->orWhere('mo_ta', 'like', "%{$search}%")
                                    ->paginate($per_page)->withQueryString(); // Sử dụng get() thay vì paginate()
    
        // Kiểm tra nếu không có sản phẩm nào
        $noProducts = $sptrongloai_arr->isEmpty();
    
        // Trả về view với tất cả các sản phẩm tìm được
        return view('user.sanpham.timkiem', compact('id_loai', 'sptrongloai_arr', 'search', 'noProducts'));
    }
    





    function download(){ return view("download"); }

}
