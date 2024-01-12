<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostmoremInspectionsRequest extends FormRequest
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
            'id_head_cause' => 'nullable',
            'head_quantity' => 'nullable',
            'id_small_ints_cause' => 'nullable',
            'small_ints_quantity' => 'nullable',
            'id_large_ints_cause' => 'nullable',
            'large_ints_quantity' => 'nullable',
            'id_oment_cause' => 'nullable',
            'oment_quantity' => 'nullable',
            'id_renet_cause' => 'nullable',
            'renet_quantity' => 'nullable',
            'id_callus_cause' => 'nullable',
            'callus_quantity' => 'nullable',
            'id_liver_cause' => 'nullable',
            'liver_quantity' => 'nullable',
            'id_lungs_cause' => 'nullable',
            'lungs_quantity' => 'nullable',
            'id_legs_cause' => 'nullable',
            'legs_quantity' => 'nullable',
            'id_hands_cause' => 'nullable',
            'hands_quantity' => 'nullable',
            'id_udder_cause' => 'nullable',
            'udder_quantity' => 'nullable',
            'id_kidney_cause' => 'nullable',
            'kidney_quantity' => 'nullable',
            'id_heart_cause' => 'nullable',
            'heart_quantity' => 'nullable',
            'id_booklet_cause' => 'nullable',
            'booklet_quantity' => 'nullable',
            'id_white_viscera_cause' => 'nullable',
            'white_viscera_quantity' => 'nullable',
            'id_red_viscera_cause' => 'nullable',
            'red_viscera_quantity' => 'nullable',
            'id_destocking_cause' => 'nullable',
            'destocking_quantity' => 'nullable',
            'id_canal_cause' => 'nullable',
            'canal_quantity' => 'nullable',
            'other_organ' => 'nullable',
            'id_other_cause' => 'nullable',
            'other_quantity' => 'nullable',
            'insp_ganglions' => 'nullable',
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
