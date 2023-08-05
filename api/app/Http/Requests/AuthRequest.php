<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'POST' => [
                'register' => [
                    'name' => 'required',
                    "surname" => 'required',
                    'email' => ['required', 'email', 'unique:users,email'],
                    'username' => ['required', 'unique:users,username'],
                    'password' => 'required'
                ],
                'login' => [
                    'email' => 'required',
                    'password' => 'required'
                ],
                'logout' => [

                ]
            ][basename($this->route()->uri)],
            'PUT' => [],
            'DELETE' => []
        ][$this->getMethod()];
    }
}
