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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to jobs table
            $table->foreignId('job_id')
                  ->constrained('jobs')
                  ->onDelete('cascade');
            
            // Foreign key to users table (job seeker)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->string('resume')->nullable();        // path to uploaded resume
            $table->text('cover_letter')->nullable();   // optional cover letter
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                  ->default('pending');
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
