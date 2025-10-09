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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // Main fields
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('company');
            $table->string('location');
            $table->string('employment_type'); // full-time, part-time, remote, etc.
            
            // Salary ranges
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();

            // Job details
            $table->json('skills')->nullable();
            $table->longText('description');

            // Flags
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Relationships
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
