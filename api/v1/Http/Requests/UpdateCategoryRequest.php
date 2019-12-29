<?php

namespace Api\V1\Http\Requests;

class UpdateCategoryRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }
}
