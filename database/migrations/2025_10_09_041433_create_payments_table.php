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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // employer who paid
            $table->foreignId('job_id')->constrained()->onDelete('cascade');  // job being upgraded
            $table->decimal('amount', 8, 2); // fee (example: 10.00)
            $table->string('transaction_id')->nullable(); // user enters reference ID
            $table->string('screenshot')->nullable();     // proof image path
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // admin decision
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