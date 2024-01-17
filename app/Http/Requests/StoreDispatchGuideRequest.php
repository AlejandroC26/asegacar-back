<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreDispatchGuideRequest extends FormRequest
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
            'sacrifice_date' => 'required|date',
            'closing_date' => 'required|date',
            'closing_time' => 'required',
            'dispatch_time' => 'required',
            'average_temperature' => 'required',
            'id_outlet' => 'required',
            'id_vehicle' => 'required',
            'white_viscera' => 'nullable',
            'red_viscera' => 'nullable',
            'heads' => 'nullable',
            'legs' => 'nullable',
            'others' => 'nullable',
            'approved' => 'nullable',
            'observations' => 'nullable',
            'animals' => 'nullable',
            'animals.*.id' => 'required',
            'animals.*.amount' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'sacrifice_date.unique' => 'No se puede repetir fecha de sacrificio',
            'animals.*.amount.min' => 'Se debe digitar una cantidad mínima de :min.',
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
