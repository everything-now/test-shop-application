<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:filter|max:255',
            'phone' => 'required|max:30',
            'city' => 'required|max:255',
            'shipping_adress_1' => 'required|max:255',
            'shipping_adress_2' => 'max:255',
            'shipping_adress_3' => 'max:255',
            'country_code' => 'required|max:2',
            'zip_postal_code' => 'required|max:20',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
