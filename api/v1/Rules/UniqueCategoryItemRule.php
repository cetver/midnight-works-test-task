<?php

namespace Api\V1\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueCategoryItemRule implements Rule
{
    private $categoryId;
    private $itemId;

    /**
     * Create a new rule instance.
     *
     * @param string $categoryId
     * @param string $itemId
     */
    public function __construct($categoryId, $itemId)
    {
        $this->categoryId = $categoryId;
        $this->itemId = $itemId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table('categories_items')
                 ->where('category_id', $this->categoryId)
                 ->where('item_id', $this->itemId)
                 ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The category already has such an item.';
    }
}
