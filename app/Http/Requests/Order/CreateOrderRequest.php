<?php

namespace App\Http\Requests\Order;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'delivery_date' => 'required|date',
            'email' => 'required|email',
            'phone' => new Phone(),
            'address' => 'max:255',
            'positions' => 'required|min:1',
            'positions.*.product_id' => 'required|numeric',
            'positions.*.amount' => 'required|numeric'
        ];
    }
}
