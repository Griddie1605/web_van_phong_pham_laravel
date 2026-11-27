<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\MaGiamGia;
use App\Models\NhatKyKho;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatHangController extends Controller
{
    public function formDatHang()
    {
        $gioHang = session('gio_hang', []);
        if (empty($gioHang)) {
            return redirect()->route('gio_hang.index')
                ->with('thong_bao', 'Giỏ hàng đang trống, vui lòng chọn sản phẩm trước khi đặt hàng.');
        }

        $tongTienHang = 0;
        foreach ($gioHang as $item) {
            $tongTienHang += $item['gia_ban'] * $item['so_luong'];
        }

        $maApDung = session('ma_giam_gia');
        $tienGiam = $maApDung ? min((float) ($maApDung['tien_giam'] ?? 0), $tongTienHang) : 0;
        $thanhTien = max(0, $tongTienHang - $tienGiam);
        $nguoiDung = Auth::user();

        return view('don_hang.dat_hang', compact(
            'gioHang',
            'tongTienHang',
            'maApDung',
            'tienGiam',
            'thanhTien',
            'nguoiDung'
        ));
    }

    public function xuLyDatHang(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:100',
            'sdt_nguoi_nhan' => 'required|string|max:20',
            'dia_chi_giao' => 'required|string|max:500',
            'phuong_thuc_thanh_toan' => 'required|in:COD,chuyen_khoan',
            'ghi_chu' => 'nullable|string|max:500',
        ], [
            'ten_nguoi_nhan.required' => 'Vui lòng nhập tên người nhận.',
            'sdt_nguoi_nhan.required' => 'Vui lòng nhập số điện thoại.',
            'dia_chi_giao.required' => 'Vui lòng nhập địa chỉ giao hàng.',
            'phuong_thuc_thanh_toan.required' => 'Vui lòng chọn phương thức thanh toán.',
        ]);

        $gioHang = session('gio_hang', []);
        if (empty($gioHang)) {
            return redirect()->route('gio_hang.index')
                ->with('thong_bao', 'Giỏ hàng đang trống.');
        }

        $nguoiDungId = Auth::id();
        $maApDung = session('ma_giam_gia');

        try {
            $donHang = DB::transaction(function () use ($request, $gioHang, $nguoiDungId, $maApDung) {
                $tongTienHang = 0;
                $sanPhamKhoa = [];

                foreach ($gioHang as $item) {
                    $sp = SanPham::where('id', $item['id'])->lockForUpdate()->first();
                    if (!$sp || $sp->trang_thai !== 'hien') {
                        throw new \Exception('Sản phẩm "' . ($item['ten_san_pham'] ?? '') . '" không còn kinh doanh.');
                    }
                    if ($sp->so_luong_ton < $item['so_luong']) {
                        throw new \Exception('Sản phẩm "' . $sp->ten_san_pham . '" chỉ còn ' . $sp->so_luong_ton . ' ' . $sp->don_vi_tinh . '.');
                    }

                    $tongTienHang += (float) $sp->gia_ban * (int) $item['so_luong'];
                    $sanPhamKhoa[] = [
                        'model' => $sp,
                        'so_luong' => (int) $item['so_luong'],
                        'don_gia' => (float) $sp->gia_ban,
                    ];
                }

                $maGiamGiaId = null;
                $tienGiam = 0;

                if ($maApDung && !empty($maApDung['id'])) {
                    $maDb = MaGiamGia::where('id', $maApDung['id'])->lockForUpdate()->first();
                    $hopLe = $maDb
                        && $maDb->trang_thai === 'kich_hoat'
                        && (!$maDb->ngay_bat_dau || now()->gte($maDb->ngay_bat_dau))
                        && (!$maDb->ngay_ket_thuc || now()->lte($maDb->ngay_ket_thuc))
                        && (is_null($maDb->so_luong_gioi_han) || $maDb->da_su_dung < $maDb->so_luong_gioi_han)
                        && $tongTienHang >= (float) $maDb->don_hang_toi_thieu;

                    if ($hopLe) {
                        $maGiamGiaId = $maDb->id;
                        if ($maDb->loai_giam === 'phan_tram') {
                            $tienGiam = round($tongTienHang * ((float) $maDb->gia_tri_giam / 100));
                            if (!is_null($maDb->giam_toi_da) && (float) $maDb->giam_toi_da > 0) {
                                $tienGiam = min($tienGiam, (float) $maDb->giam_toi_da);
                            }
                        } else {
                            $tienGiam = (float) $maDb->gia_tri_giam;
                        }
                        $tienGiam = min($tienGiam, $tongTienHang);
                        $maDb->increment('da_su_dung');
                    }
                }

                $thanhTien = max(0, $tongTienHang - $tienGiam);
                $maDonHang = 'DH' . now()->format('ymdHis') . strtoupper(Str::random(3));

                $donHangMoi = DonHang::create([
                'ma_don_hang' => $maDonHang,
                'nguoi_dung_id' => $nguoiDungId,
                'ma_giam_gia_id' => $maGiamGiaId,
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'sdt_nguoi_nhan' => $request->sdt_nguoi_nhan,
                'dia_chi_giao' => $request->dia_chi_giao,
                'tam_tinh' => $tongTienHang,
                'so_tien_giam' => $tienGiam,
                'tong_thanh_toan' => $thanhTien,
                'phuong_thuc_thanh_toan' => strtolower($request->phuong_thuc_thanh_toan),
                'trang_thai' => 'cho_xac_nhan',
                'ghi_chu' => $request->ghi_chu,
            ]);


                foreach ($sanPhamKhoa as $dong) {
                    $sp = $dong['model'];
                    $soLuongMua = $dong['so_luong'];
                    $tonTruoc = (int) $sp->so_luong_ton;
                    $tonSau = $tonTruoc - $soLuongMua;

                    ChiTietDonHang::create([
                        'don_hang_id' => $donHangMoi->id,
                        'san_pham_id' => $sp->id,
                        'so_luong' => $soLuongMua,
                        'don_gia' => $dong['don_gia'],
                        'thanh_tien' => $dong['don_gia'] * $soLuongMua,
                    ]);

                    $sp->update(['so_luong_ton' => $tonSau]);

                    NhatKyKho::create([
                        'san_pham_id' => $sp->id,
                        'nguoi_thuc_hien_id' => $nguoiDungId,
                        'loai_bien_dong' => 'xuat_ban',
                        'so_luong_thay_doi' => -$soLuongMua,
                        'ton_sau_bien_dong' => $tonSau,
                        'ghi_chu' => 'Khách đặt đơn ' . $maDonHang,
                    ]);

                }

                return $donHangMoi;
            });
        } catch (\Exception $e) {
            return redirect()->route('gio_hang.index')
                ->withErrors(['ma_code' => $e->getMessage()]);
        }

        session()->forget(['gio_hang', 'ma_giam_gia']);

        return redirect()->route('don_hang.chi_tiet', $donHang->id)
            ->with('thong_bao', 'Đặt hàng thành công! Mã đơn của bạn là ' . $donHang->ma_don_hang . '.');
    }

    public function lichSu()
    {
        $dsDonHang = DonHang::where('nguoi_dung_id', Auth::id())
            ->latest('id')
            ->paginate(10);

        return view('don_hang.lich_su', compact('dsDonHang'));
    }

    public function chiTiet(int $id)
    {
        $donHang = DonHang::with(['chiTietDonHang.sanPham', 'maGiamGia'])
            ->where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->firstOrFail();

        return view('don_hang.chi_tiet', compact('donHang'));
    }

    public function huyDon(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $donHang = DonHang::with('chiTietDonHang')
                    ->where('id', $id)
                    ->where('nguoi_dung_id', Auth::id())
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($donHang->trang_thai !== 'cho_xac_nhan') {
                    throw new \Exception('Chỉ có thể hủy đơn hàng đang ở trạng thái Chờ xác nhận.');
                }

                foreach ($donHang->chiTietDonHang as $ct) {
                    $sp = SanPham::where('id', $ct->san_pham_id)->lockForUpdate()->first();
                    if ($sp) {
                        $tonTruoc = (int) $sp->so_luong_ton;
                        $hoanLai = (int) $ct->so_luong;
                        $tonSau = $tonTruoc + $hoanLai;

                        $sp->update(['so_luong_ton' => $tonSau]);

                        NhatKyKho::create([
                            'san_pham_id' => $sp->id,
                            'nguoi_thuc_hien_id' => Auth::id(),
                            'loai_bien_dong' => 'hoan_tra',
                            'so_luong_thay_doi' => $hoanLai,
                            'ton_sau_bien_dong' => $tonSau,
                            'ghi_chu' => 'Khách hủy đơn ' . $donHang->ma_don_hang,
                        ]);

                    }
                }

                if ($donHang->ma_giam_gia_id) {
                    $ma = MaGiamGia::where('id', $donHang->ma_giam_gia_id)->lockForUpdate()->first();
                    if ($ma && $ma->da_su_dung > 0) {
                        $ma->decrement('da_su_dung');
                    }
                }

                $donHang->update([
                    'trang_thai' => 'da_huy',
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('thong_bao', $e->getMessage());
        }

        return back()->with('thong_bao', 'Đã hủy đơn hàng và hoàn lại số lượng tồn kho.');
    }
}
