<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_product',
        'name_product',
        'brand',
        'qty',
        'price',
        'description',
        'photo',
        'link'
    ];
}
