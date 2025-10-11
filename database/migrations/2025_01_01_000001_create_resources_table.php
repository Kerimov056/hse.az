<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_type_id')->constrained('resource_types')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('resourceUrl', 2048);   // GCS public URL
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('mime', 191)->nullable(); // opsional: preview üçün faydalı
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['name', 'year']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('resources');
    }
};
