<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Başlık Alanı Boş Bırakılamaz',
            'name.string' => 'Başlık Alanı Sayı İçeremez',
            'name.required' => 'Başlık Alanına En Az 3 Harf Girilmelidir',
            'content.required' => 'İçerik Alanı Boş Bırakılamaz',
        ];
    }
}
