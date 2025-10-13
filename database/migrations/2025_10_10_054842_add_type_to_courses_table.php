<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // string istifadə edirik; enum-dan daha elastikdir
            $table->string('type', 32)->default('course')->after('id')->index();
        });

        // köhnə yazıları kurs kimi işarətlə
        DB::table('courses')->whereNull('type')->update(['type' => 'course']);
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
