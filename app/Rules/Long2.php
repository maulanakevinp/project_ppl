<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Long2 implements Rule
{
    private $long1;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($long1)
    {
        $this->long1 = $long1;
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
        if ($value >= $this->long1) {
            return true;
        } elseif ($value <= $this->long1) {
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
        return 'The longitude 2 must be greater than longitude 1.';
    }
}
