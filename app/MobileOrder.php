<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileOrder extends Model
{
    //

    public function mobileOrderLines(){
        return $this->hasMany(MobileOrderLines::class);
    }
}
