<?php

namespace Database\Seeders;

use App\Models\DanhMuc;
use App\Models\MaGiamGia;
use App\Models\NguoiDung;
use App\Models\SanPham;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        NguoiDung::updateOrCreate(
            ['email' => 'admin@vanphongpham.local'],
            [
                'ho_ten' => 'Quản Trị Viên',
                'mat_khau' => Hash::make('123456'),
                'so_dien_thoai' => '0901234567',
                'dia_chi' => 'Long Xuyên, An Giang',
                'vai_tro' => 'admin',
                'trang_thai' => 'hoat_dong',
            ]
        );

        NguoiDung::updateOrCreate(
            ['email' => 'khachhang@vanphongpham.local'],
            [
                'ho_ten' => 'Nguyễn Văn A',
                'mat_khau' => Hash::make('123456'),
                'so_dien_thoai' => '0912345678',
                'dia_chi' => 'Long Xuyên, An Giang',
                'vai_tro' => 'khach_hang',
                'trang_thai' => 'hoat_dong',
            ]
        );

        $danhMucData = [
            ['ten_danh_muc' => 'Bút viết', 'duong_dan' => 'but-viet', 'mo_ta' => 'Bút bi, bút gel, bút highlight, bút chì'],
            ['ten_danh_muc' => 'Tập & Sổ tay', 'duong_dan' => 'tap-so-tay', 'mo_ta' => 'Tập học sinh, sổ lò xo, sổ ghi chép'],
            ['ten_danh_muc' => 'Dụng cụ học tập', 'duong_dan' => 'dung-cu-hoc-tap', 'mo_ta' => 'Thước kẻ, gôm tẩy, bấm kim, keo dán'],
            ['ten_danh_muc' => 'Giấy in & Bìa hồ sơ', 'duong_dan' => 'giay-in-bia-ho-so', 'mo_ta' => 'Giấy A4, bìa lá, file tài liệu văn phòng'],
        ];

        $danhMucMap = [];
        foreach ($danhMucData as $item) {
            $dm = DanhMuc::updateOrCreate(['duong_dan' => $item['duong_dan']], $item);
            $danhMucMap[$item['duong_dan']] = $dm->id;
        }

        $sanPhamData = [
            [
                'danh_muc_id' => $danhMucMap['but-viet'],
                'ten_san_pham' => 'Bút bi mực xanh nét 0.5mm',
                'duong_dan' => 'but-bi-muc-xanh-net-0-5mm',
                'don_vi_tinh' => 'cay',
                'gia_ban' => 5000,
                'so_luong_ton' => 100,
                'mo_ta' => 'Bút bi viết trơn đều mực, phù hợp ghi chép hằng ngày.',
                'trang_thai' => 'hien',
            ],
            [
                'danh_muc_id' => $danhMucMap['but-viet'],
                'ten_san_pham' => 'Hộp 12 bút highlight pastel',
                'duong_dan' => 'hop-12-but-highlight-pastel',
                'don_vi_tinh' => 'hop',
                'gia_ban' => 85000,
                'so_luong_ton' => 35,
                'mo_ta' => 'Bộ bút dạ quang tông màu pastel dịu mắt, không lem mực.',
                'trang_thai' => 'hien',
            ],
            [
                'danh_muc_id' => $danhMucMap['tap-so-tay'],
                'ten_san_pham' => 'Tập học sinh 200 trang 4 ô ly',
                'duong_dan' => 'tap-hoc-sinh-200-trang-4-o-ly',
                'don_vi_tinh' => 'cuon',
                'gia_ban' => 15000,
                'so_luong_ton' => 80,
                'mo_ta' => 'Giấy trắng chống lóa, in ô ly rõ nét.',
                'trang_thai' => 'hien',
            ],
            [
                'danh_muc_id' => $danhMucMap['dung-cu-hoc-tap'],
                'ten_san_pham' => 'Gôm tẩy trắng không bụi',
                'duong_dan' => 'gom-tay-trang-khong-bui',
                'don_vi_tinh' => 'vien',
                'gia_ban' => 7000,
                'so_luong_ton' => 120,
                'mo_ta' => 'Tẩy sạch chì mà không làm rách bề mặt giấy.',
                'trang_thai' => 'hien',
            ],
            [
                'danh_muc_id' => $danhMucMap['giay-in-bia-ho-so'],
                'ten_san_pham' => 'Xấp bìa lá A4 trong suốt (10 cái)',
                'duong_dan' => 'xap-bia-la-a4-trong-suot-10-cai',
                'don_vi_tinh' => 'xap',
                'gia_ban' => 22000,
                'so_luong_ton' => 50,
                'mo_ta' => 'Nhựa dẻo bền đẹp, lưu trữ tài liệu gọn gàng.',
                'trang_thai' => 'hien',
            ],
        ];

        foreach ($sanPhamData as $sp) {
            SanPham::updateOrCreate(['duong_dan' => $sp['duong_dan']], $sp);
        }

        MaGiamGia::updateOrCreate(
            ['ma_code' => 'GIAM10'],
            [
                'ten_chuong_trinh' => 'Giảm 10% đơn từ 100.000đ',
                'loai_giam' => 'phan_tram',
                'gia_tri_giam' => 10,
                'giam_toi_da' => 30000,
                'don_hang_toi_thieu' => 100000,
                'so_luong_toi_da' => 100,
                'da_su_dung' => 0,
                'ngay_bat_dau' => now()->subDays(1),
                'ngay_ket_thuc' => now()->addMonths(2),
                'trang_thai' => 'kich_hoat',
            ]
        );
    }
}