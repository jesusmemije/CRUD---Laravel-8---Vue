<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|min:4|max:150',
            'descripcion' => 'required|min:4',
            'stock' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.*' => 'El nombre debe tener mínimo 4 caracteres y máximo 150',
            'descripcion.*' => 'La descripción debe tener mínimo 4 caracteres',
            'stock.required' => 'La cantidad debe ser mayor a 0',
        ];
    }
}
