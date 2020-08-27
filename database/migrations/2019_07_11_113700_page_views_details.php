<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PageViewsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->longText('get_request')->nullable();
            $table->longText('post_request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn('get_request');
            $table->dropColumn('post_request');
        });
    }
}
