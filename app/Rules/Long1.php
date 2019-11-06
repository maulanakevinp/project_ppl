<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Long1 implements Rule
{
    private $long2;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($long2)
    {
        $this->long2 = $long2;
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
        if ($value <= $this->long2) {
            return true;
        } elseif ($value >= $this->long2) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The longitude 1 must be smaller than longitude 2.';
    }
}
