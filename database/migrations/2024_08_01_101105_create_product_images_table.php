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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->boolean("is_primary")->default(false);
            $table->string("image");
            $table->string("alt")->nullable();
            $table->string("title")->nullable();
            $table->string("caption")->nullable();
            $table->string("description")->nullable();
            $table->integer("width")->nullable();
            $table->integer("height")->nullable();
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
        Schema::dropIfExists('product_images');
    }
};
