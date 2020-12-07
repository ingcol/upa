<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CiudadRequestStore extends FormRequest
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
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            'nombre' => 'required|min:2|unique:ciudades,nombre',
            'estado_id' => 'required|numeric',
        ];
    }
    public function messages(){

        return [
            'nombre.required' => 'El campo nombre no debe estar vacío',
            'nombre.unique' => 'El nombre ya esta registrado, utilice otro',
            'estado_id.required' => 'El campo departamento no debe estar vacío',
            'estado_id.numeric' => 'El campo departamento no debe estar vacío',
            'imagen.required' => 'Seleccione una imagen',
            'banner.required' => 'Seleccione un banner'
            
        ];
    }
}
