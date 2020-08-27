<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestTransferFund
 * @package App\Http\Requests
 *
 * @property string wallet_from_id
 * @property float amount
 * @property string addressee
 */
class RequestTransferFund extends FormRequest
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
            'wallet_from_id'    => 'required',
            'amount'            => 'required|numeric|min:0',
            'addressee'         => 'required',
        ];
    }
}
