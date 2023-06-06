<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'login' => [
                'required',
                Rule::unique('users')
                ->where(function ($query) {
                    $query->where('login',$this->login);
                })
            ],
            'id_persons' => 'required|exists:persons,id',
            'id_roles' => 'required|exists:roles,id',
            'password' => 'required',
            'status' => 'required|boolean',
            'email_verified_at' => 'date',
            'account_expire' => 'date',
            'pass_expire' => 'date'

        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'El parametro :attribute es requerido',
            'login.unique' => 'El parametro :attribute ya está regitrado',
            "id_persons.required" => "El parametro :attribute es requerido",
            "id_persons.exists" => "El parametro :attribute no existe",
            "id_roles.required" => "El parametro :attribute es requerido",
            "id_roles.exists" => "El parametro :attribute no existe",
            'password.required' => 'El parametro :attribute es requerido',
            'status.boolean' => 'El parametro :attribute no es booleano',
            'status.required' => 'El parametro :attribute es requerido',
            'email_verified_at.date' => 'El parametro :attribute debe ser una fecha valida',
            'account_expire.date' => 'El parametro :attribute debe ser una fecha valida',
            'pass_expire.date' => 'El parametro :attribute debe ser una fecha valida',

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
