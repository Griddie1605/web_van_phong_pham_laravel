<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\NhatKyKho;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DonHang::query()->latest('id');

        if ($request->filled('tu_khoa')) {
            $tuKhoa = trim($request->tu_khoa);
            $query->where(function ($q) use ($tuKhoa) {
                $q->where('ma_don_hang', 'like', "%{$tuKhoa}%")
                    ->orWhere('ten_nguoi_nhan', 'like', "%{$tuKhoa}%")
                    ->orWhere('sdt_nguoi_nhan', 'like', "%{$tuKhoa}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $dsDonHang = $query->paginate(12)->withQueryString();

        return view('admin.don_hang.index', compact('dsDonHang'));
    }

    public function show(int $id)
    {
        $donHang = DonHang::with(['chiTietDonHang.sanPham', 'nguoiDung', 'maGiamGia'])->findOrFail($id);

        return view('admin.don_hang.show', compact('donHang'));
    }

    public function capNhatTrangThai(Request $request, int $id)
    {
        $request->validate([
            'trang_thai' => ['required', 'in:cho_xac_nhan,dang_giao,hoan_tat,da_huy'],
        ]);

        $trangThaiMoi = $request->trang_thai;

        DB::transaction(function () use ($id, $trangThaiMoi) {
            $donHang = DonHang::with('chiTietDonHang')->lockForUpdate()->findOrFail($id);
            $trangThaiCu = $donHang->trang_thai;

            if ($trangThaiCu === $trangThaiMoi || $trangThaiCu === 'da_huy') {
                return;
            }

            $donHang->update([
                'trang_thai' => $trangThaiMoi,
            ]);

            if ($trangThaiMoi === 'da_huy') {
                foreach ($donHang->chiTietDonHang as $ct) {
                    $sp = SanPham::lockForUpdate()->find($ct->san_pham_id);
                    if ($sp) {
                        $tonSau = (int) $sp->so_luong_ton + (int) $ct->so_luong;
                        $sp->update(['so_luong_ton' => $tonSau]);

                        NhatKyKho::create([
                            'san_pham_id' => $sp->id,
                            'nguoi_thuc_hien_id' => Auth::id(),
                            'loai_bien_dong' => 'hoan_tra',
                            'so_luong_thay_doi' => (int) $ct->so_luong,
                            'ton_sau_bien_dong' => $tonSau,
                            'ghi_chu' => 'Hoàn kho do hủy đơn ' . $donHang->ma_don_hang,
                        ]);
                    }
                }
            }
        });

        return back()->with('thong_bao', 'Đã cập nhật trạng thái đơn hàng.');
    }
}
