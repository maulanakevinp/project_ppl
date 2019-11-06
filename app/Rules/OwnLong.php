<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OwnLong implements Rule
{
    private $long1, $long2;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($long1, $long2)
    {
        $this->long1 = $long1;
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
        if ($value >= $this->long1 && $value <= $this->long2) {
            return true;
        } elseif ($value <= $this->long1 && $value >=  $this->long2) {
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
        return 'This not your area.';
    }
}
