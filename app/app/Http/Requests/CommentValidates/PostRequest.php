<?php

namespace App\Http\Requests\CommentValidates;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'tweet_id' => ['required', 'integer'],
            'text'     => ['required', 'string', 'max:140'],
        ];
    }
}