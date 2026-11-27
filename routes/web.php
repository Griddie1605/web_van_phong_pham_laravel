<?php

use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\TrangChuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TrangChuController::class, 'index'])->name('trang_chu');
Route::get('/gioi-thieu', [TrangChuController::class, 'gioiThieu'])->name('gioi_thieu');
Route::get('/san-pham/{duongDan}', [TrangChuController::class, 'chiTietSanPham'])->name('san_pham.chi_tiet');

// Tài khoản
Route::get('/dang-nhap', [TaiKhoanController::class, 'formDangNhap'])->name('dang_nhap');
Route::post('/dang-nhap', [TaiKhoanController::class, 'xuLyDangNhap'])->name('dang_nhap.xu_ly');
Route::get('/dang-ky', [TaiKhoanController::class, 'formDangKy'])->name('dang_ky');
Route::post('/dang-ky', [TaiKhoanController::class, 'xuLyDangKy'])->name('dang_ky.xu_ly');

Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [TaiKhoanController::class, 'dangXuat'])->name('dang_xuat');
    Route::get('/tai-khoan', [TaiKhoanController::class, 'hoSo'])->name('tai_khoan.ho_so');
    Route::put('/tai-khoan', [TaiKhoanController::class, 'capNhatHoSo'])->name('tai_khoan.cap_nhat');
});
