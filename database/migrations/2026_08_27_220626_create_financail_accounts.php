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
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['BANK','CASH','CARD','WALLET'])->default('BANK');
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('currency', 3)->default('MAD');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->index('account_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financail_accounts');
    }
};
