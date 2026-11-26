<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_phieu_nhap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phieu_nhap_id')->constrained('phieu_nhap')->cascadeOnDelete();
            $table->foreignId('san_pham_id')->constrained('san_pham')->restrictOnDelete();
            $table->unsignedInteger('so_luong_nhap');
            $table->decimal('gia_nhap', 12, 2);
            $table->decimal('thanh_tien', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phieu_nhap');
    }
};