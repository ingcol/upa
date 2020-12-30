<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificacionRequest extends FormRequest
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
             'calificacion' => 'required|max:5',
             'empresa_id'=>'required|numeric',
             'idTelefono'=>'required'
        ];
    }
    public function messages(){

        return [
            'calificacion.required' => 'Ingrese un valor para la calificación',
            'calificacion.numeric' => 'Ingrese un valor para la calificación',
            'calificacion.max' => 'Ingrese un valor para la calificación',
            'empresa_id.required' => 'Seleccione una empresa',
            'empresa_id.numeric' => 'Seleccione una empresa',
            'idTelefono.required' => 'No es posible emitir una calificación',
            
        ];
    }
}
