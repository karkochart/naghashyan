<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
