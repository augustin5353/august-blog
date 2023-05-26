<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string', 'min:5', 'max:200'],
            'content' => ['required','string', 'min:180'],
            'image' => ['image', 'nullable'],
            'category' => ['required','exists:categories,id'],
            'tags' => ['required'],
        ];
    }
}
