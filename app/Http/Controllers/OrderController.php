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
use function set;


class OrderController extends Controller
{
    //

    public function order($tablename=null)
    {

        Log::debug("Entering index");
        Log::debug("sessiom order_id ".Session::get('order_id'));
        Log::debug("session tablename ".$tablename);
        if($tablename==null){
            $tablename=Session::get('table_number');
        }
        Log::debug("session table_number ".Session::get('table_number'));
        //if (!Session::get('order_id')) {
            $sharedticket = DB::connection('mysql2')->select('Select * from sharedtickets where id = '.$tablename);
            //dd($sharedticket);
            if(count($sharedticket)>0){
                $this->getOrderFromUnicenta($tablename,$sharedticket[0]);

            }else {
                $this->createNewOrder($tablename);
            }
       // }
        $controllerproducts = $this->getCategoryProducts('DRINKS');
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

        $orderline = new MobileOrderLines();
        $orderline->mobile_order_id = Session::get('order_id');
        $orderline->product_ID = $productID;
        $product = Product::find($productID);
        $orderline->price = $product->pricesell;
        $productcategory = $product->category;
        Log::debug('Getting product price del producto: '.$productID);
        Log::debug('Getting product price: '.$product->pricesell);
        $orderline->save();
        $controllerproducts = $this->getCategoryProducts($productcategory);
        Session::put('status','Producto añadido');
        return response()->json(['status' => true]);
        //return view('order.neworder', compact('controllerproducts'));
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

    public function getBasket($id=null){
        Log::debug('Entered in getBasket($id) wuth id:'.$id);
        Session::remove('status');
        $pendientesDePedir=false;
        $sePuedePagar=false;
        if(!empty($id)) {
            $order = MobileOrder::find($id);
            $orderlines = $order->mobileOrderLines;
            foreach ($orderlines as $orderline) {
                if ($orderline->printed == 0) $pendientesDePedir = true;

            }
            if($pendientesDePedir==false || $order->status < 2) $sePuedePagar=true;
            return view('order.basket',compact('orderlines','sePuedePagar','pendientesDePedir'));
        }else{
            redirect()->action('HomeController@index');
        }

    }

    public function destroyOrderLine($id)
    {
        $orderline = MobileOrderLines::find($id);
        $orderid = $orderline->mobileOrder->id;
        if ($orderline->printed) {
            Session::put('status', 'No se puede eliminar este producto');
        } else {

        Session::put('status', 'Producto elimnado');


        $orderline->delete();
        Session::flash('message', 'Successfully deleted the nerd!');
    }
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
                $products = Product::where('category', '4fabf8cc-c05c-492c-91cb-f0b751d41cee')->orderBy('name')->paginate(20);
                //dd($products);
                break;
            case 'FOOD':
            case 'bc143237-358d-4899-a170-5e7ba308e9a3':
                $products = Product::where('category', 'bc143237-358d-4899-a170-5e7ba308e9a3')
                    ->orWhere('category','a9769f52-af9f-4e80-8594-034ee3d18304')
                    ->orderBy('name')->paginate(20);

                break;
            case 'COFFEE':
            case '05b70271-edd3-48b9-8f28-13ac701372a9':
                $products = Product::where('category', '05b70271-edd3-48b9-8f28-13ac701372a9')->orderBy('name')->paginate(20);
                break;

            case 'COCTELES':
            case 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f':
                $products = Product::where('category', 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f')->orderBy('name')->paginate(20);
                break;

            case 'COPAS':
            case '9b4abf09-14e8-45db-97fa-1062c4c24574':
                $products = Product::where('category', '9b4abf09-14e8-45db-97fa-1062c4c24574')->orderBy('name')->paginate(20);
                break;

            case 'VINOS':
            case 'f91c6698-c108-4cb7-a691-216e587fd8a8':
                $products = Product::where('category', 'f91c6698-c108-4cb7-a691-216e587fd8a8')->orderBy('name')->paginate(20);
                break;
            case 'OTROS':
                $products = Product::where('category','0983bed0-8f5c-45c4-bfd4-d0b59152646f')
                    ->orWhere('category','51fd59b5-578f-4d66-b00b-f46c33336df2')
                    ->orWhere('category','26c209c2-d731-4e24-938b-d87ebaa2b7d9')
                    ->orWhere('category','fb462214-11ca-4e17-8ac5-4f24d68e7ba2')->orderBy('CATEGORY')->paginate(20);;
                break;
                default:
                $products = [];
        }

        Log::debug('productos en product controller getproductsformcategory');
        foreach ($products as $product) {
            // Log::debug('productos en product controller getproductsformcategory'.$product);
            if (!empty($product->image)) {
                $product->image = base64_encode($product->image);
            }

        }
        return $products;
    }
    public function callwaiter($id){
        $order = MobileOrder::find($id);
        $order -> status = 9;
        $order -> save();

    }

    /**
     * @param $tablename
     */
    public function createNewOrder($tablename)
    {
        Log::debug("Entering index -- creando order_id");
        $order = new MobileOrder();
        $order->status = 1;

            $order->table_number = $tablename;
            Session::put('table_number', $tablename);

        $order->save();
        Session::put('order_id', $order->id);
    }

    /**
     * @param $tablename
     */
    public function getOrderFromUnicenta($tablename,$unicenta)
    {
        Log::debug('Entered in recovering shared ticket');
        $mobileorder = MobileOrder::where('table_number', $tablename)->where('status', '<', 2)->latest('updated_at')->first();;
        if(!empty($mobileorder)) {
            $orderlines = $mobileorder->mobileOrderLines;
            foreach ($orderlines as $orderline) {
                $orderline->forceDelete();
            }
        }else{
            $mobileorder = new MobileOrder();
            $mobileorder->table_number = $tablename;
            $mobileorder->save();
        }
        $productlists = json_decode($unicenta->content)->m_aLines;

        foreach ($productlists as $productlist) {
            $mobileorderline=new MobileOrderLines();
            $mobileorderline->mobile_order_id = $mobileorder->id;
            $mobileorderline->product_id=$productlist->productid;
            $mobileorderline->price = $productlist->price;
            $mobileorderline->printed = 1;
            $mobileorderline->save();
                   }





        Session::put('order_id', $mobileorder->id);
        Session::put('table_number', $tablename);
    }
}
