<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetatraderAccount extends FormRequest
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
        // Will be modified as per further requirements
        return [
            'account_name' => 'required|string',
            'mt_version' => 'required|string',
            'mt_login' => 'required|string',
            'mt_password' => 'required|string',
            'mt_server_name' => 'required|string',
        ];
    }
}
