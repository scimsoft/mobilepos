<?php

namespace Tests\Unit;

use App\Category;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    public function testProductBelongsToCategory(){
        $category = Category::first();
        $products = $category->products;
        $this->assertNotNull($products);
    }
}
