<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class MobileOrderLines extends Model
{
    //
    protected $primaryKey = 'id';
    public $prodctname= null;
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }

    public function mobileOrder(){
        return $this->belongsTo(MobileOrder::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
