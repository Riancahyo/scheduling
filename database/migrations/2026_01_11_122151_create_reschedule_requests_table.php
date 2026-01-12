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
        Schema::create('reschedule_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('new_schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['original_schedule_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reschedule_requests');
    }
};
