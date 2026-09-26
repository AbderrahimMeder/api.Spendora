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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->string('name');
            $table->string('slug');
            $table->unique(['slug','account_id']);
            $table->text('description')->nullable();
            $table->string('max_budget')->nullable();
            $table->enum('budget_period', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->string('category_image')->nullable();
            $table->string('category_color')->nullable();
            $table->enum('type', ['INCOME', 'EXPENSE']);
            $table->timestamps();

            // Relationship
             $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
             $table->index('account_id');
             $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
