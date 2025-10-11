<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->cascadeOnDelete(); // kurs silinəndə linklər də silinsin
            $table->string('twitterurl')->nullable();
            $table->string('facebookurl')->nullable();
            $table->string('linkedinurl')->nullable();
            $table->string('emailurl')->nullable();
            $table->string('whatsappurl')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('social_links');
    }
};
