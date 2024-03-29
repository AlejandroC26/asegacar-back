<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreZeroGutsToleranceRequest extends FormRequest
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
            'date' => 'required|date',
            'id_specie' => 'required',
            'id_daily_payroll' => 'required',
            'organ' => 'max:500',
            'fecal_matter' => 'max:500',
            'resume' => 'max:500',
            'hide' => 'max:500',
            'hair' => 'max:500',
            'hem' => 'max:500',
            'abscess' => 'max:500',
            'parasite' => 'max:500',
            'others' => 'max:500',
            'correction' => 'max:500',
            'quantity' => 'max:500',
            'observations' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'id_master.required' => 'El parametro :attribute es requerido',
            'id_daily_payroll.required' => 'El parametro :attribute es requerido',
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
