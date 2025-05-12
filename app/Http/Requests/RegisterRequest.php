<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:90',
            'email' => 'required|string|email|max:255|unique:users',
            'rol' => 'string|in:admin,user',
            'password' => 'required|string|min:8',
        ];
    }
     /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no debe exceder los 90 caracteres',
            'email.required' => 'El email es requerido',
            'email.string' => 'El email debe ser una cadena de texto',
            'email.email' => 'El email debe ser una dirección de correo válida',
            'email.max' => 'El email no debe exceder los 255 caracteres',
            'email.unique' => 'El email ya ha sido registrado',
            'rol.required' => 'El rol es requerido',
            'rol.string' => 'El rol debe ser una cadena de texto',
            'rol.in' => 'el rol no es permitido',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de texto',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ];

    }
    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422));
    }
}
