<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\MobileOrderLines;
use App\Product;
use Hamcrest\Arrays\MatchingOnce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    //

    public function order($tablename=null)
    {
        Session::flush();
        $controllerproducts = $this->getCategoryProducts('DRINKS');
        Log::debug("Entering index");
        if (!Session::get('order_id')) {
            Log::debug("Entering index -- creando order_id");
            $order = new MobileOrder();
            $order->status=1;
            if(empty($tablename)) {
                $order->table_number = 'llevar';
            }else{
                $order->table_number = $tablename;
            }
            $order->save();
            Session::put('order_id', $order->id);
        }
        return view('order.neworder', compact('controllerproducts'));
    }

    public function menu(){
        $controllerproducts = $this->getCategoryProducts('FOOD');
        return view('order.menu', compact('controllerproducts'));
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

    public function getProductsFromCategoryforAdmin($id){
        Session::put('status','');
        $products = $this->getCategoryProducts($id);
        return view('admin.products.index', compact('products'));
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
                $products = Product::where('CATEGORY', '4fabf8cc-c05c-492c-91cb-f0b751d41cee')->orderBy('NAME')->paginate(20);
                break;
            case 'FOOD':
            case 'bc143237-358d-4899-a170-5e7ba308e9a3':
                $products = Product::where('CATEGORY', 'bc143237-358d-4899-a170-5e7ba308e9a3')->orderBy('NAME')->paginate(20);

                break;
            case 'COFFEE':
            case '05b70271-edd3-48b9-8f28-13ac701372a9':
                $products = Product::where('CATEGORY', '05b70271-edd3-48b9-8f28-13ac701372a9')->orderBy('NAME')->paginate(20);
                break;

            case 'COCTELES':
            case 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f':
                $products = Product::where('CATEGORY', 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f')->orderBy('NAME')->paginate(20);
                break;

            case 'COPAS':
            case '9b4abf09-14e8-45db-97fa-1062c4c24574':
                $products = Product::where('CATEGORY', '9b4abf09-14e8-45db-97fa-1062c4c24574')->orderBy('NAME')->paginate(20);
                break;

            case 'VINOS':
            case 'f91c6698-c108-4cb7-a691-216e587fd8a8':
                $products = Product::where('CATEGORY', 'f91c6698-c108-4cb7-a691-216e587fd8a8')->orderBy('NAME')->paginate(20);
                break;
            case 'OTROS':
                $products = Product::where('CATEGORY','0983bed0-8f5c-45c4-bfd4-d0b59152646f')
                    ->orWhere('CATEGORY','51fd59b5-578f-4d66-b00b-f46c33336df2')
                    ->orWhere('CATEGORY','26c209c2-d731-4e24-938b-d87ebaa2b7d9')
                    ->orWhere('CATEGORY','fb462214-11ca-4e17-8ac5-4f24d68e7ba2')->orderBy('CATEGORY')->paginate(20);;
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
    public function callwaiter($id){
        $order = MobileOrder::find($id);
        $order -> status = 9;
        $order -> save();

    }
}
