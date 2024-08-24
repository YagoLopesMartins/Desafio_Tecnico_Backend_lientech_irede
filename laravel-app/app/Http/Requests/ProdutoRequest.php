<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors()
        ], 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }
    public function messages(): array
    {
        return [
            'nome.required'                     => 'O nome do produto é obrigatório.',
            'nome.max'                          => 'O nome do produto não pode ter mais que 50 caracteres.',
            'descricao.max'                     => 'A descrição do produto não pode ter mais que 200 caracteres.',
            'preco.required'                    => 'O preço do produto é obrigatório.',
            'preco.numeric'                     => 'O preço deve ser um número.',
            'preco.min'                         => 'O preço deve ser um valor positivo.',
            'data_validade.date'                => 'A data de validade deve ser uma data válida.',
            'data_validade.after_or_equal'      => 'A data de validade não pode ser anterior à data atual.',
            'imagem.image'                      => 'O arquivo deve ser uma imagem.',
            'imagem.mimes'                      => 'A imagem deve ser do tipo jpg, jpeg, png ou gif.',
            'imagem.max'                        => 'A imagem não pode ser maior que 2MB.',
            'categoria_id.required'             => 'A categoria do produto é obrigatória.',
            'categoria_id.exists'               => 'A categoria selecionada não é válida.',
        ];
    }
}
