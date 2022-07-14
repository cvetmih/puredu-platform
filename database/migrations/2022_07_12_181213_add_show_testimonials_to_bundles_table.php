<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowTestimonialsToBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->boolean('show_testimonials')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn([
                'show_testimonials'
            ]);
        });
    }
}
