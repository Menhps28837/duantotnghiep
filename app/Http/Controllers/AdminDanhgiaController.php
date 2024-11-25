<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Danh_Gia;

class AdminDanhgiaController extends AdminController
{
    
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha
    }
    // Hiển thị danh sách tất cả các đánh giá
    public function index()
    {
        $reviews = Danh_Gia::with('user','product')->get();  // Tải tất cả các đánh giá và thông tin người dùng
        $thoiGianMoi = now()->subDay();
        return view('admin.danhgia_ds', compact('reviews','thoiGianMoi'));
    }

    // Hiển thị form chỉnh sửa đánh giá
    public function edit($id)
    {
        $review = Danh_Gia::findOrFail($id); // Tìm kiếm đánh giá theo ID
        return view('admin.danhgia_chinh', compact('review'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, $id)
    {
        $review = Danh_Gia::findOrFail($id);
        $review->update([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);
        return redirect()->route('admin.danhgia_ds')->with('success', 'Đánh giá đã được cập nhật');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Danh_Gia::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.danhgia_ds')->with('success', 'Đánh giá đã được xóa');
    }
}
