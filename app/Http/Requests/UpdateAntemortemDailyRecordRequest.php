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
            'id_product_type' => 'required',
            'id_outlet' => 'required',
            'sacrifice_date' => 'required|date',
            'special_order' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'sacrifice_date.required' => 'Registra la fecha de sacrificio',
            'id_product_type.required' => 'Registra el tipo de producto',
            'id_outlet.required' => 'Registra el número de expendio',
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
