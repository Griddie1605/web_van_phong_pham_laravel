<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\SanPham;

class DashboardController extends Controller
{
    public function index()
    {
        $tongDoanhThu = DonHang::where('trang_thai', 'hoan_tat')->sum('tong_thanh_toan');
        $donChoXacNhan = DonHang::where('trang_thai', 'cho_xac_nhan')->count();
        $sanPhamDangBan = SanPham::where('trang_thai', 'hien')->count();
        $spSapHetHang = SanPham::with('danhMuc')
            ->where('trang_thai', 'hien')
            ->where('so_luong_ton', '<=', 10)
            ->orderBy('so_luong_ton', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'tongDoanhThu',
            'donChoXacNhan',
            'sanPhamDangBan',
            'spSapHetHang'
        ));
    }
}
