<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html lang="{{app()->getLocale()}}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{ config('app.name') }}</title>
    </head>
    <body style="background:#c2c2bc;">
        <h2>A new order has been created There are list of products</h2>
        @foreach ($products as $product)
            {{ $product->name }} - {{ $product->pivot->quantity }} (quantity) <br>
        @endforeach
        <h3>Purchaser email {{ $order->email }}</h3>
        <h3>Purchaser phone {{ $order->phone }}</h3>
        <h3>Shipping address</h3>
            Country Code: {{ $product->country }} <br>
            City: {{ $product->city }} <br>
            Address: {{ $product->shipping_adress_1 }}, {{ $product->shipping_adress_2 }}, {{ $product->shipping_adress_3 }} <br>
            Zip Code: {{ $product->zip_postal_code }} <br>
    </body>
</html>
