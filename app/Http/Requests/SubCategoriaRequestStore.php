<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriaRequestStore extends FormRequest
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
            
            'nombre' => 'required|min:2|unique:subcategorias,nombre',
            'categoria_id' => 'required|numeric',
            

        ];
    }

    public function messages(){

        return [
            'nombre.required' => 'El campo nombre no debe estar vacío',
            'nombre.unique' => 'El nombre ya esta registrado, utilice otro',
            'categoria_id.required' => 'El campo categoría no debe estar vacío',
            'categoria_id.numeric' => 'El campo categoría no debe estar vacío',
            
        ];
    }
}
