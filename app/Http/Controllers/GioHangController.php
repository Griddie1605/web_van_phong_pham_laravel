<?php

namespace App\Http\Controllers;

use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Http\Request;

class GioHangController extends Controller
{
    public function index()
    {
        $gioHang = session('gio_hang', []);
        $tongTienHang = 0;

        foreach ($gioHang as $item) {
            $tongTienHang += $item['gia_ban'] * $item['so_luong'];
        }

        $maApDung = session('ma_giam_gia');
        $tienGiam = 0;

        if ($maApDung) {
            $ketQua = $this->tinhTienGiam($maApDung['ma_code'], $tongTienHang);
            if ($ketQua['hop_le']) {
                $tienGiam = $ketQua['tien_giam'];
                $maApDung['tien_giam'] = $tienGiam;
                session(['ma_giam_gia' => $maApDung]);
            } else {
                session()->forget('ma_giam_gia');
                $maApDung = null;
            }
        }

        $thanhTien = max(0, $tongTienHang - $tienGiam);

        return view('gio_hang.index', compact(
            'gioHang',
            'tongTienHang',
            'maApDung',
            'tienGiam',
            'thanhTien'
        ));
    }

    public function them(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|integer|exists:san_pham,id',
            'so_luong' => 'nullable|integer|min:1',
        ]);

        $sanPham = SanPham::where('id', $request->san_pham_id)
            ->where('trang_thai', 'hien')
            ->first();

        if (!$sanPham) {
            return $this->phanHoiLoi($request, 'Sản phẩm không tồn tại hoặc đã ngừng bán.');
        }

        if ($sanPham->so_luong_ton <= 0) {
            return $this->phanHoiLoi($request, 'Sản phẩm hiện đã hết hàng.');
        }

        $soLuongThem = (int) ($request->so_luong ?? 1);
        $gioHang = session('gio_hang', []);
        $id = $sanPham->id;

        $soLuongHienTai = $gioHang[$id]['so_luong'] ?? 0;
        $soLuongMoi = $soLuongHienTai + $soLuongThem;

        if ($soLuongMoi > $sanPham->so_luong_ton) {
            $soLuongMoi = $sanPham->so_luong_ton;
        }

        $gioHang[$id] = [
            'id' => $sanPham->id,
            'ten_san_pham' => $sanPham->ten_san_pham,
            'duong_dan' => $sanPham->duong_dan,
            'don_vi_tinh' => $sanPham->don_vi_tinh,
            'gia_ban' => (float) $sanPham->gia_ban,
            'hinh_anh' => $sanPham->hinh_anh,
            'so_luong' => $soLuongMoi,
            'so_luong_ton' => (int) $sanPham->so_luong_ton,
        ];

        session(['gio_hang' => $gioHang]);

        $tongMon = array_sum(array_column($gioHang, 'so_luong'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'thanh_cong' => true,
                'thong_bao' => 'Đã thêm "' . $sanPham->ten_san_pham . '" vào giỏ hàng.',
                'so_luong_gio_hang' => $tongMon,
            ]);
        }

        return back()->with('thong_bao', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function capNhat(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|integer',
            'so_luong' => 'required|integer|min:1',
        ]);

        $gioHang = session('gio_hang', []);
        $id = $request->san_pham_id;

        if (!isset($gioHang[$id])) {
            return back()->with('thong_bao', 'Sản phẩm không có trong giỏ hàng.');
        }

        $sanPham = SanPham::find($id);
        if (!$sanPham || $sanPham->trang_thai !== 'hien') {
            unset($gioHang[$id]);
            session(['gio_hang' => $gioHang]);
            return back()->with('thong_bao', 'Sản phẩm đã ngừng bán và được gỡ khỏi giỏ.');
        }

        $soLuongMoi = (int) $request->so_luong;
        if ($soLuongMoi > $sanPham->so_luong_ton) {
            $soLuongMoi = max(1, (int) $sanPham->so_luong_ton);
            $thongBao = 'Số lượng tối đa có thể đặt cho "' . $sanPham->ten_san_pham . '" là ' . $soLuongMoi . '.';
        } else {
            $thongBao = 'Đã cập nhật số lượng sản phẩm.';
        }

        $gioHang[$id]['so_luong'] = $soLuongMoi;
        $gioHang[$id]['so_luong_ton'] = (int) $sanPham->so_luong_ton;
        $gioHang[$id]['gia_ban'] = (float) $sanPham->gia_ban;

        session(['gio_hang' => $gioHang]);

        return back()->with('thong_bao', $thongBao);
    }

    public function xoa(int $id)
    {
        $gioHang = session('gio_hang', []);

        if (isset($gioHang[$id])) {
            unset($gioHang[$id]);
            session(['gio_hang' => $gioHang]);
        }

        if (empty($gioHang)) {
            session()->forget('ma_giam_gia');
        }

        return back()->with('thong_bao', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function xoaTatCa()
    {
        session()->forget(['gio_hang', 'ma_giam_gia']);

        return back()->with('thong_bao', 'Đã xóa toàn bộ giỏ hàng.');
    }

    public function apDungMa(Request $request)
    {
        $request->validate([
            'ma_code' => 'required|string|max:50',
        ], [
            'ma_code.required' => 'Vui lòng nhập mã giảm giá.',
        ]);

        $gioHang = session('gio_hang', []);
        if (empty($gioHang)) {
            return back()->withErrors(['ma_code' => 'Giỏ hàng đang trống.']);
        }

        $tongTienHang = 0;
        foreach ($gioHang as $item) {
            $tongTienHang += $item['gia_ban'] * $item['so_luong'];
        }

        $maNhap = strtoupper(trim($request->ma_code));
        $ketQua = $this->tinhTienGiam($maNhap, $tongTienHang);

        if (!$ketQua['hop_le']) {
            session()->forget('ma_giam_gia');
            return back()->withErrors(['ma_code' => $ketQua['ly_do']]);
        }

        session([
            'ma_giam_gia' => [
                'id' => $ketQua['ma']->id,
                'ma_code' => $ketQua['ma']->ma_code,
                'ten_chuong_trinh' => $ketQua['ma']->ten_chuong_trinh,
                'loai_giam' => $ketQua['ma']->loai_giam,
                'gia_tri_giam' => $ketQua['ma']->gia_tri_giam,
                'tien_giam' => $ketQua['tien_giam'],
            ],
        ]);

        return back()->with('thong_bao', 'Đã áp dụng mã "' . $ketQua['ma']->ma_code . '".');
    }

    public function goMa()
    {
        session()->forget('ma_giam_gia');

        return back()->with('thong_bao', 'Đã gỡ mã giảm giá.');
    }

    private function tinhTienGiam(string $maCode, float $tongTienHang): array
    {
        $ma = MaGiamGia::where('ma_code', $maCode)->first();

        if (!$ma) {
            return ['hop_le' => false, 'ly_do' => 'Mã giảm giá không tồn tại.'];
        }

        if ($ma->trang_thai !== 'kich_hoat') {
            return ['hop_le' => false, 'ly_do' => 'Mã giảm giá hiện không hoạt động.'];
        }

        $hienTai = now();
        if ($ma->ngay_bat_dau && $hienTai->lt($ma->ngay_bat_dau)) {
            return ['hop_le' => false, 'ly_do' => 'Mã giảm giá chưa đến thời gian áp dụng.'];
        }

        if ($ma->ngay_ket_thuc && $hienTai->gt($ma->ngay_ket_thuc)) {
            return ['hop_le' => false, 'ly_do' => 'Mã giảm giá đã hết hạn.'];
        }

        if (!is_null($ma->so_luong_gioi_han) && $ma->da_su_dung >= $ma->so_luong_gioi_han) {
            return ['hop_le' => false, 'ly_do' => 'Mã giảm giá đã hết lượt sử dụng.'];
        }

        if ($tongTienHang < (float) $ma->don_hang_toi_thieu) {
            $toiThieu = number_format((float) $ma->don_hang_toi_thieu, 0, ',', '.');
            return ['hop_le' => false, 'ly_do' => "Đơn hàng tối thiểu {$toiThieu}đ mới được áp dụng mã này."];
        }

        if ($ma->loai_giam === 'phan_tram') {
            $tienGiam = round($tongTienHang * ((float) $ma->gia_tri_giam / 100));
            if (!is_null($ma->giam_toi_da) && (float) $ma->giam_toi_da > 0) {
                $tienGiam = min($tienGiam, (float) $ma->giam_toi_da);
            }
        } else {
            $tienGiam = (float) $ma->gia_tri_giam;
        }

        $tienGiam = min($tienGiam, $tongTienHang);

        return [
            'hop_le' => true,
            'ma' => $ma,
            'tien_giam' => $tienGiam,
        ];
    }

    private function phanHoiLoi(Request $request, string $loi)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => $loi,
            ], 422);
        }

        return back()->with('thong_bao', $loi);
    }
}
