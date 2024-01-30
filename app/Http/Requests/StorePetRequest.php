<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
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
            'name' => 'required|string',
            'category' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'photos' => 'nullable|array',
            'photos.*' => 'url|ends_with:.png,.jpg'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'tags' => is_null($this->tags) ? null : explode("\r\n", $this->tags),
            'photos' => is_null($this->photos) ? null : explode("\r\n", $this->photos)
        ]);
    }
}
