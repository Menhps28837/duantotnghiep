<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class dangnhapValid extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => 'required|min:6',
            ];
    }
    public function messages() {
        return [
         'email.required' => 'Chưa nhập email',
         'email.email' => 'Nhập email chưa đúng',
         'email.ends_with' => 'Email phải có đuôi là @gmail.com',
         'password.required' => 'Bạn chưa nhập mật khẩu',
         'password.min' => 'Mật khẩu từ 6 ký tự trở lên',
       ];
     }

}
