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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account_id')
            ->references('id')
            ->on('accounts')
            ->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['CASH', 'BANK', 'CARD', 'MOBILE', 'ONLINE', 'OTHER']);
            $table->boolean('is_active_method')->default(false);
            $table->timestamps();
            $table->index('account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
