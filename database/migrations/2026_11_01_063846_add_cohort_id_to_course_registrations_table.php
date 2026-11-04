<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->foreignId('cohort_id')
                ->nullable()
                ->constrained('cohorts')
                ->restrictOnDelete();

            $table->unique(
                ['cohort_id', 'email'],
                'registrations_cohort_email_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->dropUnique('registrations_cohort_email_unique');
            $table->dropConstrainedForeignId('cohort_id');
        });
    }
};