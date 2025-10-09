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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade'); // link to job
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // employer who paid
            $table->decimal('amount', 10, 2)->default(0); // e.g., premium price
            $table->string('reference_number')->nullable(); // manual payment reference
            $table->string('screenshot_path')->nullable(); // proof upload
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable(); // admin notes if rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};