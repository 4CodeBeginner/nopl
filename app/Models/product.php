<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id_product',
        'name_product',
        'brand',
        'description',
        'link',
        'photo'
    ];
}
