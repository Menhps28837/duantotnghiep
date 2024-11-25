<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\don_hang;
use App\Models\don_hang_chi_tiet;
use App\Mail\OrderConfirmation;
use App\Mail\OrderReceivedConfirmation;
use Illuminate\Support\Str;
use App\Http\Requests\online_checkoutValid;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;
use App\Models\SoLuongTonKho;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class ThanhtoanController extends Controller
{

    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien','=',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr );
     }


    public function thanhtoangiohang(online_checkoutValid $request) {    
        // Lấy giỏ hàng từ session
        $cartItems = $request->session()->get('cart', []);
    
        if (empty($cartItems)) {
            return redirect()->back()->with('thongbao', 'Giỏ hàng của bạn đang trống!');
        }

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            $existingUser = User::where('email', strtolower(trim(strip_tags($request->email))))->first();

            // if ($existingUser) {
            //     return redirect()->back()->with('error', 'Email đã tồn tại.')->withInput();
            // }

            if ($existingUser) {
                return response()->json(['error' => 'Email đã tồn tại! Nếu là khách hàng cũ thì hãy đăng nhập để đặt hàng.'], 422);
            }
            
            // Nếu người dùng chưa đăng nhập, tạo tài khoản mới
            $user = new User();
            $user->name = trim(strip_tags($request->name));
            $user->email = strtolower(trim(strip_tags($request->email)));
            $user->password = Hash::make($request->mk1); // Mã hóa mật khẩu
            $user->dien_thoai = $request->dien_thoai;
            $user->dia_chi = $request->dia_chi;
            $user->save();

            // Đăng nhập người dùng ngay sau khi tạo tài khoản
            Auth::login($user);
        } else {
            // Nếu đã đăng nhập, cập nhật thông tin người dùng nếu cần
            $user = Auth::user();
            if (empty($user->dien_thoai)) {
                $user->dien_thoai = $request->dien_thoai;
                $user->dia_chi = $request->dia_chi; // Cập nhật địa chỉ nếu cần
                $user->save();
            }
        }
        
    
        // Tạo đơn hàng mới
        $order = new don_hang();
        $order->id_user = Auth::check() ? Auth::id() : null; // Nếu có đăng nhập
        $order->ten_nguoi_nhan = $request->name;
        $order->email = $request->email;
        $order->dien_thoai = $request->dien_thoai;
        $order->dia_chi_giao = $request->dia_chi;
        $order->thoi_diem_mua_hang = now();
        $order->tong_so_luong = 0;
        $order->tong_tien = 0;
        $order->trang_thai = 0; // Hoặc trạng thái bạn muốn
        $order->loai_thanh_toan = $request->loai_thanh_toan; // Hoặc trạng thái bạn muốn

        // Kiểm tra loại thanh toán
        if ($request->loai_thanh_toan == 1) {
            $order->trang_thai_thanh_toan = 1; // Đã chuyển khoản nhưng chưa xác minh
        } else {
            $order->trang_thai_thanh_toan = 0; // Chưa thanh toán (tiền mặt)
        }
    

        $order->save();

        $orderDetails = []; // Khởi tạo mảng để lưu thông tin chi tiết đơn hàng
    
        // Lưu chi tiết đơn hàng
        foreach ($cartItems as $item) {
            $product = san_pham::find($item['id_sp']);
        
        if (!$product) {
            return redirect()->back()->with('thongbao', 'Sản phẩm không tồn tại: ' . $item['id_sp']);
        }

        $tonkho = so_luong_ton_kho::where('id_sp', $item['id_sp'])->first();

        // Kiểm tra số lượng còn lại
        if (!$tonkho || $tonkho->so_luong_con_lai < $item['soluong']) {
            return redirect()->back()->with('thongbao', 'Sản phẩm ' . $product->ten_sp . ' hiện đang hết hàng.');
        }


        if ($tonkho && $tonkho->so_luong_con_lai >= $item['soluong']) {
            $tonkho->so_luong_con_lai -= $item['soluong'];
            $tonkho->save();
        }


            $orderDetail = new don_hang_chi_tiet();
            $orderDetail->id_dh = $order->id; // ID đơn hàng
            $orderDetail->id_sp = $item['id_sp'];
            $orderDetail->so_luong = $item['soluong'];
            
            // Giả sử bạn có cách lấy giá sản phẩm
            // $product = san_pham::find($item['id_sp']); 
            // if ($product) {
            //     $orderDetail->gia_km = $product->gia_km; // Lấy giá
            //     $orderDetail->ten_sp = $product->ten_sp; // Tên sản phẩm
            //     $orderDetail->hinh = $product->hinh; // Hình sản phẩm
            // }

            $orderDetail->gia_km = $product->gia_km; // Lấy giá
            $orderDetail->ten_sp = $product->ten_sp; // Tên sản phẩm
            $orderDetail->hinh = $product->hinh; // Hình sản phẩm

            $orderDetail->save();
    
            // Cập nhật tổng số lượng và tổng tiền
            $order->tong_so_luong += $item['soluong'];
            $order->tong_tien += $item['soluong'] * $orderDetail->gia_km;

            // Thêm thông tin chi tiết vào mảng
            $orderDetails[] = $orderDetail;
            
        }
            
        $order->save(); 

    
        // Xóa giỏ hàng trong session
        $request->session()->forget('cart');

        Mail::to($order->email)->send(new OrderConfirmation($order, $orderDetails));
        return redirect('/hiengiohang')->with('thongbao2', 'Đặt hàng thành công! Phiền bạn check mail');
}
public function updateCart(Request $request)
{
    $data = json_decode($request->getContent(), true);
    $productId = $data['id'];
    $quantity = $data['quantity'];

    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra sản phẩm có trong giỏ hàng không
    $index = array_search($productId, array_column($cart, 'id_sp'));
    
    if ($index !== false) {
        // Cập nhật số lượng
        $cart[$index]['soluong'] = $quantity;
        // Cập nhật thành tiền
        $cart[$index]['thanhtien'] = $cart[$index]['gia'] * $quantity;

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);
        
        return response()->json(['message' => 'Cập nhật giỏ hàng thành công']);
    }
    return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng'], 404);
}

// public function delete($id)
// {
//     // Xử lý xóa sản phẩm trong giỏ hàng
//     $cartItem = don_hang_chi_tiet::where('id_sp', $id)->first();

//     if ($cartItem) {
//         $id_dh = $cartItem->id_dh;
//         $cartItem->delete();

//         // Cập nhật lại số lượng và tổng tiền trong giỏ hàng
//         $cartCount = don_hang_chi_tiet::where('id_dh', $id_dh)->sum('so_luong');
//         $cartTotal = don_hang_chi_tiet::where('id_dh', $id_dh)->sum('gia_km');

//         // Lấy lại giỏ hàng sau khi xóa
//         $updatedCart = don_hang_chi_tiet::where('id_dh', $id_dh)->get();

//         // Cập nhật giỏ hàng trong session
//         session()->put('cart', $updatedCart);

//         return response()->json([
//             'message' => 'Sản phẩm đã được xóa',
//             'cartCount' => $cartCount,
//             'cartTotal' => $cartTotal,
//             'updatedCart' => $updatedCart // Trả lại giỏ hàng đã cập nhật
//         ]);
//     }

//     return response()->json(['message' => 'Sản phẩm không tìm thấy'], 404);
// }

public function delete($id)
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Tìm sản phẩm trong giỏ hàng
    $index = array_search($id, array_column($cart, 'id_sp'));

    if ($index !== false) {
        // Xóa sản phẩm khỏi giỏ hàng
        array_splice($cart, $index, 1);

        // Lưu giỏ hàng đã cập nhật vào session
        session()->put('cart', $cart);

        if (count($cart) === 0) {
            // Nếu giỏ hàng trống, xóa giỏ hàng trong session
            session()->forget('cart');
        }

        // Cập nhật lại số lượng và tổng tiền trong giỏ hàng
        $cartCount = array_sum(array_column($cart, 'soluong'));
        $cartTotal = array_sum(array_column($cart, 'thanhtien'));

        return response()->json([
            'message' => 'Sản phẩm đã được xóa',
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'updatedCart' => $cart,
            'isEmpty' => count($cart) === 0 // Trả lại giỏ hàng đã cập nhật
        ]);
    }

    return response()->json(['message' => 'Sản phẩm không tìm thấy'], 404);
}


    public function thongtinkhachhang()
    {
        $cart = session('cart', []);
        $tongsoluong = 0;
        $tongtien = 0;
    
        // Tính tổng số lượng và tổng tiền của giỏ hàng
        foreach ($cart as $item) {
            $tongsoluong += $item['soluong'];
            $tongtien += $item['thanhtien'];
        }
        if (empty($cart)) {
            // Nếu giỏ hàng trống, trả về view giỏ hàng trống
            return view('user.donhang.hiengiohang')->with('cart', $cart)->with('tongsoluong', $tongsoluong)->with('tongtien', $tongtien);
        }
        return view('user.donhang.thongtinkhachhang', compact('cart', 'tongsoluong', 'tongtien'));
    }



    public function camOn(string $id)
    {
        try {
            // Kiểm tra xem đơn hàng có tồn tại không
            $donHang = don_hang::find($id);
            if (!$donHang) {
                return redirect('/hiengiohang')->with('thongbao', 'Đơn hàng không tồn tại!');
            }
    
            // Cập nhật trạng thái đơn hàng
            if ($donHang->trang_thai !== 5) {
                $donHang->trang_thai = 5; // Giả sử 5 là trạng thái "Đã xác nhận"
            }
            if ($donHang->loai_thanh_toan == 0) { // Nếu loại thanh toán là tiền mặt
                $donHang->trang_thai_thanh_toan = 2; // Đã xác nhận nhận hàng
            }
            $donHang->save();

            Mail::to($donHang->email)->send(new OrderReceivedConfirmation($donHang));
    
            // Trả về view cảm ơn
            return view('user.trangchu.thank_you', ['order' => $donHang]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    // public function returnOrder(Request $request, $id)
    // {
    //     $donHang = don_hang::find($id);

    //     // Kiểm tra trạng thái đơn hàng
    //     if (($donHang->trang_thai == 4 || $donHang->trang_thai == 5) && $donHang->trang_thai_thanh_toan == 2) {
    //         // Cập nhật trạng thái đơn hàng
    //         $donHang->trang_thai = 6; // Giả sử trạng thái 6 là "Đang xử lý trả hàng"
    //         $donHang->ly_do_tra_hang = $request->reason; // Giả sử bạn đã tạo cột 'ly_do_tra_hang' trong bảng đơn hàng
    //         $donHang->save();

    //         return redirect()->back()->with('success', 'Yêu cầu trả hàng đã được gửi.');
    //     } else {
    //         return redirect()->back()->with('error', 'Không thể yêu cầu trả hàng cho đơn hàng này.');
    //     }
    // }

    
    function thanhtoan(){
        return view('thanhtoan')->with('thongbao','Thanh toan');;
    }

}
