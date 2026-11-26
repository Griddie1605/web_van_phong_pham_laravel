<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NguoiDung extends Authenticatable
{
    protected $table = 'nguoi_dung';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'dia_chi',
        'vai_tro',
        'trang_thai',
    ];

    protected $hidden = [
        'mat_khau',
    ];

    // Laravel Auth mặc định kiểm tra cột password, ghi đè để dùng cột mat_khau
    public function getAuthPassword(): string
    {
        return $this->mat_khau;
    }

    public function donHang(): HasMany
    {
        return $this->hasMany(DonHang::class, 'nguoi_dung_id');
    }

    public function phieuNhap(): HasMany
    {
        return $this->hasMany(PhieuNhap::class, 'nguoi_lap_id');
    }

    public function nhatKyKho(): HasMany
    {
        return $this->hasMany(NhatKyKho::class, 'nguoi_thuc_hien_id');
    }
}