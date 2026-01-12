<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', [
                'available',
                'booked',
                'pending_reschedule',
                'completed',
                'cancelled'
            ])->default('available');
            $table->string('subject')->nullable(); 
            $table->text('notes')->nullable();
            $table->timestamp('booked_at')->nullable();
            $table->timestamps();
            $table->index(['mentor_id', 'start_time']);
            $table->index(['student_id', 'status']);
            $table->index(['status', 'start_time']);
            $table->unique(['mentor_id', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
