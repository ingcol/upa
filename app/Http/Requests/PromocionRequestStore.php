<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromocionRequestStore extends FormRequest
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
            'titulo' => 'required|min:6',
            'fechainicio'=>'date_format:"Y-m-d"|required',
            'fechafin'=>'date_format:"Y-m-d"|required',
            'tipo' => 'required|in:Evento,Promocion',

            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            
            
            
        ];
    }
     public function messages()
    {
        return [
            'titulo.required' => 'El campo título es requerido',
            'tipo.in' => 'El tipo de evento no es válido',
            'tipo.required' => 'Seleccione un tipo de evento',
            'titulo.min' => 'El título debe ser más explícito ',
            'fechainicio.required' => 'Seleccione una fecha de inicio',
            'fechainicio.date_format' => 'Seleccione un formato valido de fecha',
            'fechafin.required' => 'Seleccione una fecha de finalización',
            'fechafin.date_format' => 'Seleccione un formato valido de fecha',
            'file.required' => 'Seleccione una imagen'

        ];
    }


}
