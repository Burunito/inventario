<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sku'               => 'required|max:20',
            'nombre'            => 'required|max:50',
            'descripcion'       => 'max:255',
            'cantidad'          => 'required|numeric',
            'precio'            => 'required|numeric',
        ];
    }
}
