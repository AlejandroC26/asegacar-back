<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AntemortemDailyRecordRequestFormatRequest extends FormRequest
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
            'sacrifice_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
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
        ], 400));
    }
}
