<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'profile_image.image' => '画像は拡張子が.jpegもしくは.png形式でアップロードしてください',
            'profile_image.max' => '画像は2MB以内のファイルをアップロードしてください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'address.required' => '住所を入力してください',
            'building.max' => '建物名は255文字以内で入力してください',
        ];
    }
}
