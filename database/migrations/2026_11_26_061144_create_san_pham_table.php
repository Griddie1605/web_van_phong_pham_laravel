<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danh_muc_id')->constrained('danh_muc')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('ten_san_pham', 180);
            $table->string('duong_dan', 200)->unique();
            $table->string('don_vi_tinh', 30)->default('cay');
            $table->decimal('gia_ban', 12, 2);
            $table->unsignedInteger('so_luong_ton')->default(0);
            $table->string('hinh_anh')->nullable();
            $table->text('mo_ta')->nullable();
            $table->enum('trang_thai', ['hien', 'an'])->default('hien');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};