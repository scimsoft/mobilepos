<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileOrderLines extends Model
{
    //
    public $prodctname= null;

    public function mobileOrder(){
        return $this->belongsTo(MobileOrder::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
