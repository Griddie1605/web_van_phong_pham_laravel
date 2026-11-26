<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ma_giam_gia', function (Blueprint $table) {
            $table->id();
            $table->string('ma_code', 50)->unique();
            $table->string('ten_chuong_trinh', 150);
            $table->enum('loai_giam', ['phan_tram', 'so_tien']);
            $table->decimal('gia_tri_giam', 12, 2);
            $table->decimal('giam_toi_da', 12, 2)->nullable();
            $table->decimal('don_hang_toi_thieu', 12, 2)->default(0);
            $table->unsignedInteger('so_luong_toi_da')->nullable();
            $table->unsignedInteger('da_su_dung')->default(0);
            $table->dateTime('ngay_bat_dau')->nullable();
            $table->dateTime('ngay_ket_thuc')->nullable();
            $table->enum('trang_thai', ['kich_hoat', 'tam_dung'])->default('kich_hoat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gia');
    }
};