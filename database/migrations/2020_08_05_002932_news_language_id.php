<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsLanguageId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('language_id')->after('id');
        });

        Schema::table('faq', function (Blueprint $table) {
            $table->string('language_id')->after('id');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('language_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });

        Schema::table('faq', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });
    }
}
