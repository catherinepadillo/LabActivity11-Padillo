<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->author()->exists() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'min:20'],
            'category' => [
                'required',
                Rule::in([
                    'Announcement',
                    'Health',
                    'Peace & Order',
                    'Ayuda',
                    'Events',
                ]),
            ],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['exists:tags,id'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
