<?php

namespace App\Http\Controllers;
use App\Models\Doanh_thu;
use App\Models\don_hang;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class AdminDoanhThuController extends AdminController
{
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha
    }

    public function index()
    {
        // Lấy tổng doanh thu theo tháng
        $doanhThu = doanh_thu::select('thang', 'nam', 'tong_doanh_thu', 'so_luong_don_hang')
        ->groupBy('thang', 'nam', 'tong_doanh_thu', 'so_luong_don_hang')
            ->orderBy('nam', 'desc')
            ->orderBy('thang', 'desc')
            ->get();

        return view('admin.doanh_thu', compact('doanhThu'));
    }

    public function detail($thang, $nam)
    {
        // Lấy chi tiết doanh thu cho tháng và năm đã chọn
        $chiTiet = don_hang::whereMonth('thoi_diem_mua_hang', $thang)
            ->whereYear('thoi_diem_mua_hang', $nam)
            ->whereIn('trang_thai', [4])
            ->select('id', 'tong_tien', 'thoi_diem_mua_hang')
            ->get();

        $tongSoLuong = $chiTiet->count();
        $tongDoanhThu = $chiTiet->sum('tong_tien');

        return view('admin.doanh_thu_detail', compact('chiTiet', 'tongSoLuong', 'tongDoanhThu', 'thang', 'nam'));
    }
    
}
