<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

/**
 * Class MainController
 * @package App\Http\Controllers\Customer
 */
class MainController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('customer.main');
    }
}
