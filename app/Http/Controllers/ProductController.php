<?php

namespace App\Http\Controllers;

use App\Product;
use App\Products_Cat;
use function base64_decode;
use function base64_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use function isEmpty;
use function retry;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::orderBy('NAME')->paginate(10);
        foreach($products as $product){
            if (!empty($product->IMAGE)) {
                $product->IMAGE = base64_encode($product->IMAGE);
            }
        }

        //Log::debug('products: ' . $products);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::find($id);
        if (!empty($product->IMAGE)) {
            $product->IMAGE = base64_encode($product->IMAGE);
        }
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Log::debug('UPDATE PRODCUT');
        /*$request->validate([
            'NAME'=>'required',
            'PRICEBUY'=>'required',
            'PRICESELL'=>'required',

        ]);*/
        Log::debug('UPDATE PRODCUT with ID:' . $id);
        //Log::debug('UPDATE PRODCUT with NAME:' . $request->get('NAME'));


        $product = Product::find($id);
        //Log::debug('FOUND PRODUCT :' . $product->NAME);
        $product->NAME = $request->get('NAME');
        $product->PRICEBUY = $request->get('PRICEBUY');

        $sell = $request->get('PRICESELL');
        $product->PRICESELL = $sell/1.1;
        $product->DESCRIPTION = $request->get('DESCRIPTION');

        $product->save();
        Log::debug(' isVisible checked' .$request->get('isVisible') );
        if(!empty($request->get('isVisible')) AND empty(Products_Cat::find($id))){
            Log::debug('enter in isVisible checked');
            $product_cat = new Products_Cat();
            $product_cat->PRODUCT = $id;
            $product_cat->save();
        }else{
            $product_cat=Products_Cat::find($id);
            if(!empty($product_cat))$product_cat->delete();

        }

        return redirect('products/')->with('status', 'Product updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        Session::setId('status','Producto Borrado');
        
    }

    public function getAjaxProductDetails($id)
    {
        Log::debug('ENTER AJAX con id:' . $id);
        $product = Product::find($id);

        if (!empty($product->IMAGE)) {
            Log::debug('There is an image');
            $product->IMAGE = base64_encode($product->IMAGE);
        }
        return $product;
    }

    public function editImage($id)
    {
        Log::debug('editImage function con product id:' . $id);
        $product = Product::find($id);
        if (!empty($product->IMAGE)) {
            $product->IMAGE = base64_encode($product->IMAGE);
        }
        Log::debug('editImage function con product:' . $product);
        return view('admin.products.crop_image', compact('product'));
    }

    public function imageCrop(Request $request)
    {
        $image_file = $request->image;
        $product = Product::find($request->productID);

        list($type, $image_file) = explode(';', $image_file);
        list(, $image_file) = explode(',', $image_file);
        $image_file = base64_decode($image_file);
        $product->IMAGE = $image_file;
        $product->save();
        return response()->json(['status' => true]);
    }

    public function toggleCatalog(Request $request){
        $product = Products_Cat::find($request->product_id);
        if(empty($product)){
            $cat = new Products_Cat();
            $cat->PRODUCT = $request->product_id;
            $cat->save();
        }else{
            $product->delete();
        }
        return "SUCCES";

    }


}
