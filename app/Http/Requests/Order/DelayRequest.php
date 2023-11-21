<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class DelayRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }

    public function getOrderId()
    {
        return $this->input('order_id');
    }
}
