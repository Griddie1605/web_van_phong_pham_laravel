<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhap';

    protected $fillable = [
        'ma_phieu_nhap',
        'nguoi_lap_id',
        'nha_cung_cap',
        'ngay_nhap',
        'tong_tien_nhap',
        'ghi_chu',
    ];


    protected $casts = [
        'ngay_nhap' => 'datetime',
        'tong_tien_nhap' => 'decimal:2',
    ];

    public function nguoiLap(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_lap_id');
    }

    public function chiTietPhieuNhap(): HasMany
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'phieu_nhap_id');
    }
}