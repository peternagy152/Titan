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
        Schema::create('shop_category_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('shop_category_id');
            $table->unsignedBiginteger('product_id');

            $table->foreign('shop_category_id')->references('id')
                ->on('shop_categories')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_category_products');
    }
};
