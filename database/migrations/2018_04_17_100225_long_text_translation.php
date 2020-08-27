<?php
use Illuminate\Database\Migrations\Migration;

class LongTextTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `tpl_translations` CHANGE `text` `text` LONGTEXT NULL DEFAULT NULL;');
        DB::statement('ALTER TABLE `tpl_default_langs` DROP INDEX `tpl_default_langs_text_unique`;');
        DB::statement('ALTER TABLE `tpl_default_langs` CHANGE `text` `text` LONGTEXT NULL DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This update don't need DOWN
    }
}
