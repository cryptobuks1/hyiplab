<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ticketit');
        Schema::dropIfExists('ticketit_audits');
        Schema::dropIfExists('ticketit_categories');
        Schema::dropIfExists('ticketit_categories_users');
        Schema::dropIfExists('ticketit_comments');
        Schema::dropIfExists('ticketit_priorities');
        Schema::dropIfExists('ticketit_settings');
        Schema::dropIfExists('ticketit_statuses');
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
