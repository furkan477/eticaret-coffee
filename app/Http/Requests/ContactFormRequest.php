<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'email' => 'required|email|min:5',
            'subject' => 'required',
            'message' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim Alanı Boş Bırakılamaz',
            'name.string' => 'İsim Alanı Sayı İçeremez',
            'name.required' => 'İsim Alanına En Az 3 Harf Girilmelidir',
            'email.required' => 'Email Alanı Boş Bırakılamaz',
            'email.email' => 'Email Alanına Geçerli E-mail Giriniz',
            'email.required' => 'Email Alanına En Az 5 Harf Girilmelidir',
            'subject.required' => 'Konu Alanı Boş Bırakılamaz',
            'message.required' => 'Mesaj Alanı Boş Bırakılamaz',
        ];
    }
}
