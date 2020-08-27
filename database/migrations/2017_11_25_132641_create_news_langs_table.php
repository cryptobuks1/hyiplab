<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_langs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('news_id');
            $table->uuid('lang_id');
            $table->boolean('show')->default(false);
            $table->string('title')->nullable();
            $table->text('teaser')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();
        });

        Schema::table('news_langs', function($table) {
            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_langs');
    }
}
