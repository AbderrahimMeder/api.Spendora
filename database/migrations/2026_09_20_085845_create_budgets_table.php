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
        Schema::create('budgets', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('account_id')
                ->constrained('accounts', 'id')
                ->cascadeOnDelete();

            $table->foreignUuid('category_id')
                ->constrained('categories', 'id')
                ->cascadeOnDelete();

            $table->decimal('amount', 15, 2);

            $table->enum('period', [
                'MONTHLY',
                'YEARLY',
            ]);

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();

            $table->unique([
                'account_id',
                'category_id',
                'start_date',
                'end_date'
            ]);
            
            $table->index([
                'account_id',
                'category_id',
                'start_date',
                'end_date',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};

