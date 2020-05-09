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

}
