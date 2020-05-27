<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $table = 'products';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $keyType = 'string';

    public function category()
    {
        return $this->hasOne(Category::class, 'ID', 'CATEGORY');
    }

    public function product_cat(){
        return $this->hasOne(Products_Cat::class,'PRODUCT');
    }

}
