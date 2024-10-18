<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'La mail dell\'utente è obbligatoria.',
            'email.email' => 'La mail inviata non è del formato corretto',

            'message.required' => 'Il messaggio è un campo obbligatorio.',
            'message.string' => 'Il messaggio inviato non è una stringa.',
            'message.max' => 'Il messaggio inviato può contenere massimo :max caratteri.',
        ];
    }
}
