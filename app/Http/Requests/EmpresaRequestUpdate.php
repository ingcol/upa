<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequestUpdate extends FormRequest
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
           'nombre' => 'required|min:3',
           'ciudad_id' => 'required|numeric',
           'subcategoria_id' => 'required|numeric',
           'celular' => [
            'required','numeric','digits_between:10,15'
        ],
        'direccion' => 'required|min:3',
        'servicios' => 'required|min:3',
        'descripcion' => 'required|min:10',
         'whatsapp' => [
            'required','numeric','digits_between:10,15'
        ],
       
        
    ];
}
public function messages()
{
    return [
        'nombre.required' => 'El campo nombre es requerido',
        'subcategoria_id.required' => 'El campo  categoría es requerido',
        'ciudad_id.required' => 'Seleccione una ciudad',
        'subcategoria_id.numeric' => 'El campo  categoría no es válido',
        'ciudad_id.numeric' => 'Seleccione una ciudad',
        'celular.required' => 'El campo celular es requerido',
        'celular.numeric' => 'El campo celular debe ser numérico',
        'celular.digits_between' => 'El campo celular debe tener de 10 a 15 dígitos',
        'direccion.required' => 'El campo dirección es requerido',
        'direccion.min' => 'El campo dirección debe ser más explícito',
        'descripcion.required' => 'El campo descripción es requerido',
        'descripcion.min' => 'El campo descripción debe ser más explícito',
        
        
        'servicios.required' => 'El campo servicios es requerido',
        'servicios.min' => 'El campo servicios debe ser más explícito',

        'whatsapp.required' => 'El campo whatsapp es requerido',
        'whatsapp.numeric' => 'El campo whatsapp debe ser numérico',
        'whatsapp.digits_between' => 'El campo whatsapp debe tener de 10 a 15 dígitos',
    ];
}
}
