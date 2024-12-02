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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("area_id");
            $table->boolean("is_default")->default(false);
            $table->string("street");
            $table->string("building_type");
            $table->string("building_number");
            $table->string("floor")->nullable();
            $table->string("apartment_number")->nullable();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('country_id')->references('id')
                ->on('countries')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('city_id')->references('id')
                ->on('cities')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('area_id')->references('id')
                ->on('areas')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
