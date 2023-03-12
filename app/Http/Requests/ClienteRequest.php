<?php

namespace App\Http\Requests;

use App\Rules\ClienteNome;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $hoje = date('Y-m-d');
        return [
            'nome' => ['required', 'string', new ClienteNome],
            'cpf' => ['required', 'min:11', 'max:11'],
            'data_nasc' => ['required', 'date', "before:$hoje"]
        ];
    }
}
