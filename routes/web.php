<?php

use App\Http\Controllers\TrangChuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TrangChuController::class, 'index'])->name('trang_chu');
Route::get('/gioi-thieu', [TrangChuController::class, 'gioiThieu'])->name('gioi_thieu');
Route::get('/san-pham/{duongDan}', [TrangChuController::class, 'chiTietSanPham'])->name('san_pham.chi_tiet');
