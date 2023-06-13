<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAntemortemDailyRecordRequest extends FormRequest
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
            'id_guide' => 'required',
            'code' => 'required',
            'id_gender' => 'required',
            'id_age' => 'required',
            'id_purpose' => 'required',
            'id_color' => 'required',
            'sacrifice_date' => 'required',
            'id_outlet' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_guide.required' => 'El parametro :attribute es requerido',
            'code.required' => 'El parametro :attribute es requerido',
            'id_gender.required' => 'El parametro :attribute es requerido',
            'id_age.required' => 'El parametro :attribute es requerido',
            'id_outlet.required' => 'El parametro :attribute es requerido',
            'sacrifice_date.required' => 'El parametro :attribute es requerido',
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
