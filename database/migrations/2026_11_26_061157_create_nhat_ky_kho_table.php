<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhat_ky_kho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_pham_id')->constrained('san_pham')->cascadeOnDelete();
            $table->foreignId('nguoi_thuc_hien_id')->nullable()->constrained('nguoi_dung')->nullOnDelete();
            $table->enum('loai_bien_dong', ['nhap_kho', 'xuat_ban', 'hoan_tra', 'dieu_chinh']);
            $table->integer('so_luong_thay_doi');
            $table->unsignedInteger('ton_sau_bien_dong');
            $table->string('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhat_ky_kho');
    }
};