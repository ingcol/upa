<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicidadRequestUpdate extends FormRequest
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
             'categoria' => 'required|in:intermedia,banner,principal,inicial,radio',
             'ciudad_id'=>'required_if:categoria,intermedia,banner,principal,radio',
             'url'=> 'required_if:categoria,radio',
             'estado'=>'required|in:A,I',
             'orden'=>'required|in:0,1,2,3,4,5,6,7,8,9,10',
            

             
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es requerido',
            'categoria.in' => 'La categoría no es válida',
            'ciudad_id.required' => 'Seleccione una ciudad',
            'url.required' => 'Ingrese una url',
            'estado.required' => 'El estado es requerido ',
            'estado.in' => 'El valor del estado no es válido',

            'orden.required' => 'Ingrese el orden de la publicidad',
            'orden.in' => 'Ingrese el orden de la publicidad',
            'ciudad_id.required_if' => 'Seleccione una ciudad',
            'url.required_if' => 'Ingrese una url',
            

        ];
    }
}
