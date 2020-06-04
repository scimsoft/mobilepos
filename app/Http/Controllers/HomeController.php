<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        $places=null;
        Session::put('status','');
        if(Session::get('order_id')){
            $table_number = MobileOrder::find(Session::get('order_id'))->table_number;
            Log::debug('table_number is=:'.$table_number);
            $places= Place::where('id',$table_number)->get();
            Log::debug('$places is=:'.$places);
        }else{
            $places= Place::orderby('name')->get();
        }
        return view('home',compact('places'));
    }

    public function admin()
    {
        $places= Place::orderby('name')->get();
        //Log::debug('Places = '.$places);

        return view('admin.admin',compact('places'));
    }
}
