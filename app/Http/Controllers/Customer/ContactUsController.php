<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ContactUsController
 * @package App\Http\Controllers\Customer
 */
class ContactUsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('customer.contact_us');
    }
}
