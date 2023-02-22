<?php

namespace App\Http\Requests\Order;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'address' => 'max:255'
        ];
    }
}
