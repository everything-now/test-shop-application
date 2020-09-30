<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 30);
            $table->string('email');
            $table->string('shipping_adress_1');
            $table->string('shipping_adress_2')->nullable();
            $table->string('shipping_adress_3')->nullable();
            $table->string('city');
            $table->string('country_code', 2);
            $table->string('zip_postal_code', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
