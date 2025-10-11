<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();
            $t->string('name')->nullable();
            $t->timestamp('verified_at')->nullable();   // istəsən double opt-in üçün
            $t->string('token', 64)->nullable();        // unsubscribe / verify
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
