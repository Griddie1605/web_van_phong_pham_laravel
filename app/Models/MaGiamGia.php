<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaGiamGia extends Model
{
    protected $table = 'ma_giam_gia';

    protected $fillable = [
        'ma_code',
        'ten_chuong_trinh',
        'loai_giam',
        'gia_tri_giam',
        'giam_toi_da',
        'don_hang_toi_thieu',
        'so_luong_toi_da',
        'da_su_dung',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
    ];

    protected $casts = [
        'gia_tri_giam' => 'decimal:2',
        'giam_toi_da' => 'decimal:2',
        'don_hang_toi_thieu' => 'decimal:2',
        'ngay_bat_dau' => 'datetime',
        'ngay_ket_thuc' => 'datetime',
    ];

    public function donHang(): HasMany
    {
        return $this->hasMany(DonHang::class, 'ma_giam_gia_id');
    }
}