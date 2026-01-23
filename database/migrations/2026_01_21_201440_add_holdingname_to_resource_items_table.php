<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            if (!Schema::hasColumn('resources', 'holdingName')) {
                $table->string('holdingName')->nullable()->after('name')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            if (Schema::hasColumn('resources', 'holdingName')) {
                $table->dropIndex(['holdingName']);
                $table->dropColumn('holdingName');
            }
        });
    }
};
