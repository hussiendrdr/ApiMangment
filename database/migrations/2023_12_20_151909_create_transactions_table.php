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
            $table->id();
            $table->timestamps();
            $table->foreignId('quantity');
            $table->foreignId('buyer_id');
            $table->foreignId('products_id');
             $table->foreign('buyer_id')->references('id')->on('users')->cascadeOnDelete();

            $table->foreign('products_id')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();//deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
