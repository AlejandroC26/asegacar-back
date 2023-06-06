<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDailyPayrollRequest extends FormRequest
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
            'id_outlet' => 'required',
            'total_males' => 'required',
            'total_females' => 'required',
            'special_order' => 'max:1000',
            'benefit_date' => 'max:1000',
            'colors' => 'required',
            'genders' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id_outlet.required' => 'El parametro :attribute es requerido',
            'total_males.required' => 'El parametro :attribute es requerido',
            'total_females.required' => 'El parametro :attribute es requerido',
            'colors.required' => 'El parametro :attribute es requerido',
            'genders.required' => 'El parametro :attribute es requerido',
            'special_order.max' => 'El parametro :attribute ha sobrepasado el límite de carácteres',
            'benefit_date.max' => 'El parametro :attribute ha sobrepasado el límite de carácteres',
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
