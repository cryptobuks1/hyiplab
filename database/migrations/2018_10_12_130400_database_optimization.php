<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseOptimization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `sender` (`sender`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `receive` (`receive`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `bot_id` (`bot_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `scope_id` (`scope_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `message_id` (`message_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_messages` ADD INDEX `extra_data` (`extra_data`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_bots` ADD INDEX `token` (`token`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bots` ADD INDEX `bot_id` (`bot_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bots` ADD INDEX `keyword` (`keyword`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `update_id` (`update_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `message_id` (`message_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `from_id` (`from_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `from_username` (`from_username`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `chat_id` (`chat_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `bot_keyword` (`bot_keyword`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `bot_id` (`bot_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_events` ADD INDEX `webhook_id` (`webhook_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_bot_scopes` ADD INDEX `bot_keyword` (`bot_keyword`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_scopes` ADD INDEX `command` (`command`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_bot_scopes` ADD INDEX `method_address` (`method_address`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_users` ADD INDEX `user_id` (`user_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_users` ADD INDEX `bot_id` (`bot_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_users` ADD INDEX `telegram_user_id` (`telegram_user_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_users` ADD INDEX `username` (`username`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_webhooks` ADD INDEX `telegram_bot_id` (`telegram_bot_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_webhooks` ADD INDEX `url` (`url`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `telegram_webhooks_info` ADD INDEX `telegram_webhook_id` (`telegram_webhook_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `telegram_webhooks_info` ADD INDEX `url` (`url`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `task_scopes` ADD INDEX `key` (`key`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `task_scopes` ADD INDEX `checker_command_name` (`checker_command_name`);'); } catch (Exception $exception) {}

        try {
            Schema::table('users_social_meta', function (Blueprint $table) {
                $table->string('s_key', 500)->nullable()->change();
                $table->string('s_value', 500)->nullable()->change();
            });
        } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `users_social_meta` ADD INDEX `s_key` (`s_key`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users_social_meta` ADD INDEX `s_value` (`s_value`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `wallets` ADD INDEX `payment_system_id` (`payment_system_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `withdrawal_requests` ADD PRIMARY KEY(`id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `user_ips` ADD INDEX `ip` (`ip`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `partner_id` (`partner_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `phone` (`phone`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `skype` (`skype`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `blockio_wallet_btc` (`blockio_wallet_btc`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `blockio_wallet_ltc` (`blockio_wallet_ltc`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `blockio_wallet_doge` (`blockio_wallet_doge`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `sex` (`sex`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `country` (`country`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `city` (`city`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `email_verified_at` (`email_verified_at`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `email_verification_sent` (`email_verification_sent`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `users` ADD INDEX `email_verification_hash` (`email_verification_hash`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `transactions` ADD INDEX `batch_id` (`batch_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `tpl_default_langs` ADD INDEX `category` (`category`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `page_views` ADD INDEX `user_id` (`user_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `page_views` ADD INDEX `user_ip` (`user_ip`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `blockio_notifications` ADD INDEX `network` (`network`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `blockio_notifications` ADD INDEX `notification_id` (`notification_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `sessions` ADD INDEX `user_id` (`user_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `sessions` ADD INDEX `ip_address` (`ip_address`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `currencies` ADD INDEX `currency_id` (`currency_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `currency_payment_system` ADD INDEX `currency_id` (`currency_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `currency_payment_system` ADD INDEX `payment_system_id` (`payment_system_id`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `deposits` ADD INDEX `autoclose` (`autoclose`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `deposits` ADD INDEX `active` (`active`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `deposits` ADD INDEX `condition` (`condition`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `faqs` ADD INDEX `lang_id` (`lang_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `faqs` ADD INDEX `title` (`title`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `languages` ADD INDEX `default` (`default`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `referrals` ADD INDEX `on_load` (`on_load`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `referrals` ADD INDEX `on_profit` (`on_profit`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `referrals` ADD INDEX `on_task` (`on_task`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `mail_sents` ADD INDEX `mail_id` (`mail_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `mail_sents` ADD INDEX `user_id` (`user_id`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `mail_sents` ADD INDEX `email` (`email`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `mail_sents` ADD INDEX `status` (`status`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `password_resets` ADD INDEX `token` (`token`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `payment_systems` ADD INDEX `name` (`name`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `payment_systems` ADD INDEX `code` (`code`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `payment_systems` ADD INDEX `connected` (`connected`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `name` (`name`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `min` (`min`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `max` (`max`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `duration` (`duration`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `reinvest` (`reinvest`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `autoclose` (`autoclose`);'); } catch (Exception $exception) {}
        try { \DB::unprepared('ALTER TABLE `rates` ADD INDEX `active` (`active`);'); } catch (Exception $exception) {}

        try { \DB::unprepared('ALTER TABLE `reviews` ADD INDEX `lang_id` (`lang_id`);'); } catch (Exception $exception) {}
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
