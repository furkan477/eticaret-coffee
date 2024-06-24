<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class İnvoiceRequest extends FormRequest
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
            'country' => 'required|string',
            'name' => 'required|string|min:3',
            'company_name' => 'required|string',
            'address' => 'required',
            'city' => 'required|string',
            'district' => 'required|string',
            'posta_zip' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'note' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Başlık Alanı Boş Bırakılamaz',
            'name.string' => 'Başlık Alanı Sayı İçeremez',
            'name.min' => 'Başlık Alanına En Az 3 Harf Girilmelidir',
            'email.required' => 'E-Posta Zorunlu Bir Alandır',
            'email.email' => 'E-Posta @gmail li Alandır',
            'company_name.required' => 'Şirket Adı Zorunlu Bir Alandır',
            'company_name.string' => 'Şirket Adı Sayı İçeremez',
            'address.required' => 'Adres Zorunlu Bir Alandır',
            'city.required' => 'Şehir Zorunlu Bir Alandır',
            'city.string' => 'Şehir Alanı Sayı İçeremez',
            'country.required' => 'Ülke Zorunlu Bir Alandır',
            'country.string' => 'Ülke Alanı Sayı İçeremez',
            'district.required' => 'İlçe Zorunlu Bir Alandır',
            'district.string' => 'İlçe Alanı Sayı İçeremez',
            'posta_zip.required' => 'Posta Kodu Zorunlu Bir Alandır',
            'phone.required' => 'Telefon Zorunlu Bir Alandır',
            'note.nullable' => 'Not Zorunlu Değildir',
        ];
    }
}
