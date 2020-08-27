<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTplTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpl_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('text')->nullable();
            $table->uuid('lang_id');
            $table->uuid('default_id');
            $table->timestamps();
        });

        Schema::table('tpl_translations', function($table) {
            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('default_id')->references('id')->on('tpl_default_langs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tpl_translations');
    }
}
