<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SanPham extends Model
{
    protected $table = 'san_pham';

    protected $fillable = [
        'danh_muc_id',
        'ten_san_pham',
        'duong_dan',
        'don_vi_tinh',
        'gia_ban',
        'so_luong_ton',
        'hinh_anh',
        'mo_ta',
        'trang_thai',
    ];

    protected $casts = [
        'gia_ban' => 'decimal:2',
        'so_luong_ton' => 'integer',
    ];

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    public function chiTietDonHang(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'san_pham_id');
    }

    public function chiTietPhieuNhap(): HasMany
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'san_pham_id');
    }

    public function nhatKyKho(): HasMany
    {
        return $this->hasMany(NhatKyKho::class, 'san_pham_id');
    }
}