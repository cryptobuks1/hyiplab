<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Admin
 * @package App\Models
 *
 * @property string name
 * @property string login
 * @property string password
 * @property string admin_template
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Uuids;
    use Impersonate;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var string[] $listPermissions */
    public static $listPermissions = [
        'horizon', // special
        'logs',
        'admin.impersonate',
        'admin.action_logs.index',
        'admin.settings.wallets.index',
        'admin.settings.rates.index',
        'admin.settings.affiliate.index',
        'admin.settings.mail.index',
        'admin.settings.backups.index',
        'admin.settings.administrators.index',
        'admin.settings.administrators.show',
        'admin.settings.translations.index',
        'admin.finance.transactions.index',
        'admin.finance.transactions.show',
        'admin.finance.transactions.edit',
        'admin.finance.transactions.update',
        'admin.finance.transactions.destroy',
        'admin.finance.deposits.index',
        'admin.finance.deposits.show',
        'admin.finance.deposits.update',
        'admin.finance.deposits.destroy',
        'admin.finance.statistic.index',
        'admin.clients.index',
        'admin.clients.show',
        'admin.clients.reftree',
        'admin.clients.page_views',
        'admin.clients.logs',
        'admin.clients.edit',
        'admin.clients.update',
        'admin.clients.update_password',
        'admin.clients.update_balance',
        'admin.clients.block',
        'admin.clients.unblock',
        'admin.settings.administrators.update',
        'admin.settings.administrators.update',
        'admin.settings.administrators.destroy',
        'admin.settings.administrators.update_password',
        'admin.settings.administrators.create',
        'admin.settings.administrators.store',
        'admin.settings.backups.backup_db',
        'admin.settings.backups.backup_files',
        'admin.settings.backups.backup_all',
        'admin.settings.backups.destroy',
        'admin.settings.backups.download',
        'admin.settings.translations.update',
        'admin.settings.translations.store',
        'admin.settings.wallets.update',
        'admin.settings.wallets.destroy',
        'admin.settings.wallets.create',
        'admin.settings.wallets.store',
        'admin.settings.rates.update',
        'admin.settings.rates.destroy',
        'admin.settings.rates.create',
        'admin.settings.rates.store',
        'admin.settings.affiliate.create',
        'admin.settings.affiliate.store',
        'admin.settings.affiliate.update',
        'admin.settings.affiliate.destroy',
        'admin.settings.mail.send',
        'admin.finance.withdrawals.index',
        'admin.finance.withdrawals.approve',
        'admin.finance.withdrawals.manually',
        'admin.finance.withdrawals.reject',
        'admin.content.news.index',
        'admin.content.faq.index',
        'admin.content.testimonials.index',
        'admin.tickets.index',
        'admin.settings.currencies.index',
        'admin.settings.currencies.show',
        'admin.settings.currencies.update',
        'admin.settings.currencies.create',
        'admin.settings.currencies.store',
        'admin.settings.currencies.destroy',
        'admin.settings.variables.index',
        'admin.settings.variables.create',
        'admin.settings.variables.store',
        'admin.settings.variables.update',
        'admin.settings.variables.destroy',
        'admin.settings.languages.index',
        'admin.settings.languages.show',
        'admin.settings.languages.create',
        'admin.settings.languages.store',
        'admin.settings.languages.update',
        'admin.settings.languages.destroy',
        'admin.content.news.index',
        'admin.content.news.create',
        'admin.content.news.store',
        'admin.content.news.show',
        'admin.content.news.update',
        'admin.content.news.destroy',
        'admin.content.faq.index',
        'admin.content.faq.create',
        'admin.content.faq.store',
        'admin.content.faq.show',
        'admin.content.faq.update',
        'admin.content.faq.destroy',
        'admin.content.testimonials.index',
        'admin.content.testimonials.create',
        'admin.content.testimonials.store',
        'admin.content.testimonials.show',
        'admin.content.testimonials.update',
        'admin.content.testimonials.destroy',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'login',
        'password',
        'admin_template',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionLogs()
    {
        return $this->hasMany(ActionLog::class, 'user_id');
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): Admin
    {
        $this->password = Hash::make($password);
        $this->save();

        return $this;
    }
}