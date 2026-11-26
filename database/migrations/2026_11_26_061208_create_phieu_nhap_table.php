<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phieu_nhap', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phieu_nhap', 40)->unique();
            $table->foreignId('nguoi_lap_id')->nullable()->constrained('nguoi_dung')->nullOnDelete();
            $table->string('nha_cung_cap', 150)->nullable();
            $table->dateTime('ngay_nhap');
            $table->decimal('tong_tien_nhap', 12, 2)->default(0);
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phieu_nhap');
    }
};