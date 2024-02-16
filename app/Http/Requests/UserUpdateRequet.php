<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class UserUpdateRequet extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombres' => 'required',
            'apellidos' => 'required',
            'cedula' => 'required|numeric',
            'correo' => 'required|email',
            'telefono' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El :attribute es obligatorio.',
            'apellidos.required' => 'El :attribute es obligatorio.',
            'cedula.required' => 'El :attribute es obligatorio.',
            'cedula.numeric' => 'El :attribute debe ser un campo númerico',
            'correo.required' => 'El :attribute es obligatorio.',
            'correo.email' => 'El :attribute no es válido',
            'telefono.required' => 'El :attribute es obligatorio.',
            'telefono.numeric' => 'El :attribute debe ser un campo númerico',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors
            ],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
