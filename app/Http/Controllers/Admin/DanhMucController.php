<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DanhMucController extends Controller
{
    public function index()
    {
        $dsDanhMuc = DanhMuc::withCount('sanPham')->orderBy('id', 'desc')->get();
        return view('admin.danh_muc.index', compact('dsDanhMuc'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:120|unique:danh_muc,ten_danh_muc',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'ten_danh_muc.unique' => 'Tên danh mục đã tồn tại.',
        ]);

        $duongDan = $this->taoDuongDanDuyNhat($request->ten_danh_muc);

        DanhMuc::create([
            'ten_danh_muc' => $request->ten_danh_muc,
            'duong_dan' => $duongDan,
            'mo_ta' => $request->mo_ta,
        ]);

        return back()->with('thong_bao', 'Đã thêm danh mục mới.');
    }

    public function update(Request $request, int $id)
    {
        $danhMuc = DanhMuc::findOrFail($id);

        $request->validate([
            'ten_danh_muc' => 'required|string|max:120|unique:danh_muc,ten_danh_muc,' . $id,
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'ten_danh_muc.unique' => 'Tên danh mục đã tồn tại.',
        ]);

        $danhMuc->update([
            'ten_danh_muc' => $request->ten_danh_muc,
            'duong_dan' => $this->taoDuongDanDuyNhat($request->ten_danh_muc, $id),
            'mo_ta' => $request->mo_ta,
        ]);

        return back()->with('thong_bao', 'Đã cập nhật danh mục.');
    }

    public function doiTrangThai(int $id)
    {
        $danhMuc = DanhMuc::findOrFail($id);
        $trangThaiMoi = $danhMuc->trang_thai === 'hien' ? 'an' : 'hien';

        $danhMuc->update([
            'trang_thai' => $trangThaiMoi,
        ]);

        return back()->with('thong_bao', 'Đã cập nhật trạng thái hiển thị danh mục.');
    }


    private function taoDuongDanDuyNhat(string $ten, ?int $boQuaId = null): string
    {
        $goc = Str::slug($ten) ?: 'danh-muc';
        $slug = $goc;
        $i = 1;

        while (
            DanhMuc::where('duong_dan', $slug)
                ->when($boQuaId, fn($q) => $q->where('id', '!=', $boQuaId))
                ->exists()
        ) {
            $slug = $goc . '-' . $i++;
        }

        return $slug;
    }
}
