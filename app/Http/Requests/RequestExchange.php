<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestExchange
 * @package App\Http\Requests
 *
 * @property string wallet_from_id
 * @property string wallet_to_id
 * @property float amount
 */
class RequestExchange extends FormRequest
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
            'wallet_to_id'      => 'required',
            'amount'            => 'required|numeric|min:0',
        ];
    }
}
