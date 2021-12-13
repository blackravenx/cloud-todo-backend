<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|email:rfc|unique:users',
            'password' => 'required|string|min:6',
            'name' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email обязательное поле',
            'email.unique' => 'Пользователь с таким email уже существует',
            'email.email' => 'Email должен соответствовать шаблону example@site.com',
            'password.required' => 'Пароль обязательное поле',
            'password.min' => 'Пароль должен быть не менее 6 символов',
            'name.required' => 'Пароль обязательное поле',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(['message'=>$validator->errors()->messages()],422));
    }
}
