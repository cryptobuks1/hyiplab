<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestSupport
 * @package App\Http\Requests
 *
 * @property string name
 * @property string email
 * @property string subject
 * @property string body
 */
class RequestSupport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'subject'   => 'required',
            'body'      => 'required|string',
            'captcha'   => 'required|captcha',
        ];
    }
}
