<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeFinancieroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'balanza_id' => 'required|min:1',
            'no_cuenta' => 'required|string|min:3|max:255',
            'descripcion' => 'required|string|min:3|max:255',
            'categoria' => 'required|min:1',
            'etiqueta' => 'required|min:1',
            'monto_inicial' => 'nullable|numeric',
            'monto_final' => 'nullable|numeric',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'balanza_id' => 'balanza',
            'no_cuenta' => 'no. de cuenta',
            'descripcion' => 'descripción',
            'categoria' => 'categoría',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
