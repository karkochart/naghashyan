<?php

namespace App\Http\Requests\Admin;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        return array_merge(
            [
                'id' => 'required|integer|exists:products,id',
            ],
            parent::rules()
        );
    }
}
