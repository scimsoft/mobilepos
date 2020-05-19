<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\MobileOrderLines;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    //

    public function index()
    {
        Session::put('status','');
        $controllerproducts = $this->getCategoryProducts('DRINKS');
        Log::debug("Entering index");
        if (!Session::get('order_id')) {
            Log::debug("Entering index -- creando order_id");
            $order = new MobileOrder();
            $order->save();
            Session::put('order_id', $order->id);
        }
        return view('order.neworder', compact('controllerproducts'));
    }

    public function addOrderLine(Request $request){
        Log::debug("Entering controller: ".$request->get('orderline'));
        $inputArray = json_decode($request->get('orderline'),true);
        $orderline = new MobileOrderLines();
        $orderline->mobile_order_id = Session::get('order_id');
        $orderline->product_ID = $inputArray[1];
        $orderline->price = $inputArray[2];
        $orderline->save();
        return response()->json(['status' => true]);
    }

    public function addProduct($productID)
    {
        DB::enableQueryLog();
        $orderline = new MobileOrderLines();
        $orderline->mobile_order_id = Session::get('order_id');
        $orderline->product_ID = $productID;
        $product = Product::find($productID);
        $orderline->price = $product->PRICESELL;
        $productcategory = $product->CATEGORY;
        Log::debug('Getting product price del producto: '.$productID);
        Log::debug('Getting product price: '.$product->PRICESELL);
        //dd(DB::getQueryLog());
        $orderline->save();
        $controllerproducts = $this->getCategoryProducts($productcategory);
        Session::put('status','Producto añadido');
        return view('order.neworder', compact('controllerproducts'));
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
        Session::put('status','');
        $orderlines = MobileOrder::find($id)->mobileOrderLines;
        foreach ($orderlines as $orderline){
            $orderline->productname = $orderline->product->NAME;
        }
        return view('order.basket',compact('orderlines'));
    }

    public function destroyOrderLine($id){
        Session::put('status','Producto elimnado');
       $orderline=  MobileOrderLines::find($id);
       $orderid= $orderline->mobileOrder->id;
       $orderline->delete();
       Session::flash('message', 'Successfully deleted the nerd!');
       return $this->getBasket($orderid);
    }

    public function getProductsFromCategory($id){
        Session::put('status','');
        $products = $this->getCategoryProducts($id);
        $controllerproducts = $products;
        return view('order.neworder', compact('controllerproducts'));

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryProducts($id)
    {
        switch ($id) {
            case 'DRINKS':
            case '4fabf8cc-c05c-492c-91cb-f0b751d41cee':
                $products = Product::where('CATEGORY', '4fabf8cc-c05c-492c-91cb-f0b751d41cee')->orderBy('NAME')->get();
                break;
            case 'FOOD':
            case 'bc143237-358d-4899-a170-5e7ba308e9a3':
                $products = Product::where('CATEGORY', 'bc143237-358d-4899-a170-5e7ba308e9a3')->orderBy('NAME')->get();

                break;
            case 'COFFEE':
            case 'e092f14b-e48c-4d0d-8a1d-eda8a7ee4ce9':
                $products = Product::where('CATEGORY', 'e092f14b-e48c-4d0d-8a1d-eda8a7ee4ce9')->orderBy('NAME')->get();
                break;
            default:
                $products = [];
        }

        Log::debug('productos en product controller getproductsformcategory');
        foreach ($products as $product) {
            // Log::debug('productos en product controller getproductsformcategory'.$product);
            if (!empty($product->IMAGE)) {
                $product->IMAGE = base64_encode($product->IMAGE);
            }

        }
        return $products;
    }
}
