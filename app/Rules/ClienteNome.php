<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ClienteNome implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nome_completo = $value;
        $nomes = explode(' ', $nome_completo);

        if (count($nomes) < 2 ) {
            $fail('O :attribute deve ser composto de no mínimo duas palavras (nome e pelo menos um sobrenome).');
        }
    }
}
