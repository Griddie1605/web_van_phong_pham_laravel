<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KhoHangController;
use App\Http\Controllers\Admin\SanPhamController;
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

// Quản trị (Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Danh mục
    Route::get('/danh-muc', [DanhMucController::class, 'index'])->name('danh_muc.index');
    Route::post('/danh-muc', [DanhMucController::class, 'store'])->name('danh_muc.store');
    Route::put('/danh-muc/{id}', [DanhMucController::class, 'update'])->name('danh_muc.update');
    Route::post('/danh-muc/{id}/doi-trang-thai', [DanhMucController::class, 'doiTrangThai'])->name('danh_muc.doi_trang_thai');

    // Sản phẩm
    Route::get('/san-pham', [SanPhamController::class, 'index'])->name('san_pham.index');
    Route::get('/san-pham/tao', [SanPhamController::class, 'create'])->name('san_pham.create');
    Route::post('/san-pham', [SanPhamController::class, 'store'])->name('san_pham.store');
    Route::get('/san-pham/{id}/sua', [SanPhamController::class, 'edit'])->name('san_pham.edit');
    Route::put('/san-pham/{id}', [SanPhamController::class, 'update'])->name('san_pham.update');
    Route::post('/san-pham/{id}/doi-trang-thai', [SanPhamController::class, 'doiTrangThai'])->name('san_pham.doi_trang_thai');

    // Kho hàng
    Route::get('/nhap-kho', [KhoHangController::class, 'formNhapKho'])->name('kho.nhap_kho');
    Route::post('/nhap-kho', [KhoHangController::class, 'xuLyNhapKho'])->name('kho.xu_ly_nhap');
    Route::get('/nhat-ky-kho', [KhoHangController::class, 'nhatKy'])->name('kho.nhat_ky');
    Route::post('/dieu-chinh-ton', [KhoHangController::class, 'dieuChinhTon'])->name('kho.dieu_chinh_ton');
});
