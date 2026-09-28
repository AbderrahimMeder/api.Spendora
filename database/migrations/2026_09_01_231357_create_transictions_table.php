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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('title');
            $table->enum('type', ['INCOME', 'EXPENSE']);
            $table->foreignUuid('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('currency');
            $table->boolean('is_hidden')->default(false);
            $table->foreignUuid('payment_method_id')
            ->references('id')
            ->on('payment_methods')
            ->cascadeOnDelete();
            $table->enum('status',['PENDING','COMPLETED','FAILED','CANCELLED','REFUNDED'])->default('PENDING');
            $table->timestamps();
            //index
            $table->index('account_id');
            $table->index('category_id');
            $table->index('date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transictions');
    }
};
