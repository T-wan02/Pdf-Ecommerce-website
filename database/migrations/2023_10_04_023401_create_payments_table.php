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
            $table->unsignedBigInteger('order_id');
            $table->string('name')->nullable();

            // card payment information
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('currency');

            $table->string('total');
            $table->string('giving_date');
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
