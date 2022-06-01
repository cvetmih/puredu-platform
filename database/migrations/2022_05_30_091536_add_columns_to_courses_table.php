<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('full_title');
            $table->integer('sale');
            $table->string('image');
            $table->string('header_image');
            $table->text('header_body');
            $table->string('intro_title');
            $table->text('intro_body');
            $table->string('trailer_image');
            $table->string('trailer_video');
            $table->json('timeline');
            $table->json('coach_images');
            $table->json('coach_body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'full_title',
                'sale',
                'image',
                'header_image',
                'header_body',
                'intro_title',
                'intro_body',
                'trailer_image',
                'trailer_video',
                'timeline',
                'coach_images',
                'coach_body'
            ]);
        });
    }
}
