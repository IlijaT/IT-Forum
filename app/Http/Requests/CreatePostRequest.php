<?php

namespace App\Http\Requests;

use App\Reply;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{

    public function authorize()
    {
        return Gate::allows('create', new Reply());
    }


    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
}
