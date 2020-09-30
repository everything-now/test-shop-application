<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductCollection;

class ProductsController extends Controller
{
    /**
     * Get list of random products
     *
     * @return \App\Http\Resources\ProductCollection
     */
    public function getList()
    {
        $products = Product::inRandomOrder()->limit(5)->get();

        return new ProductCollection($products);
    }
}
