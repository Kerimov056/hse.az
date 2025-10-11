<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->text('description')->nullable()->after('position');
            $table->string('phone', 50)->nullable()->after('description');
            $table->string('email')->nullable()->after('phone');

            // “My Expertise & Skills” blokuna aid
            $table->string('expertise_title')->nullable()->after('email');   // misal: "My Expertise & Skills"
            $table->text('expertise_intro')->nullable()->after('expertise_title'); // qısa giriş mətni
            $table->json('skills')->nullable()->after('expertise_intro');    // [{name:"Management", percent:76}, ...]
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn([
                'description','phone','email',
                'expertise_title','expertise_intro','skills'
            ]);
        });
    }
};
