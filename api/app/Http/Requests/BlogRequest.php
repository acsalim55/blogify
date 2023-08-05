<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'POST' => [
                'title' => 'required',
                'content' => 'required',
                'user_id' => 'required'
            ],
            'PUT' => [
                '_id' => ['required', 'string', 'exists:mongodb.blogs,_id']
            ],
            'DELETE' => [
                '_id' => ['required', 'string', 'exists:mongodb.blogs,_id']
            ]
        ][$this->getMethod()];
    }
}
