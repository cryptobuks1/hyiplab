<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('currency_id');
            $table->string('name');
            $table->float('min')->default(0)->unsigned();
            $table->float('max')->default(0)->unsigned();
            $table->float('daily')->default(0)->unsigned();
            $table->float('overall')->default(0)->unsigned();
            $table->integer('duration')->default(1)->unsigned();
            $table->float('payout')->default(100)->unsigned();
            $table->boolean('reinvest')->default(0);
            $table->boolean('autoclose')->default(0);
            $table->boolean('active')->default(0);
            $table->boolean('vip')->default(0);
            $table->timestamps();
        });

        Schema::table('rates', function ($table) {
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
