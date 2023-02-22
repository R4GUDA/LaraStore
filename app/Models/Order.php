<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_date',
        'phone',
        'email',
        'address',
        'secret',
        'delivery_date'
    ];

    protected $dateFormat = "Y-m-d";

    public function products() {
        return $this->belongsToMany(Product::class, OrderProduct::class)->withPivot('amount');
    }
}
