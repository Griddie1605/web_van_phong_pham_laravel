<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 100);
            $table->string('email', 150)->unique();
            $table->string('mat_khau');
            $table->string('so_dien_thoai', 20)->nullable();
            $table->text('dia_chi')->nullable();
            $table->enum('vai_tro', ['khach_hang', 'admin'])->default('khach_hang');
            $table->enum('trang_thai', ['hoat_dong', 'bi_khoa'])->default('hoat_dong');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};