<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\UserRequest as FortifyLoginRequest;

class UserRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required','min:8','same'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'confirm_password.required' => 'パスワードを入力してください',
            'confirm_password.min' => 'パスワードは8文字以上で入力してください',
            'confirm_password.same' => 'パスワードと一致しません',
        ];
    }
}
