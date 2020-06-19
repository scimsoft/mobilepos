<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Integer;

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
            return redirect()->action('OrderController@order');
        }else{
            $rawplaces= Place::orderBy('id')->get();
            $places=$rawplaces->sort();
            return view('home',compact('places'));
        }

    }

    public function clean(){
        Session::remove('order_id');
        Session::remove('table_number');
        return $this->index();
    }

    public function admin()
    {
        $places= Place::orderby('name')->get();
        //Log::debug('Places = '.$places);

        return view('admin.admin',compact('places'));
    }
}
