<?php
namespace App\Http\ViewComposers;
use App\Product;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 24/04/2020
 * Time: 16:53
 */
class ProductsComposer
{

    public function compose(View $view){
        $columns = Product::orderBy('name')->get(['ID','NAME','CATEGORY']);
        $columnarrays = collect($columns->toArray());
        $view->with('products',$columnarrays);
//        $view->with('categories',Category::orderBy('name')->get());
    }


}