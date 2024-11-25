<?php

use App\Http\Controllers\AdminDanhgiaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinTucController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LienHeController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\ThanhtoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTinTucController;
use App\Http\Controllers\AdminLoaiController;
use App\Http\Controllers\AdminSPController; 
use App\Http\Controllers\AdminDonHangController; 
use App\Http\Controllers\AdminUserController; 
use App\Http\Controllers\AdminCTDHController; 
use App\Http\Controllers\AdminOrderController; 
use App\Http\Controllers\OrderTrackingController; 
use App\Http\Controllers\AdminDoanhThuController; 
use App\Http\Middleware\AdminMiddleware;
use App\Models\don_hang;

Route::get('/', [SanPhamController::class,'index']);
Route::get('/sp/{id}', [SanPhamController::class,'chitiet']);
Route::get('/loai/{id}', [SanPhamController::class, 'sptrongloai'])->name('sanpham.loai');
Route::get('/tim-kiem/{id_loai?}', [SanPhamController::class, 'timKiem'])->name('sanpham.timkiem');
Route::get('/thongbao', function(){ return view('thongbao'); });
Route::get('/thongbao2', function(){ return view('thongbao2'); });
Route::post('/luubinhluan/{id_user}', [SanPhamController::class,'luubinhluan']);
Route::get('/themvaogio/{idsp}/{soluong?}', [SanPhamController::class,'themvaogio']);
Route::get('/hiengiohang', [SanPhamController::class,'hiengiohang']);

Route::get('/tin-tuc', [TinTucController::class, 'index'])->name('tin_tucs.index');
Route::get('/tin-tuc/{id}', [TinTucController::class, 'show'])->name('tin_tucs.show');

// Route::post('/updategiohang', [SanPhamController::class,'updategiohang']);
// Route::get('/xoasptronggio/{idsp}', [SanPhamController::class,'xoasptronggio']);
// Route::delete('/xoasptronggio/{id}', [SanPhamController::class,'xoasptronggio']);
// Route cho người dùng theo dõi đơn hàng của họ
Route::get('/theo-doi-don-hang', [OrderTrackingController::class, 'index'])->name('user.donhang.order.tracking.index')->middleware('auth');

// Route cho việc xem chi tiết đơn hàng
Route::get('/theo-doi-don-hang/{id}', [OrderTrackingController::class, 'show'])->name('user.donhang.order.tracking')->middleware('auth');
// Route hủy đơn hàng
Route::post('/huy-don-hang/{id}', [OrderTrackingController::class, 'cancel'])->name('order.cancel')->middleware('auth');
Route::post('/order/mualai/{id}', [OrderTrackingController::class, 'mualai'])->name('order.mualai');

Route::post('/order/{id}/trahang', [OrderTrackingController::class, 'yeucautrahang'])->name('order.trahang');

Route::get('/san-pham/{id}/xem-danh-gia', [OrderTrackingController::class, 'xemdanhgia'])->name('order.xemdanhgia');

Route::post('/order/{id}/danhgia', [OrderTrackingController::class, 'danhgia'])->name('order.danhgia');

Route::get('/donhang/{id}/camon', [ThanhtoanController::class, 'camOn'])->name('donhang.camon');


Route::post('/thanhtoangiohang', [ThanhtoanController::class,'thanhtoangiohang'])->name('thanhtoan');
Route::get('/thanhtoan',[ThanhtoanController::class,'thanhtoan']);
Route::post('/update-cart', [ThanhtoanController::class,'updateCart'])->name('update.cart');
Route::delete('/xoasptronggio/{id}', [ThanhtoanController::class, 'delete'])->name('delete.cart');


Route::post('/thong-tin-khach-hang', [ThanhtoanController::class, 'thongtinkhachhang'])->name('donhang.thongtinkhachhang');



Route::get('/lienhe', [LienHeController::class, 'create'])->name('lienhe.create');
Route::post('/lienhe', [LienHeController::class, 'store'])->name('lienhe.store');


Route::get('/gioithieu', [UserController::class,'gioithieu'])->name('gioithieu');


Route::group(['prefix' => 'admin' ,'middleware' => [AdminMiddleware::class] ], function() {
    Route::resource('loai', AdminLoaiController::class); 
    Route::resource('sanpham', AdminSPController::class);
    Route::get('/admin/canh-bao', [AdminController::class, 'canhbao'])->name('sanpham.canh_bao');
    

    Route::get('khuyenmai', [AdminSPController::class, 'showKhuyenMai'])->name('admin.khuyenmai');
    Route::post('khuyenmai/update', [AdminSPController::class, 'updateKhuyenMai'])->name('admin.khuyenmai.update');
    Route::get('sanpham/khoi-phuc/{id}', [AdminSPController::class, 'khoiphuc']);
    Route::get('sanpham/xoa-vinh-vien/{id}', [AdminSPController::class, 'xoavinhvien']);
    Route::resource('donhang', controller: AdminDonHangController::class);
    Route::get('donhang/chitiet/{id}', [AdminDonHangController::class, 'chitiet' ])->name('donhang.chitiet');
    Route::get('donhang/chitietxacnhan/{id}', [AdminDonHangController::class, 'chitietxacnhan' ])->name('donhang.chitietxacnhan');
    Route::patch('/donhang/{id}/giaohang', [AdminDonHangController::class, 'giaohang'])->name('donhang.giaohang');
    Route::get('donhangxacnhan', [AdminDonHangController::class, 'daxacnhan']);
    Route::get('donhangdahuy', [AdminDonHangController::class, 'dahuy']);
    Route::get('donhangquashipper', [AdminDonHangController::class, 'quashipper']);
    // Route::get('donhangdagiao', [AdminDonHangController::class, 'dagiao']);
    Route::get('donhangdaxong', [AdminDonHangController::class, 'khdaxacnhan']);
    Route::get('donhangtralai', [AdminDonHangController::class, 'yeucautralai'])->name('donhang.tralai');
    Route::get('donhangdachopheptralai', [AdminDonHangController::class, 'dachopheptralai']);
    Route::post('donhangtraloitrahang/{id}', [AdminDonHangController::class, 'traloitrahang'])->name('donhang.traloitrahang');
    Route::post('donhangtralai/{id}', [AdminDonHangController::class, 'chopheptralai'])->name('donhang.chophep');
    Route::get('donhangdatuchoi', [AdminDonHangController::class, 'datuchoi']);
    Route::post('donhangtuchoi/{id}', [AdminDonHangController::class, 'tuchoitralai'])->name('donhang.tuchoi');

    Route::patch('/donhang/{id}/xacnhan', [AdminDonHangController::class, 'xacnhan'])->name('donhang.xacnhan');
    Route::patch('/donhang/{id}/datoi', [AdminDonHangController::class, 'datoi'])->name('donhang.datoi');
    Route::patch('/donhang/{id}/guilai', [AdminDonHangController::class, 'guilai'])->name('donhang.guilai');

    Route::get('/donhang/thanhtoanvaxacnhan/{id}', [AdminDonHangController::class, 'thanhtoanvaxacnhan'])->name('donhang.thanhtoanvaxacnhan');


    Route::post('/donhang/request-payment/{id}', [AdminDonHangController::class, 'requestPayment'])->name('donhang.requestPayment');

    Route::get('/admin/donhang/invoice/{id}', [AdminDonHangController::class, 'createInvoice'])->name('donhang.invoice');

    Route::get('/admin/lienhe', [LienHeController::class, 'index'])->name('admin.lienhe');
    Route::delete('/lienhe/{id}', [LienHeController::class, 'destroy'])->name('lienhe.destroy');
    Route::post('/lienhe/{id}/traloi', [LienHeController::class, 'traloi'])->name('lienhe.traloi');

    Route::get('/binh-luan', [AdminController::class, 'quanLyBinhLuan'])->name('admin.binhluan');
    Route::delete('/binh-luan/{id}', [AdminController::class, 'xoaBinhLuan'])->name('admin.binhluan.xoa');
    Route::post('/binh-luan/{id}/traloi', [AdminController::class, 'luuPhanHoi'])->name('admin.traloibinhluan');

    // Route::get('/doanh-thu', [AdminDoanhThuController::class, 'getDoanhThu'])->name('admin.doanhthu');
    Route::get('/doanh-thu', [AdminDoanhThuController::class, 'index'])->name('admin.doanhthu');
    Route::get('/doanh-thu/{thang}/{nam}', [AdminDoanhThuController::class, 'detail'])->name('admin.doanhthudetail');


    Route::get('tin-tuc', [AdminController::class, 'tinTucIndex'])->name('admin.tin_tuc.index');
    Route::get('tin-tuc/create', [AdminController::class, 'tinTucCreate'])->name('admin.tin_tuc.create');
    Route::post('tin-tuc', [AdminController::class, 'tinTucStore'])->name('admin.tin_tuc.store');
    Route::get('tin-tuc/{id}/edit', [AdminController::class, 'tinTucEdit'])->name('admin.tin_tuc.edit');
    Route::put('tin-tuc/{id}', [AdminController::class, 'tinTucUpdate'])->name('admin.tin_tuc.update');
    Route::delete('tin-tuc/{id}', [AdminController::class, 'tinTucDestroy'])->name('admin.tin_tuc.destroy');

    Route::get('reviews', [AdminDanhgiaController::class, 'index'])->name('admin.danhgia_ds');
    Route::get('reviews/edit/{id}', [AdminDanhgiaController::class, 'edit'])->name('admin.reviews.edit');
    Route::post('reviews/update/{id}', [AdminDanhgiaController::class, 'update'])->name('admin.reviews.update');
    Route::delete('reviews/delete/{id}', [AdminDanhgiaController::class, 'destroy'])->name('admin.reviews.delete');



    // Route::get('/danhan-donhang/{id}', [AdminOrderController::class, 'danhanDonHang'])->name('order.danhan_donhang');
    // Route::get('/confirm-received/{id}', [AdminOrderController::class, 'confirmReceived'])->name('order.confirm_received');
    // // Route::get('/thank-you', [AdminOrderController::class, 'thankYou'])->name('thank.you');
    // Route::get('/thank-you', function () {
    //     return view('thank_you');
    // })->name('thank.you');
    

    Route::resource('user', controller: AdminUserController::class);

    // Route::get('donhang/khoi-phuc/{id}', [AdminDonHangController::class, 'khoiphuc']);
    // Route::get('donhang/xoa-vinh-vien/{id}', [AdminDonHangController::class, 'xoavinhvien']);

});


Route::group(['prefix' => 'admin'], function() { 
    Route::get('/', [AdminController::class,'index']);
    Route::post('/admin/notification/delete', [AdminController::class, 'deleteNotification'])->name('admin.notification.delete');

    Route::get('dangnhap', [AdminController::class,'dangnhap']);
    Route::post('dangnhap', [AdminController::class,'dangnhap_']);
    Route::get('thoat', [AdminController::class, 'thoat']);

    
});


// Route::get('/dangnhap',[UserController::class,'dangnhap'])->name('login');
// Route::post('/dangnhap', [UserController::class,'dangnhap_']);
Route::get('/thoat', [UserController::class,'thoat']);

Route::get('/download', [SanPhamController::class,'download'])->middleware('auth' ,'verified');
Route::get('/dangky', [UserController::class,'dangky']);
Route::post('/dangky', [UserController::class,'dangky_']);

Route::get('/camon', [UserController::class,'camon']);



Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth')->name('khuser.profile');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->middleware('auth')->name('khuser.edit');
Route::post('/user/{id}', [UserController::class, 'update'])->middleware('auth')->name('khuser.update');





use Illuminate\Foundation\Auth\EmailVerificationRequest;
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

use Illuminate\Http\Request;
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Thư kích hoạt đã gửi!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

use App\Http\Controllers\GoogleLoginController;
Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);



use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/forgot-password', [ForgotPasswordController::class, 'forgot_password'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'check_forgot_password'])->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'check_reset_password'])->name('password.email');

// use App\Http\Controllers\Auth\ResetPasswordController;

// Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
