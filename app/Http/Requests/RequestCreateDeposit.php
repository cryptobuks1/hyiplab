<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestCreateDeposit
 * @package App\Http\Requests
 *
 * @property string rate_id
 * @property string wallet_id
 * @property float amount
 * @property string pay_from
 */
class RequestCreateDeposit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rate_id'       => 'required',
            'wallet_id'     => 'required',
            'amount'        => 'required',
            'pay_from'      => 'required',
        ];
    }
}
