<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table): void {
            $table->char('id', 36)->primary();

            $table->char('patient_id', 36);

            $table->char('therapist_id', 36);

            $table->dateTime('session_date');

            $table->string('status', 20);

            $table->index('patient_id');

            $table->index('therapist_id');

            $table->index([
                'therapist_id',
                'session_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
