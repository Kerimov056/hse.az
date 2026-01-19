<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('duration')->nullable()->after('info');     // məsələn: "8 həftə", "20 saat"
            $table->string('instructor')->nullable()->after('duration'); // təlimçi adı
            $table->decimal('price', 10, 2)->nullable()->after('instructor'); // qiymət
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['duration', 'instructor', 'price']);
        });
    }
};
