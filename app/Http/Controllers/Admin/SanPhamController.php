<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPham::with('danhMuc')->orderBy('id', 'desc');

        if ($request->filled('tu_khoa')) {
            $tuKhoa = trim($request->tu_khoa);
            $query->where('ten_san_pham', 'like', "%{$tuKhoa}%");
        }

        if ($request->filled('danh_muc_id')) {
            $query->where('danh_muc_id', $request->danh_muc_id);
        }

        $dsSanPham = $query->paginate(12)->withQueryString();
        $dsDanhMuc = DanhMuc::orderBy('ten_danh_muc')->get();

        return view('admin.san_pham.index', compact('dsSanPham', 'dsDanhMuc'));
    }

    public function create()
    {
        $dsDanhMuc = DanhMuc::orderBy('ten_danh_muc')->get();
        return view('admin.san_pham.form', ['sanPham' => null, 'dsDanhMuc' => $dsDanhMuc]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'ten_san_pham' => 'required|string|max:180',
            'don_vi_tinh' => 'required|string|max:30',
            'gia_ban' => 'required|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'trang_thai' => 'required|in:hien,an',
            'mo_ta' => 'nullable|string',
            'hinh_anh' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $duongDanAnh = null;
        if ($request->hasFile('hinh_anh')) {
            $duongDanAnh = $request->file('hinh_anh')->store('san_pham', 'public');
        }

        SanPham::create([
            'danh_muc_id' => $request->danh_muc_id,
            'ten_san_pham' => $request->ten_san_pham,
            'duong_dan' => $this->taoDuongDanDuyNhat($request->ten_san_pham),
            'don_vi_tinh' => $request->don_vi_tinh,
            'gia_ban' => $request->gia_ban,
            'so_luong_ton' => $request->so_luong_ton,
            'trang_thai' => $request->trang_thai,
            'mo_ta' => $request->mo_ta,
            'hinh_anh' => $duongDanAnh,
        ]);

        return redirect()->route('admin.san_pham.index')->with('thong_bao', 'Đã thêm sản phẩm mới.');
    }

    public function edit(int $id)
    {
        $sanPham = SanPham::findOrFail($id);
        $dsDanhMuc = DanhMuc::orderBy('ten_danh_muc')->get();
        return view('admin.san_pham.form', compact('sanPham', 'dsDanhMuc'));
    }

    public function update(Request $request, int $id)
    {
        $sanPham = SanPham::findOrFail($id);

        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'ten_san_pham' => 'required|string|max:180',
            'don_vi_tinh' => 'required|string|max:30',
            'gia_ban' => 'required|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'trang_thai' => 'required|in:hien,an',
            'mo_ta' => 'nullable|string',
            'hinh_anh' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $duongDanAnh = $sanPham->hinh_anh;
        if ($request->hasFile('hinh_anh')) {
            if ($duongDanAnh && Storage::disk('public')->exists($duongDanAnh)) {
                Storage::disk('public')->delete($duongDanAnh);
            }
            $duongDanAnh = $request->file('hinh_anh')->store('san_pham', 'public');
        }

        $sanPham->update([
            'danh_muc_id' => $request->danh_muc_id,
            'ten_san_pham' => $request->ten_san_pham,
            'duong_dan' => $this->taoDuongDanDuyNhat($request->ten_san_pham, $id),
            'don_vi_tinh' => $request->don_vi_tinh,
            'gia_ban' => $request->gia_ban,
            'so_luong_ton' => $request->so_luong_ton,
            'trang_thai' => $request->trang_thai,
            'mo_ta' => $request->mo_ta,
            'hinh_anh' => $duongDanAnh,
        ]);

        return redirect()->route('admin.san_pham.index')->with('thong_bao', 'Đã cập nhật sản phẩm.');
    }

    public function doiTrangThai(int $id)
    {
        $sanPham = SanPham::findOrFail($id);
        $sanPham->update([
            'trang_thai' => $sanPham->trang_thai === 'hien' ? 'an' : 'hien',
        ]);

        return back()->with('thong_bao', 'Đã đổi trạng thái hiển thị sản phẩm.');
    }

    private function taoDuongDanDuyNhat(string $ten, ?int $boQuaId = null): string
    {
        $goc = Str::slug($ten) ?: 'san-pham';
        $slug = $goc;
        $i = 1;

        while (
            SanPham::where('duong_dan', $slug)
                ->when($boQuaId, fn($q) => $q->where('id', '!=', $boQuaId))
                ->exists()
        ) {
            $slug = $goc . '-' . $i++;
        }

        return $slug;
    }
}
