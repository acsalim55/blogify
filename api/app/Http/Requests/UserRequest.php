<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'POST' => [
                'name' => 'required',
                "surname" => 'required',
                'email' => ['required', 'unique:users','email'],
                'username' => ['required','unique:users,username'],
                'password' => 'required'
            ],
            'PUT' => [
                'id' => ['required', 'string', 'exists:users,id'],
                'email' => ['unique:users,email','email'],
                'username' => ['unique:users,username']
            ],
            'DELETE' => [
                'id' => ['required', 'string', 'exists:users,id']
            ]
        ][$this->getMethod()];
    }
}
