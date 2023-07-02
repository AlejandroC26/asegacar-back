<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreIncomeRequest extends FormRequest
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
            'guide_number' => 'required',
            'total_males' => 'required',
            'total_females' => 'required',
            'date_entry' => 'required',
            'time_entry' => 'required',
            'benefit_date' => 'required',
            'yard_sacrificed_time' => 'required',
            'farm_name' => 'required',
            'gender' => 'required',
            'color' => 'required',
            'id_owner' => 'required',
            'id_buyer' => 'required',
            'id_age' => 'required',
            'id_purpose' => 'required',
            'id_outlet' => 'required',
            'id_city' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El parametro :attribute es requerido',
            'guide_number.required' => 'El parametro :attribute es requerido',
            'total_males.required' => 'El parametro :attribute es requerido',
            'total_females.required' => 'El parametro :attribute es requerido',
            'date_entry.required' => 'El parametro :attribute es requerido',
            'time_entry.required' => 'El parametro :attribute es requerido',
            'benefit_date.required' => 'El parametro :attribute es requerido',
            'yard_sacrificed_time.required' => 'El parametro :attribute es requerido',
            'farm_name.required' => 'El parametro :attribute es requerido',
            'gender.required' => 'El parametro :attribute es requerido',
            'color.required' => 'El parametro :attribute es requerido',
            'id_owner.required' => 'El parametro :attribute es requerido',
            'id_buyer.required' => 'El parametro :attribute es requerido',
            'id_age.required' => 'El parametro :attribute es requerido',
            'id_purpose.required' => 'El parametro :attribute es requerido',
            'id_outlet.required' => 'El parametro :attribute es requerido',
            'id_city.required' => 'El parametro :attribute es requerido',
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
