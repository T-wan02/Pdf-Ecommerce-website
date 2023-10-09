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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('cartToken');
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->text('address');
            $table->string('country');
            $table->string('postal_code');
            $table->string('city');
            $table->string('state');
            $table->string('phone_number');
            $table->time('order_confirmed_time');
            $table->date('order_confirmed_date');
            $table->enum('order_confirm', ['confirmed', 'not_confirmed']);
            $table->string('sub_total');
            $table->string('tax');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
