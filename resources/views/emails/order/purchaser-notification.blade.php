<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html lang="{{app()->getLocale()}}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{ config('app.name') }}</title>
    </head>
    <body style="background:#c2c2bc;">
        <h2>Your order has been accepted. There are list of products</h2>
        @foreach ($products as $product)
            {{ $product->name }} - {{ $product->pivot->quantity }} (quantity) <br>
        @endforeach
    </body>
</html>
