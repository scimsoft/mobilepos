<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\MobileOrderLines;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    //
    public function index(){
        return view('order.order');
    }

    public function addOrderLine(Request $request){

        Log::debug("Entering controller: ".$request->get('orderline'));
        $inputArray = json_decode($request->get('orderline'),true);
        $orderline = new MobileOrderLines();
        if($inputArray[0]==0){
            Log::debug("Entering in order id = 0: ");
            $order=new MobileOrder();
            $order->save();
            $orderline->mobile_order_id = $order->id;
            Log::debug("Entering in session order id = : ".$order->id);
            Session::put('order_id',$order->id);
        }else{
            $orderline->mobile_order_id = $inputArray[0];
        }

        $orderline->product_ID = $inputArray[1];
        $orderline->price = $inputArray[2];
        $orderline->save();
        return response()->json(['status' => true]);
    }

    public function getOrderTotal($id){
        Log::debug('Entered in getOrderTotal with order_id:'.$id);

      // Log::debug('mobileOrderLines:'.MobileOrder::find($id)->mobileOrderLines->sum('price'));
        if(MobileOrder::find($id)->mobileOrderLines) {

            $order_total = MobileOrder::find($id)->mobileOrderLines->sum('price');
            Session::put('order_total',$order_total);
            return $order_total;
        }else{
            return '0.00';
        }

    }

    public function getBasket($id){
        Log::debug('Entered in getBasket($id) wuth id:'.$id);
        $orderlines = MobileOrder::find($id)->mobileOrderLines;
        foreach ($orderlines as $orderline){
            $orderline->productname = $orderline->product->NAME;
        }
        return view('order.basket',compact('orderlines'));
    }

    public function destroyOrderLine($id){

       $orderline=  MobileOrderLines::find($id);
       $orderid= $orderline->mobileOrder->id;
       $orderline->delete();
       Session::flash('message', 'Successfully deleted the nerd!');
       return $this->getBasket($orderid);
    }
}
