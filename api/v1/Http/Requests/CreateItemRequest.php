<?php

namespace Api\V1\Http\Requests;

use Api\V1\Entities\ItemEntity;

class CreateItemRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:' . ItemEntity::class . ',name',
        ];
    }
}
