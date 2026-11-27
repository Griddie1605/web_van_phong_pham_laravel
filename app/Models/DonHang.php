<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonHang extends Model
{
    protected $table = 'don_hang';

    protected $fillable = [
        'ma_don_hang',
        'nguoi_dung_id',
        'ma_giam_gia_id',
        'ten_nguoi_nhan',
        'sdt_nguoi_nhan',
        'dia_chi_giao',
        'ghi_chu',
        'phuong_thuc_thanh_toan',
        'tam_tinh',
        'so_tien_giam',
        'tong_thanh_toan',
        'trang_thai',
    ];

    protected $casts = [
        'tam_tinh' => 'decimal:2',
        'so_tien_giam' => 'decimal:2',
        'tong_thanh_toan' => 'decimal:2',
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function maGiamGia(): BelongsTo
    {
        return $this->belongsTo(MaGiamGia::class, 'ma_giam_gia_id');
    }

    public function chiTietDonHang(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}
