<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // kurs adı
            $table->unsignedBigInteger('views')->default(0); // baxış sayı (əvvəlki "view")
            $table->string('courseUrl')->nullable();    // kurs linki
            $table->text('description')->nullable();    // təsvir
            $table->string('imageUrl')->nullable();     // şəkil URL-i
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('courses');
    }
};
