<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Imagem implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $extension = strtolower(pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION));

        if ($extension != 'jpg') {
            $fail('O campo :attribute aceita apenas imagens em formato JPG.');
        }
    }
}
