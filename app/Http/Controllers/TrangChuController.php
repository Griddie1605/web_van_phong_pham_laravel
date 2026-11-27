<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Http\Request;

class TrangChuController extends Controller
{
    public function index(Request $request)
    {
        $dsDanhMuc = DanhMuc::where('trang_thai', 'hien')
            ->orderBy('ten_danh_muc')
            ->get();

        $now = now();

        $dsMaGiamGia = MaGiamGia::where('trang_thai', 'kich_hoat')
            ->where(function ($q) use ($now) {
                $q->whereNull('ngay_bat_dau')->orWhere('ngay_bat_dau', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('ngay_ket_thuc')->orWhere('ngay_ket_thuc', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('so_luong_toi_da')->orWhereColumn('da_su_dung', '<', 'so_luong_toi_da');
            })
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $query = SanPham::with('danhMuc')
            ->where('trang_thai', 'hien')
            ->whereHas('danhMuc', function ($q) {
                $q->where('trang_thai', 'hien');
            });

        if ($request->filled('tu_khoa')) {
            $tuKhoa = trim($request->tu_khoa);
            $query->where('ten_san_pham', 'like', "%{$tuKhoa}%");
        }

        if ($request->filled('danh_muc')) {
            $slugDanhMuc = $request->danh_muc;
            $query->whereHas('danhMuc', function ($q) use ($slugDanhMuc) {
                $q->where('duong_dan', $slugDanhMuc)
                    ->where('trang_thai', 'hien');
            });
        }

        if ($request->filled('gia_tu')) {
            $query->where('gia_ban', '>=', (float) $request->gia_tu);
        }
        if ($request->filled('gia_den')) {
            $query->where('gia_ban', '<=', (float) $request->gia_den);
        }

        switch ($request->sap_xep) {
            case 'gia_tang':
                $query->orderBy('gia_ban', 'asc');
                break;
            case 'gia_giam':
                $query->orderBy('gia_ban', 'desc');
                break;
            default:
                $query->latest('id');
                break;
        }

        $dsSanPham = $query->paginate(8)->withQueryString();

        return view('trang_chu', compact('dsDanhMuc', 'dsMaGiamGia', 'dsSanPham'));
    }

    public function gioiThieu()
    {
        return view('gioi_thieu');
    }

    public function chiTietSanPham(string $duongDan)
    {
        $sanPham = SanPham::with('danhMuc')
            ->where('duong_dan', $duongDan)
            ->where('trang_thai', 'hien')
            ->whereHas('danhMuc', function ($q) {
                $q->where('trang_thai', 'hien');
            })
            ->firstOrFail();

        $sanPhamLienQuan = SanPham::where('danh_muc_id', $sanPham->danh_muc_id)
            ->where('id', '!=', $sanPham->id)
            ->where('trang_thai', 'hien')
            ->whereHas('danhMuc', function ($q) {
                $q->where('trang_thai', 'hien');
            })
            ->take(4)
            ->get();

        return view('chi_tiet_san_pham', compact('sanPham', 'sanPhamLienQuan'));
    }
}
