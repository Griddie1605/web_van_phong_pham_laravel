<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_muc', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc', 120);
            $table->string('duong_dan', 140)->unique();
            $table->text('mo_ta')->nullable();
            $table->enum('trang_thai', ['hien', 'an'])->default('hien');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_muc');
    }
};
