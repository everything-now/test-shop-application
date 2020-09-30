<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'shipping_adress_1',
        'shipping_adress_2',
        'shipping_adress_3',
        'city',
        'country_code',
        'zip_postal_code',
    ];

    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
