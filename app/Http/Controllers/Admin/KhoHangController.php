<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietPhieuNhap;
use App\Models\NhatKyKho;
use App\Models\PhieuNhap;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KhoHangController extends Controller
{
    public function formNhapKho()
    {
        $dsSanPham = SanPham::orderBy('ten_san_pham')->get();
        $dsPhieuNhap = PhieuNhap::with('chiTietPhieuNhap.sanPham')
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();

        return view('admin.kho.nhap_kho', compact('dsSanPham', 'dsPhieuNhap'));
    }

    public function xuLyNhapKho(Request $request)
    {
        $request->validate([
            'nha_cung_cap' => 'nullable|string|max:200',
            'ghi_chu' => 'nullable|string|max:500',
            'chi_tiet' => 'required|array|min:1',
            'chi_tiet.*.san_pham_id' => 'required|exists:san_pham,id',
            'chi_tiet.*.so_luong' => 'required|integer|min:1',
            'chi_tiet.*.don_gia_nhap' => 'required|numeric|min:0',
        ], [
            'chi_tiet.required' => 'Vui lòng chọn ít nhất một sản phẩm để nhập kho.',
            'chi_tiet.*.so_luong.min' => 'Số lượng nhập phải lớn hơn hoặc bằng 1.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $tongTienNhap = 0;
                $dongHopLe = [];

                foreach ($request->chi_tiet as $dong) {
                    $sp = SanPham::where('id', $dong['san_pham_id'])->lockForUpdate()->first();
                    $soLuong = (int) $dong['so_luong'];
                    $donGia = (float) ($dong['don_gia_nhap'] ?? 0);
                    $thanhTienDong = $soLuong * $donGia;

                    $tongTienNhap += $thanhTienDong;
                    $dongHopLe[] = [
                        'sp' => $sp,
                        'so_luong' => $soLuong,
                        'don_gia' => $donGia,
                        'thanh_tien' => $thanhTienDong,
                    ];
}


                $maPhieu = 'PN' . now()->format('ymdHis') . strtoupper(Str::random(3));

                $phieuNhap = PhieuNhap::create([
                    'ma_phieu_nhap' => $maPhieu,
                    'nguoi_lap_id' => Auth::id(),
                    'nha_cung_cap' => $request->nha_cung_cap,
                    'ngay_nhap' => now(),
                    'tong_tien_nhap' => $tongTienNhap,
                    'ghi_chu' => $request->ghi_chu,
                ]);

                foreach ($dongHopLe as $item) {
                    $sp = $item['sp'];
                    $soLuong = $item['so_luong'];
                    $tonSau = (int) $sp->so_luong_ton + $soLuong;

                    ChiTietPhieuNhap::create([
                        'phieu_nhap_id' => $phieuNhap->id,
                        'san_pham_id' => $sp->id,
                        'so_luong_nhap' => $soLuong,
                        'gia_nhap' => $item['don_gia'],
                        'thanh_tien' => $item['thanh_tien'],
                    ]);

                    $sp->update([
                        'so_luong_ton' => $tonSau,
                    ]);

                    NhatKyKho::create([
                        'san_pham_id' => $sp->id,
                        'nguoi_thuc_hien_id' => Auth::id(),
                        'loai_bien_dong' => 'nhap_kho',
                        'so_luong_thay_doi' => $soLuong,
                        'ton_sau_bien_dong' => $tonSau,
                        'ghi_chu' => 'Nhập kho theo phiếu ' . $maPhieu . ($request->ghi_chu ? ' - ' . $request->ghi_chu : ''),
                    ]);
                }

            });
        } catch (\Exception $e) {
            return back()->withInput()->with('thong_bao', 'Lỗi nhập kho: ' . $e->getMessage());
        }

        return back()->with('thong_bao', 'Đã lập phiếu nhập kho và cập nhật tồn kho thành công.');
    }

    public function nhatKy(Request $request)
    {
        $query = NhatKyKho::with(['sanPham', 'nguoiThucHien'])->orderBy('id', 'desc');

        if ($request->filled('loai_bien_dong')) {
            $query->where('loai_bien_dong', $request->loai_bien_dong);
        }

        if ($request->filled('san_pham_id')) {
            $query->where('san_pham_id', $request->san_pham_id);
        }

        $dsNhatKy = $query->paginate(20)->withQueryString();
        $dsSanPham = SanPham::orderBy('ten_san_pham')->get();

        return view('admin.kho.nhat_ky', compact('dsNhatKy', 'dsSanPham'));
    }

    public function dieuChinhTon(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|exists:san_pham,id',
            'ton_thuc_te' => 'required|integer|min:0',
            'ghi_chu' => 'nullable|string|max:255',
        ], [
            'san_pham_id.required' => 'Vui lòng chọn sản phẩm.',
            'ton_thuc_te.required' => 'Vui lòng nhập số lượng tồn thực tế.',
        ]);

        DB::transaction(function () use ($request) {
            $sp = SanPham::where('id', $request->san_pham_id)->lockForUpdate()->first();
            $tonCu = (int) $sp->so_luong_ton;
            $tonMoi = (int) $request->ton_thuc_te;
            $chenhLech = $tonMoi - $tonCu;

            if ($chenhLech === 0) {
                return;
            }

            $sp->update(['so_luong_ton' => $tonMoi]);

            NhatKyKho::create([
                'san_pham_id' => $sp->id,
                'nguoi_thuc_hien_id' => Auth::id(),
                'loai_bien_dong' => 'dieu_chinh',
                'so_luong_thay_doi' => $chenhLech,
                'ton_sau_bien_dong' => $tonMoi,
                'ghi_chu' => $request->ghi_chu ?: ('Điều chỉnh kiểm kê từ ' . $tonCu . ' sang ' . $tonMoi),
            ]);
        });

        return back()->with('thong_bao', 'Đã cập nhật điều chỉnh tồn kho.');
    }
}
