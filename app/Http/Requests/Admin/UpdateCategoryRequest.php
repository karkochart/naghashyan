<?php

namespace App\Http\Requests\Admin;

class UpdateCategoryRequest extends StoreCategoryRequest
{
    public function rules(): array
    {
        return array_merge(
            [
                'id' => 'required|integer|exists:categories,id',
            ],
            parent::rules()
        );
    }
}
