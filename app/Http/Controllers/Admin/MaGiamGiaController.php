<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        $dsMaGiamGia = MaGiamGia::orderBy('id', 'desc')->get();

        return view('admin.ma_giam_gia.index', compact('dsMaGiamGia'));
    }

    public function store(Request $request)
    {
        $duLieu = $request->validate([
            'ma_code' => ['required', 'string', 'max:50', 'unique:ma_giam_gia,ma_code'],
            'ten_chuong_trinh' => ['required', 'string', 'max:150'],
            'loai_giam' => ['required', 'in:phan_tram,so_tien'],
            'gia_tri_giam' => ['required', 'numeric', 'min:1'],
            'giam_toi_da' => ['nullable', 'numeric', 'min:0'],
            'don_hang_toi_thieu' => ['nullable', 'numeric', 'min:0'],
            'so_luong_toi_da' => ['nullable', 'integer', 'min:1'],
            'ngay_bat_dau' => ['nullable', 'date'],
            'ngay_ket_thuc' => ['nullable', 'date', 'after_or_equal:ngay_bat_dau'],
            'trang_thai' => ['required', 'in:kich_hoat,tam_dung'],
        ]);

        $duLieu['ma_code'] = strtoupper(trim($duLieu['ma_code']));
        $duLieu['don_hang_toi_thieu'] = $duLieu['don_hang_toi_thieu'] ?? 0;

        MaGiamGia::create($duLieu);

        return redirect()->route('admin.ma_giam_gia.index')
            ->with('thong_bao', 'Đã thêm mã giảm giá mới.');
    }

    public function update(Request $request, int $id)
    {
        $ma = MaGiamGia::findOrFail($id);

        $duLieu = $request->validate([
            'ma_code' => ['required', 'string', 'max:50', 'unique:ma_giam_gia,ma_code,' . $ma->id],
            'ten_chuong_trinh' => ['required', 'string', 'max:150'],
            'loai_giam' => ['required', 'in:phan_tram,so_tien'],
            'gia_tri_giam' => ['required', 'numeric', 'min:1'],
            'giam_toi_da' => ['nullable', 'numeric', 'min:0'],
            'don_hang_toi_thieu' => ['nullable', 'numeric', 'min:0'],
            'so_luong_toi_da' => ['nullable', 'integer', 'min:1'],
            'ngay_bat_dau' => ['nullable', 'date'],
            'ngay_ket_thuc' => ['nullable', 'date', 'after_or_equal:ngay_bat_dau'],
            'trang_thai' => ['required', 'in:kich_hoat,tam_dung'],
        ]);

        $duLieu['ma_code'] = strtoupper(trim($duLieu['ma_code']));
        $duLieu['don_hang_toi_thieu'] = $duLieu['don_hang_toi_thieu'] ?? 0;

        $ma->update($duLieu);

        return redirect()->route('admin.ma_giam_gia.index')
            ->with('thong_bao', 'Đã cập nhật mã giảm giá.');
    }

    public function doiTrangThai(int $id)
    {
        $ma = MaGiamGia::findOrFail($id);

        $ma->update([
            'trang_thai' => $ma->trang_thai === 'kich_hoat' ? 'tam_dung' : 'kich_hoat',
        ]);

        return back()->with('thong_bao', 'Đã cập nhật trạng thái mã giảm giá.');
    }
}
