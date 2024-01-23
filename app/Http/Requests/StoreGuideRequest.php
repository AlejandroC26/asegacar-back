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
            'code' => 'required|unique:guides',
            'no_animals' => 'required|integer',
            'date_entry' => 'required',
            'time_entry' => 'required|date_format:H:i',
            'id_owner' => 'required',
            'id_buyer' => 'required',
            'id_source' => 'required',
            'id_destination' => 'required',
            'establishment_name' => 'required',
            'id_specie' => 'required',
            'file_attached' => 'mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'El código de guía debe ser único en el sistema',
            'time_entry.date_format' => 'Digita una fecha de ingreso en formato 24h válida'
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
