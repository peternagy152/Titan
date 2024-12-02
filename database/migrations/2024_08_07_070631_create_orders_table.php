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
            $table->foreignId('user_id');
            $table->unsignedInteger('coupon_id')->nullable();
            $table->foreignId('address_id')->nullable();
            $table->foreignId('area_id')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->float('total_amount');
            $table->string('status');
            $table->string('is_gift');
            $table->string('gift_recipient_name');
            $table->string('gift_recipient_address');
            $table->text('notes');
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
