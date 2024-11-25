<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class dangKyValid extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required','min:2', 'max:30', 'regex:/^[\p{L} ]+$/u'], // Chỉ cho phép ký tự chữ và khoảng trắng
            'email' => 'required|email|ends_with:@gmail.com',
            'mk1' => 'required|min:6|same:mk2',
            'mk2' => 'required|min:6',
            'dien_thoai' => 'required|min:10|regex:/^[0-9]+$/',// Chỉ cho phép ký tự số
            'dia_chi' => 'required|regex:/^[\p{L}\d\s,.-]+$/u', // Cho phép chữ cái, số, khoảng trắng, dấu phẩy, dấu chấm, dấu gạch ngang
            ];
    }
    public function messages() {
        return [
         'name.required' => 'Phải nhập họ tên nha bạn ơi',
         'name.min' => 'Nhập họ tên ít nhất 2 ký tự',
         'name.max' => 'Họ tên gì mà dài quá thế',
         'name.regex' => 'Họ tên chỉ được phép chứa chữ cái và khoảng trắng',
         'email.required' => 'Chưa nhập email',
         'email.email' => 'Nhập email chưa đúng',
         'email.ends_with' => 'Email phải có đuôi là @gmail.com',
         'mk1.required' => 'Bạn chưa nhập mật khẩu',
         'mk1.min' => 'Mật khẩu từ 6 ký tự trở lên',
         'mk1.same' => 'Hai mật khẩu không giống nhau',
         'mk2.required' => 'Bạn chưa nhập lại mật khẩu',
         'mk2.min' => 'Mật khẩu nhập lại cùng từ 6 ký tự trở lên',
         'dien_thoai.required' => 'Bạn chưa nhập số điện thoại',
         'dien_thoai.min' => 'Số điện thoại phải ít nhất có 10 số',
         'dien_thoai.regex' => 'Số điện thoại chỉ được phép chứa số',
         'dia_chi.required' => 'Bạn chưa nhập địa chỉ nhà',
         'dia_chi.regex' => 'Địa chỉ chỉ được phép chứa chữ cái, số, dấu phẩy, dấu chấm và dấu gạch ngang'
       ];
     }

}
