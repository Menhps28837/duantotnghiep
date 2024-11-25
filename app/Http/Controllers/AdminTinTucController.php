<?php

namespace App\Http\Controllers;

use App\Models\TinTuc;
use Illuminate\Http\Request;

class AdminTinTucController extends AdminController
{
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha
    }
    // Hiển thị danh sách tin tức
    public function index()
    {
        // Lấy tất cả tin tức và gửi đến view
        $tinTucs = TinTuc::all();
        return view('admin.tin_tuc_index', compact('tinTucs'));
    }

    // Hiển thị form tạo mới tin tức
    public function create()
    {
        return view('admin.tin_tuc_create');
    }

    // Xử lý lưu tin tức mới
    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Kiểm tra ảnh
            'ngay_dang' => 'required|date',
        ]);

        // Lưu ảnh nếu có
        if ($request->hasFile('anh')) {
            $imagePath = $request->file('anh')->store('tin_tuc_images', 'public');
        } else {
            $imagePath = null;
        }

        // Tạo tin tức mới
        TinTuc::create([
            'tieu_de' => $request->input('tieu_de'),
            'noi_dung' => $request->input('noi_dung'),
            'anh' => $imagePath,
            'ngay_dang' => $request->input('ngay_dang'),
        ]);

        return redirect()->route('admin.tin_tuc.index')->with('success', 'Tin tức đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa tin tức
    public function edit($id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        return view('admin.tin_tuc_edit', compact('tinTuc'));
    }

    // Xử lý cập nhật tin tức
    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Kiểm tra ảnh
            'ngay_dang' => 'required|date',
        ]);

        $tinTuc = TinTuc::findOrFail($id);

        // Xử lý ảnh nếu có
        if ($request->hasFile('anh')) {
            // Xóa ảnh cũ nếu có
            if ($tinTuc->anh && file_exists(storage_path('app/public/' . $tinTuc->anh))) {
                unlink(storage_path('app/public/' . $tinTuc->anh));
            }
            $imagePath = $request->file('anh')->store('tin_tuc_images', 'public');
        } else {
            $imagePath = $tinTuc->anh; // Giữ ảnh cũ nếu không thay đổi
        }

        // Cập nhật tin tức
        $tinTuc->update([
            'tieu_de' => $request->input('tieu_de'),
            'noi_dung' => $request->input('noi_dung'),
            'anh' => $imagePath,
            'ngay_dang' => $request->input('ngay_dang'),
        ]);

        return redirect()->route('admin.tin_tuc_index')->with('success', 'Tin tức đã được cập nhật!');
    }

    // Xóa tin tức
    public function destroy($id)
    {
        $tinTuc = TinTuc::findOrFail($id);

        // Xóa ảnh nếu có
        if ($tinTuc->anh && file_exists(storage_path('app/public/' . $tinTuc->anh))) {
            unlink(storage_path('app/public/' . $tinTuc->anh));
        }

        // Xóa tin tức
        $tinTuc->delete();

        return redirect()->route('admin.tin_tuc_index')->with('success', 'Tin tức đã được xóa!');
    }
}
