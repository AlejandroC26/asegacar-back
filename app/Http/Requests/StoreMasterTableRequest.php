<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMasterTableRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'id_master_type' => 'required',
            'id_responsable' => 'max:500',
            'id_verified_by' => 'max:500',
            'id_supervised_by' => 'max:500',
            'id_elaborated_by' => 'max:500',
            'species' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'El parametro :attribute es requerido',
            'id_master_type.required' => 'El parametro :attribute es requerido',
            'id_responsable.max' => 'El parametro :attribute es requerido',
            'id_verified_by.max' => 'El parametro :attribute es requerido',
            'id_supervised_by.max' => 'El parametro :attribute es requerido',
            'id_elaborated_by.max' => 'El parametro :attribute es requerido',
            'species.max' => 'El parametro :attribute es requerido',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
