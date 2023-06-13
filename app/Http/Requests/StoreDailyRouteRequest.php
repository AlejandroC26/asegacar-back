<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDailyRouteRequest extends FormRequest
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
            'id_route' => 'required',
            'id_antemortem_daily_record' => 'required',
            'quantity' => 'required',
            'orders' => 'required',
            'date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_route.required' => 'El parametro :attribute es requerido',
            'id_antemortem_daily_record.required' => 'El parametro :attribute es requerido',
            'quantity.required' => 'El parametro :attribute es requerido',
            'orders.required' => 'El parametro :attribute es requerido',
            'date.max' => 'El parametro :attribute es requerido',
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
