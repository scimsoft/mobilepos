<?php
namespace App\Http\ViewComposers;
use App\Category;

use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 24/04/2020
 * Time: 16:53
 */
class CategoriesComposer
{

    public function compose(View $view){
//        $view->with('categories',Category::orderBy('name')->where('CATSHOWNAME',1)->get()->pluck('ID','NAME'));

    }


}