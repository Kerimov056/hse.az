<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('text');    // Button mətni
            $table->string('url');     // Button URL
            $table->integer('order')->default(0); // Görünmə sırası
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_buttons');
    }
};
