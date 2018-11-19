<?php

namespace App\Rules;

use App\CoveragePassThroughType;
use Illuminate\Contracts\Validation\Rule;

class ValidPassThroughType implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $data = CoveragePassThroughType::where('id',$value)->first();
        return count($data)>0? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please choose a valid value.';
    }
}
