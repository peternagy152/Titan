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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string("sku")->unique();
            $table->longText("description")->nullable();
            $table->longText("short_description")->nullable();
            $table->string("image")->nullable();
            $table->string("gallery")->nullable();
            $table->string("type")->default("simple");
            $table->boolean("is_visible")->default(true);
            $table->float("price");
            $table->float("sale_price")->nullable();
            $table->boolean("manage_stock")->default(0);
            $table->boolean("in_stock")->default("1");
            $table->integer("stock_qtn")->default(0);
            $table->integer("total_sales")->default(0);
            $table->integer("backorder_limit")->default(0);
            $table->json("extra_fields")->nullable();
            //Seo 
            $table->string("meta_title")->nullable();
            $table->string("meta_description")->nullable();
            // Seo - OG
            $table->string("og_title")->nullable();
            $table->string("og_description")->nullable();
            $table->string("og_image")->nullable();

            //Seo - twitter
            $table->string("twitter_title")->nullable();
            $table->string("twitter_description")->nullable();
            $table->string("twitter_image")->nullable();

            //Seo - FB
            $table->string("facebook_title")->nullable();
            $table->string("facebook_description")->nullable();
            $table->string("facebook_image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
