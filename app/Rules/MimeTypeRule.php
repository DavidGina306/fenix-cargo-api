<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MimeTypeRule implements Rule
{

    private $types;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $mime
     * @return bool
     */
    public function passes($attribute, $mime)
    {
        return in_array(mb_strtolower($mime), $this->types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'invalid file type';
    }
}
