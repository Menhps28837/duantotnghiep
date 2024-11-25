<?php
namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Requests\dangKyValid;
use App\Http\Requests\updatethongtinValid;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Dangky;

class UserController extends Controller {
    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien','=',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr );
     }
    // function dangnhap(){ return view('dangnhap'); }
    // function dangnhap_(Request $request){
    //     if(auth()->guard('web')
    //         ->attempt(['email'=>$request['email'],'password'=>$request['matkhau']])){
    //         $user = auth()->guard('web')->user();
    //         if($user->role == 1) return redirect('admin/');
            
    //         return redirect()->intended('/');
    //     }
        
    //     else return back()->with('thongbao','Email, Password không đúng');
    // }
    function thoat(){
        auth()->guard('web')->logout();
         // Xóa thông tin giỏ hàng trong session nếu có
        request()->session()->forget('cart');
        request()->session()->forget('customer_info');
        return redirect('admin/dangnhap')->with('thongbao2','Bạn đã thoát thành công');
    }
    function gioithieu(){ return view('user.trangchu.gioithieu'); }
    function dangky(){ return view('user.trangchu.dangky'); }
    function dangky_( dangKyValid $request){ 
        if (User::where('email', strtolower(trim($request['email'])))->exists()) {
            return back()->with('thongbao', 'Email này đã tồn tại.');
        }
        
        $u = new user;
        $u->email = strtolower(trim(strip_tags($request['email'])));
        $u->name = trim(strip_tags($request['name']));
        $u->password = Hash::make($request['mk1']);
        $u->dia_chi = trim(strip_tags($request['dia_chi']));
        $u->dien_thoai = trim(strip_tags($request['dien_thoai'])); 
        $u->save();

        if (auth()->guard('web')->attempt(['email' => $request['email'], 'password' => $request['mk1']])) {
            Mail::to($u->email)->send(new Dangky($u));
            return back()->with('thongbao2', "Đăng ký hoàn tất!"); 
        } else {
            return back()->with('thongbao', 'Đăng ký không thành công');
        }
    
    }
    function camon(){ return view('camon'); }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.thongtinvaupdateUser.profile', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.thongtinvaupdateUser.edit', compact('user'));
    }

    public function update(updatethongtinValid $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255|unique:users,email,' . $id,
        //     'dien_thoai' => 'nullable|string|max:15',
        //     'dia_chi' => 'nullable|string|max:255',
        //     // Thêm các validation khác nếu cần
        // ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dien_thoai = $request->dien_thoai;
        $user->dia_chi = $request->dia_chi;
        $user->save();

        return redirect()->route('khuser.profile', ['id' => $id])
        ->with('success', 'Thông tin đã được cập nhật.');
    }

         
}
