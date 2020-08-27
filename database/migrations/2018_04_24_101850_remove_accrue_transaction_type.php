<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAccrueTransactionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $type = \App\Models\TransactionType::where('name', 'accrue_dep')->first();

        if (!empty($type)) {
            \App\Models\Transaction::where('type_id', $type->id)->delete();
            DB::statement('DELETE FROM transaction_types WHERE name="accrue_dep"');
        }
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
