<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CiudadRequestUpdate extends FormRequest
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
            'estado_id' => 'required|numeric',
            'nombre' => [
                'required','min:2',
                'unique:ciudades,nombre,'.$this->ciudad
            ]
        ];
    }

    public function messages(){

        return [
            'nombre.required' => 'El campo nombre no debe estar vacío',
            'nombre.unique' => 'El nombre ya esta registrado, utilice otro',
            'estado_id.required' => 'El campo departamento no debe estar vacío',
            'estado_id.numeric' => 'El campo departamento no debe estar vacío',
            
            
        ];
    }
}
