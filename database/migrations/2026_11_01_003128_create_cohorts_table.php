<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohorts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('cohort_name');

            $table->date('registration_open_date')->nullable();
            $table->date('registration_close_date')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unsignedSmallInteger('capacity')->default(30);

            $table->string('status')->default('upcoming');

            $table->timestamps();

            $table->unique(['course_id', 'cohort_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohorts');
    }
};