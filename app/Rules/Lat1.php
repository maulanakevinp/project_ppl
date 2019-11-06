<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lat1 implements Rule
{

    private $lat2;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($lat2)
    {
        $this->lat2 = $lat2;
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
        if ($value <= $this->lat2) {
            return true;
        } elseif($value >= $this->lat2) {
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
        return 'The latitude 1 must be smaller than latitude 2';
    }
}
