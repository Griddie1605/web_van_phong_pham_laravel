<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_hang', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang', 40)->unique();
            $table->foreignId('nguoi_dung_id')->nullable()->constrained('nguoi_dung')->nullOnDelete();
            $table->string('ten_nguoi_nhan', 100);
            $table->string('sdt_nguoi_nhan', 20);
            $table->text('dia_chi_giao');
            $table->text('ghi_chu')->nullable();
            $table->enum('phuong_thuc_thanh_toan', ['cod', 'chuyen_khoan'])->default('cod');
            $table->decimal('tam_tinh', 12, 2);
            $table->foreignId('ma_giam_gia_id')->nullable()->constrained('ma_giam_gia')->nullOnDelete();
            $table->decimal('so_tien_giam', 12, 2)->default(0);
            $table->decimal('tong_thanh_toan', 12, 2);
            $table->enum('trang_thai', ['cho_xac_nhan', 'dang_giao', 'hoan_tat', 'da_huy'])->default('cho_xac_nhan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};