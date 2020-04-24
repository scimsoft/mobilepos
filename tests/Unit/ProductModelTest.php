<?php

namespace Tests\Unit;

use App\Category;
use App\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{

    public function testDBHasProducts(){
        $products = Product::all();
        $this->assertEquals(count($products)>0,true);
    }

    public function testProductHasCategory()
    {
        $product = Product::first();
        $category = $product->category;
        $this->assertNotNull($category);
        $this->assertInstanceOf(Category::class, $category);
    }

}
