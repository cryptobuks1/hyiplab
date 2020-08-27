<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('faqs');
        Schema::dropIfExists('news_langs');
        Schema::dropIfExists('news');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('tpl_default_langs');
        Schema::dropIfExists('tpl_translation');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
