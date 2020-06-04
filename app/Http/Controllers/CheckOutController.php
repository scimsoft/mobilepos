<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    //
    public function index(){

        Session::forget('status');
        if(Session::get('table_number')){
            return view('order.payed');
        }else{
            return view('order.checkout');
        }
    }
}
