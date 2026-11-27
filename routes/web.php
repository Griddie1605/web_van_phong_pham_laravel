<?php

use App\Http\Controllers\DatHangController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\TrangChuController;
use Illuminate\Support\Facades\Route;

// Trang chủ, giới thiệu & chi tiết sản phẩm
Route::get('/', [TrangChuController::class, 'index'])->name('trang_chu');
Route::get('/gioi-thieu', [TrangChuController::class, 'gioiThieu'])->name('gioi_thieu');
Route::get('/san-pham/{duongDan}', [TrangChuController::class, 'chiTietSanPham'])->name('san_pham.chi_tiet');

// Tài khoản
Route::get('/dang-nhap', [TaiKhoanController::class, 'formDangNhap'])->name('dang_nhap');
Route::post('/dang-nhap', [TaiKhoanController::class, 'xuLyDangNhap'])->name('dang_nhap.xu_ly');
Route::get('/dang-ky', [TaiKhoanController::class, 'formDangKy'])->name('dang_ky');
Route::post('/dang-ky', [TaiKhoanController::class, 'xuLyDangKy'])->name('dang_ky.xu_ly');

// Giỏ hàng & mã giảm giá
Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gio_hang.index');
Route::post('/gio-hang/them', [GioHangController::class, 'them'])->name('gio_hang.them');
Route::post('/gio-hang/cap-nhat', [GioHangController::class, 'capNhat'])->name('gio_hang.cap_nhat');
Route::delete('/gio-hang/xoa/{id}', [GioHangController::class, 'xoa'])->name('gio_hang.xoa');
Route::delete('/gio-hang/xoa-tat-ca', [GioHangController::class, 'xoaTatCa'])->name('gio_hang.xoa_tat_ca');
Route::post('/gio-hang/ap-dung-ma', [GioHangController::class, 'apDungMa'])->name('gio_hang.ap_dung_ma');
Route::delete('/gio-hang/go-ma', [GioHangController::class, 'goMa'])->name('gio_hang.go_ma');

// Yêu cầu đăng nhập: hồ sơ, đăng xuất, đặt hàng & lịch sử đơn hàng
Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [TaiKhoanController::class, 'dangXuat'])->name('dang_xuat');
    Route::get('/tai-khoan', [TaiKhoanController::class, 'hoSo'])->name('tai_khoan.ho_so');
    Route::put('/tai-khoan', [TaiKhoanController::class, 'capNhatHoSo'])->name('tai_khoan.cap_nhat');

    Route::get('/dat-hang', [DatHangController::class, 'formDatHang'])->name('dat_hang.form');
    Route::post('/dat-hang', [DatHangController::class, 'xuLyDatHang'])->name('dat_hang.xu_ly');
    Route::get('/don-hang-cua-toi', [DatHangController::class, 'lichSu'])->name('don_hang.lich_su');
    Route::get('/don-hang-cua-toi/{id}', [DatHangController::class, 'chiTiet'])->name('don_hang.chi_tiet');
    Route::post('/don-hang-cua-toi/{id}/huy', [DatHangController::class, 'huyDon'])->name('don_hang.huy');
});
