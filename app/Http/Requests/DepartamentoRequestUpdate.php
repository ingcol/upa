<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoRequestUpdate extends FormRequest
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
            
           'nombre' => [
            'required','min:2',
            'unique:estados,nombre,'.$this->departamento
        ],
            'pais_id' => 'required|numeric',
            

        ];
    }

    public function messages(){

        return [
            'nombre.required' => 'El campo nombre no debe estar vacío',
            'nombre.unique' => 'El nombre ya esta registrado, utilice otro',
            'pais_id.required' => 'El campo país no debe estar vacío',
            'pais_id.numeric' => 'El campo país no debe estar vacío',
            
        ];
    }
}
