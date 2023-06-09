<?php

namespace App\Http\Requests;

use App\Rules\Ativo;
use App\Rules\Imagem;
use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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

        return [
            'produto' => ['required'],
            'valor' => ['required','numeric'],
            'ativo' => ['required', new Ativo],
            'imagem' => [new Imagem, 'image']
        ];
    }
}
