<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

            // Participant/student personal info
            $table->string('first_name');
            $table->string('surname');
            $table->string('patronymic');
            $table->string('certificate_name');

            $table->date('birth_date');
            $table->string('gender'); // male/female/other

            $table->string('id_card_number');

            $table->string('business_email');
            $table->string('telephone')->nullable();
            $table->string('mobile_phone');
            $table->string('postal_code')->nullable();

            $table->string('company')->nullable();
            $table->string('position')->nullable();

            // Product or service
            $table->string('requested_product_service');

            // Additional requirements + notes
            $table->text('requirements')->nullable();
            $table->text('notes')->nullable();

            $table->boolean('remember_me')->default(false);

            // Optional: status/admin
            $table->string('status')->default('new');

            $table->timestamps();

            $table->index(['course_id', 'status']);
            $table->index(['business_email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
