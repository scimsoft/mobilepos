<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $table = 'products';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function product_cat(){
        return $this->hasOne(Products_Cat::class,'product','id');
    }

}
