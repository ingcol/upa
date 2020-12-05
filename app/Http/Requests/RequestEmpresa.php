<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RequestEmpresa extends FormRequest
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
        switch ($this->method()) {
	        case 'GET':
	        case 'DELETE':
		        return [];
	        case 'POST': {
                	
  
	        	return [
                    'nombre' => 'required|min:3',
                    'descripcion' => 'required|min:5',
                    'slug' => [
                        'required',
                        'min:3',
                        Rule::unique('empresas','slug'),
                    ],
                    'logo' => 'sometimes|image|mimes:jpg,jpeg,png',    
                    'email' => 'nullable|email',
                    'whatsapp' => 'nullable|min:7',
                    'celular' => 'required|min:10',
                    'direccion' => 'required|min:5',
                    'facebook' => 'nullable|min:5',
                    'latitud' => 'nullable|min:5',
                    'longitud' => 'nullable|min:5',
                   

                    'ciudad_id' => [
			        	'required',
				        Rule::exists('ciudades', 'id'),
                    ],

                    'user_id' => [
			        	'nullable',
				        Rule::exists('users', 'id'),
                    ],

                    'subcategoria_id' => [
			        	'required',
				        Rule::exists('subcategorias', 'id'),
                    ],                    
		        ];
	        }
	        case 'PUT': {
                return [
	        	        'nombre' => 'required|min:3',
                    'descripcion' => 'required|min:5',
                    'slug' => ['required',
                    'min:5',
                    Rule::unique('empresas')->ignore($this->empresa->id),
                ],
                    'logo' => 'sometimes|image|mimes:jpg,jpeg,png',
                    
                    'email' => 'nullable|email',
                    'whatsapp' => 'nullable|min:7',
                    'celular' => 'required|min:10',
                    'direccion' => 'required|min:5',
                    'facebook' => 'nullable|min:5',
                    'latitud' => 'nullable|min:5',
                    'longitud' => 'nullable|min:5',

                    'ciudad_id' => [
			        	'required',
				        Rule::exists('ciudades', 'id'),
                    ],

                    'user_id' => [
			        	'nullable',
				        Rule::exists('users', 'id'),
                    ],

                    'subcategoria_id' => [
			        	'required',
				        Rule::exists('subcategorias', 'id'),
                    ], 
		        ];
	        }
        }
    }
}


