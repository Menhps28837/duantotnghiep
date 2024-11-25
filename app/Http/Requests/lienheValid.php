<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class lienheValid extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'ho_ten' => ['required','min:2', 'max:30'],
            'email' => 'required|email|ends_with:@gmail.com',
            'dien_thoai' => 'required|min:10|regex:/^[0-9]+$/',
            'noi_dung' => 'required'
            ];
    }
    public function messages() {
        return [
         'ho_ten.required' => 'Phải nhập họ tên nha bạn ơi',
         'ho_ten.min' => 'Nhập họ tên ít nhất 2 ký tự',
         'ho_ten.max' => 'Họ tên gì mà dài quá thế',
         'email.required' => 'Chưa nhập email',
         'email.email' => 'Nhập email chưa đúng',
         'email.ends_with' => 'Email phải có đuôi là @gmail.com',
         'dien_thoai.required' => 'Bạn chưa nhập số điện thoại',
         'dien_thoai.min' => 'Số điện thoại phải ít nhất có 10 số',
         'dien_thoai.regex' => 'Số điện thoại chỉ được phép chứa số',
         'noi_dung.required' => 'Phải nhập nội dung nha bạn ơi',
        //  'noi_dung.regex' => 'Nội dung chỉ được nhập chữ và số nha bạn ơi'
         
       ];
     }

}
