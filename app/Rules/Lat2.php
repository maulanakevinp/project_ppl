<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lat2 implements Rule
{
    private $lat1;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($lat1)
    {
        $this->lat1 = $lat1;
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
        if ($value >= $this->lat1) {
            return true;
        } elseif ($value <= $this->lat1) {
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
        return 'The latitude 2 must be greater than latitude 1.';
    }
}
