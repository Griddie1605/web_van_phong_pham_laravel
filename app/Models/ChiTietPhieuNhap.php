<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietPhieuNhap extends Model
{
    protected $table = 'chi_tiet_phieu_nhap';

    protected $fillable = [
        'phieu_nhap_id',
        'san_pham_id',
        'so_luong_nhap',
        'gia_nhap',
        'thanh_tien',
    ];

    protected $casts = [
        'gia_nhap' => 'decimal:2',
        'thanh_tien' => 'decimal:2',
    ];

    public function phieuNhap(): BelongsTo
    {
        return $this->belongsTo(PhieuNhap::class, 'phieu_nhap_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}