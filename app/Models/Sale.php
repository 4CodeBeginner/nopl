<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_date',
        'customer_name',
        'tracking_number',
        'total_amount'
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
