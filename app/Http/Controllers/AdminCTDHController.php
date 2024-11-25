<?php

namespace App\Http\Controllers;
use App\Models\don_hang;
use App\Models\don_hang_chi_tiet;
use App\Models\thuoc_tinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\san_pham;
use App\Models\so_luong_ton_kho;
use App\Models\User;
use App\Models\lien_he;
use App\Models\binh_luan;

class AdminCTDHController extends AdminController
{
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha
    }


    public function index()
    {
        $ctdh = don_hang_chi_tiet::all();
        return view('admin/ctdh_ds', compact('ctdh'));
    }
    public function create()
    {
       //
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'order_number' => 'required|unique:orders',
        //     'total_amount' => 'required|numeric',
        //     'status' => 'required|string',
        // ]);
        // don_hang::create($request->all());
        // return redirect()->route('donhang.index');

        // $obj = new  don_hang;
        // $obj->ten_nguoi_nhan = $request['ten_nguoi_nhan'];
        // $obj->email = $request['email'];
        // $obj->dien_thoai = $request['dien_thoai'];
        // $obj->dia_chi_giao = $request['dia_chi_giao'];
        // $obj->trang_thai = (int) $request['trang_thai'];
        // $obj->save();
        // return redirect(route('donhang.index'))->with('thongbao','Thêm thành công');
        //

    }

    public function show(string $id)
    {
       
    }

    public function edit(don_hang $donhang)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'order_number' => 'required|unique:orders,order_number,' . $donhang->id,
        //     'total_amount' => 'required|numeric',
        //     'status' => 'required|string',
        // ]);
    
        // $donhang->update($request->all());
        // return redirect()->route('donhang.index');

        // $obj = don_hang::find($id);
        // $obj->ten_nguoi_nhan = $request['ten_nguoi_nhan'];
        // $obj->email = $request['email'];
        // $obj->dien_thoai = $request['dien_thoai'];
        // $obj->dia_chi_giao = $request['dia_chi_giao'];
        // $obj->trang_thai = (int) $request['trang_thai'];
        // $obj->save();
        // return redirect(route('donhang.index'))->with('thongbao', 'Cập nhập thành công');
    }

    public function destroy(Request $request,  string $id)
    {
        // $cokhong = don_hang::where('id', $id)->exists();
        // if ($cokhong==false) {
        //     $request->session()->flash('thongbao','Sản phẩm không tồn tại');
        //     return redirect('/admin/donhang_ds');
        // }
        // don_hang::where('id', $id)->delete();
        // $request->session()->flash('thongbao', 'Đã xóa sản phẩm');
        // return redirect('/admin/donhang_ds');




        // $donhang->delete();
        // return redirect()->route('donhang.index');
    }
    // function khoiphuc($id) {
    //     $dh = don_hang::withTrashed()->find($id);
    //     if ($dh == null) return redirect('/thongbao');
    //     $dh->restore();
    //     return redirect('/admin/donhang?trangthai=daxoa');
    // }
    // function xoavinhvien($id) {
    //     $dh = don_hang::withTrashed()->find($id);
    //     if ($dh == null) return redirect('/thongbao');
    //     $tt = thuoc_tinh::where('id_dh', $id);
    //     if($tt!=null) $tt->delete();
    //     $dh->forceDelete();
    //     return redirect('/admin/donhang?trangthai=daxoa');
    // }

    public function chitiet(Request $request, string $id)
    {
        // $request->validate([
        //     'order_number' => 'required|unique:orders,order_number,' . $donhang->id,
        //     'total_amount' => 'required|numeric',
        //     'status' => 'required|string',
        // ]);
    
        // $donhang->update($request->all());
        // return redirect()->route('donhang.index');

        $obj = don_hang_chi_tiet::find($id);
        $obj->id_dh = $request['id_dh'];
        $obj->id_sp = $request['id_sp'];
        $obj->ten_sp = $request['ten_sp'];
        $obj->hinh = $request['hinh'];
        $obj->so_luong = $request['so_luong'];
        $obj->gia = $request['gia'];
        // $obj->save();
        return redirect(route('donhang.index'))->with('thongbao', 'Cập nhập thành công');
    }
}
