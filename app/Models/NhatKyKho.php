<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhatKyKho extends Model
{
    protected $table = 'nhat_ky_kho';

    protected $fillable = [
        'san_pham_id',
        'nguoi_thuc_hien_id',
        'loai_bien_dong',
        'so_luong_thay_doi',
        'ton_sau_bien_dong',
        'ghi_chu',
    ];
    
    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function nguoiThucHien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_thuc_hien_id');
    }
}