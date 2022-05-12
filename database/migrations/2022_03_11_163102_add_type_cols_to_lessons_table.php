<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColsToLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_free')->default(false);
            $table->boolean('is_downloadable')->default(false);
            $table->boolean('is_autoplay')->default(false);
            $table->json('questions')->nullable();
            $table->string('file_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'is_free',
                'is_downloadable',
                'is_autoplay',
                'questions',
                'file_url'
            ]);
        });
    }
}
