<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBlogsTableAddScheduledColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Modify title to be longText
            $table->longText('title')->change();

            // Add new columns
            $table->boolean('is_scheduled')->default(false);
            $table->dateTime('scheduled_publish_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Revert the title column back to string
            $table->string('title')->change();

            // Drop the new columns
            $table->dropColumn('is_scheduled');
            $table->dropColumn('scheduled_publish_date');
        });
    }
}
