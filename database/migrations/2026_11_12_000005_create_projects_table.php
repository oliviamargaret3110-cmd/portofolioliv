<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Data proyek/karya yang ditampilkan di galeri dan halaman detail.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('short_description');
            $table->longText('description')->nullable();
            $table->text('problem')->nullable();
            $table->text('goal')->nullable();
            $table->string('technologies')->nullable();
            $table->string('role')->nullable();
            $table->text('features')->nullable();
            $table->longText('documentation')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
