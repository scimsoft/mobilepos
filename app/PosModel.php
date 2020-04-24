<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 24/04/2020
 * Time: 13:35
 */

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class PosModel extends Model
{
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

}