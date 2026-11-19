<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sertifikat, prestasi, dan dokumentasi kegiatan.
     * Kategori "prestasi" dipakai untuk menggabungkan prestasi tanpa tabel duplikat.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('organizer')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->default('pelatihan');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
