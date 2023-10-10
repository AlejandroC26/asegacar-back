<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSuspiciousAnimalsRequest extends FormRequest
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
            'time' => 'required',
            'id_supervisor' => 'required',
            'id_responsable' => 'required',
            'id_veterinary' => 'required',
            'id_owner' => 'required',
            'iron' => 'required',
            'corral_location' => 'required',
            'id_location' => 'required',
            'id_daily_payroll' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'heart_frequency' => 'required',
            'respiratory_frequency' => 'required',
            'findings' => 'nullable|string',
            'observations' => 'nullable|string',
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
