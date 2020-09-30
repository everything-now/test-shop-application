<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewOrderRequest;
use App\Models\Order;
use App\Events\Ordered;

class OrdersController extends Controller
{
    /**
     * Store a new order
     *
     * @param NewOrderRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(NewOrderRequest $request)
    {
        $order = new Order();

        $details = $request->only($order->getFillable());
        $order->fill($details);

        $order->save();

        $order->products()->sync([
            $request->product_id => [
                'quantity' => $request->quantity
            ]
        ]);

        event(new Ordered($order));

        return response()->json(['message' => 'Order has been stored']);
    }
}
