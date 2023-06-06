<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreGuideRequest extends FormRequest
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
            'code' => 'required',
            'date_entry' => 'required',
            'time_entry' => 'required',
            'id_owner' => 'required',
            'id_buyer' => 'required',
            'id_source' => 'required',
            'id_destination' => 'required',
            'establishment_name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'El parametro :attribute es requerido',
            'date_entry.required' => 'El parametro :attribute es requerido',
            'time_entry.required' => 'El parametro :attribute es requerido',
            'id_owner.required' => 'El parametro :attribute es requerido',
            'id_buyer.required' => 'El parametro :attribute es requerido',
            'id_source.required' => 'El parametro :attribute es requerido',
            'id_destination.required' => 'El parametro :attribute es requerido',
            'establishment_name.required' => 'El parametro :attribute es requerido',
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
