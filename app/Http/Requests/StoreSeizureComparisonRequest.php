<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSeizureComparisonRequest extends FormRequest
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
            'id_daily_payroll' => 'required',
            'head_quantity' => 'nullable',
            'small_ints_quantity' => 'nullable',
            'large_ints_quantity' => 'nullable',
            'oment_quantity' => 'nullable',
            'renet_quantity' => 'nullable',
            'callus_quantity' => 'nullable',
            'liver_quantity' => 'nullable',
            'lungs_quantity' => 'nullable',
            'legs_quantity' => 'nullable',
            'hands_quantity' => 'nullable',
            'udder_quantity' => 'nullable',
            'kidney_quantity' => 'nullable',
            'heart_quantity' => 'nullable',
            'booklet_quantity' => 'nullable',
            'white_viscera_quantity' => 'nullable',
            'red_viscera_quantity' => 'nullable',
            'destocking_quantity' => 'nullable',
            'canal_quantity' => 'nullable',
            'other_organ' => 'nullable',
            'other_quantity' => 'nullable',
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
