<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\SendsPasswordResetEmails;
use Illuminate\Auth\Passwords\Password;
use App\Mail\ForgotPassword;
use App\Models\password_reset_tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\View;


class ForgotPasswordController extends Controller
{
    // use SendsPasswordResetEmails;

    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien','=',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr );
     }

    public function forgot_password()
    {
        return view('password_email');
    }

    public function check_forgot_password(Request $request)
    {
        // Xác thực email
        $request->validate(['email' => 'required|exists:users,email']);

        $customer = User::where('email',$request->email)->first();
        $token = \Str::random(40);
        $tokendata = [
            'email' => $request->email,
            'token' => $token
        ];
        $checkmail = password_reset_tokens::where('email',$request->email)->first();
        if($checkmail){
            $checkmail->token=$token;
            $checkmail->save();
            Mail::to($request->email)->send(new ForgotPassword($customer, $token));
            return redirect()->back()->with('thongbao2', 'Đã gửi email thành công, phiền bạn check email');
            
        }
        else if (password_reset_tokens::create($tokendata)) {
            Mail::to($request->email)->send(new ForgotPassword($customer,$token));
            return redirect()->back()->with('thongbao2','Đã gửi email thành công, phiền bạn check email');

        }
        return redirect()->back()->with('thongbao','Email không đúng, phiền bạn chọn email lại');
    }

    public function reset_password($token){
        
        $tokendata = password_reset_tokens::checkToken($token);
        // $tokendata = password_reset_tokens::where('token', $token)->firstOrFail();
        // $customer = User::where('email',$tokendata->email)->firstOrFail();
        return view('email.reset_password', ['token' => $token]);
    }

    public function check_reset_password($token){
        request()->validate([
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);
        $tokendata = password_reset_tokens::checkToken($token);
        $customer = $tokendata->customer;

        $data = [
            'password' => bcrypt(request(('password')))
        ];

        $check = $customer->update($data);

        if($check){
            return redirect('/admin/dangnhap')->with('thongbao2','Cập nhật mật khẩu thành công');
        }
        return redirect()->back()->with('thongbao','Đã xảy ra lỗi phiền bạn cập nhật lại');
    }
}
