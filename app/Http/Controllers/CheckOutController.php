<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    //
    public function index(){

        Session::forget('status');
        return view('order.checkout');
    }
}
