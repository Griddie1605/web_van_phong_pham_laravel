<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhMuc extends Model
{
    protected $table = 'danh_muc';

    protected $fillable = [
        'ten_danh_muc',
        'duong_dan',
        'mo_ta',
    ];

    public function sanPham(): HasMany
    {
        return $this->hasMany(SanPham::class, 'danh_muc_id');
    }
}