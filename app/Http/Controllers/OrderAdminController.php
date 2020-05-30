<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use function retry;
use function returnArgument;

class OrderAdminController extends Controller
{
    //
    public function index(){
        $open_orders= MobileOrder::where('status','<','5')->orderBy('id', 'desc')->paginate(20);
        return view('admin.orders.orderlist',compact('open_orders'));
    }

    public function setReady($id){
        $order=MobileOrder::find($id);
        $order->status = 4;
        $order->save();
        return $this->index();

    }

    public function finish($id){
        $order=MobileOrder::find($id);
        $order->status = 5;
        $order->save();
        return $this->index();
    }

    public function setPaid($id){
        $order=MobileOrder::find($id);
        $order->status = 3;
        $order->save();
        return $this->index();
    }
}
