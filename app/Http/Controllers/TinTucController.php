<?php

// app/Http/Controllers/TinTucController.php

namespace App\Http\Controllers;

use App\Models\TinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class TinTucController extends Controller
{
    public function __construct() {
        $loai_arr = DB::table('loai')->where('an_hien',1 )->orderBy('thu_tu')->get();
        View::share( 'loai_arr', $loai_arr  );
    } 
    // Hiển thị danh sách tin tức
    public function index()
    {
        $per_page= env('PER_PAGE');
        $tinTucs = TinTuc::orderBy('ngay_dang', 'desc')->paginate($per_page)->withQueryString();
        return view('tin_tuc.index', compact('tinTucs'));
    }

    // Hiển thị chi tiết tin tức
    public function show($id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        return view('tin_tuc.show', compact('tinTuc'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'anh' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Kiểm tra ảnh hợp lệ
        ]);

        // Lưu tin tức vào bảng tin_tucs
        $tinTuc = new TinTuc();
        $tinTuc->title = $request->title;
        $tinTuc->content = $request->content;

        // Kiểm tra xem có ảnh hay không
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            // Lưu ảnh vào thư mục 'tin_tuc' trong 'storage/app/public'
            $path = $file->store('tin_tuc', 'public');
            // Lưu đường dẫn ảnh vào trường 'anh' của bài viết tin tức
            $tinTuc->anh = $path;
        }

        // Lưu tin tức vào cơ sở dữ liệu
        $tinTuc->save();

        return redirect()->route('tinTuc.show', $tinTuc->id)->with('success', 'Tin tức đã được tạo thành công!');
    }
}

