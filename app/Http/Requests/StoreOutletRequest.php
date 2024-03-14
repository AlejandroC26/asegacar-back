<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreOutletRequest extends FormRequest
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
            'code' => Rule::unique('outlets')
                ->where(function ($query) {$query->where('code', $this->code);})
                ->ignore($this->route('outlet')),
            'customer' => 'max:255',
            'primary_phone' => 'max:255',
            'secondary_phone' => 'max:255',
            'establishment_name' => 'required',
            'establishment_address' => 'max:255',
            'id_city' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'El código debe ser único en los expendios',
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
