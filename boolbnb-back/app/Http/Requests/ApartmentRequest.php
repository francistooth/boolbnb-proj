<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'room' => 'required|integer|min:1',
            'bed' => 'required|integer|min:1',
            'bathroom' => 'required|integer|min:1',
            'sqm' => 'required|integer|min:10',
            'address' => 'required|string',
            'img_path' => 'nullable|string',
            'img_name' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.string' => 'Il titolo deve essere una stringa.',
            'title.max' => 'Il titolo non può superare i 100 caratteri.',

            'description.required' => 'La descrizione è obbligatoria.',
            'description.string' => 'La descrizione deve essere un testo valido.',

            'room.required' => 'Il numero di stanze è obbligatorio.',
            'room.integer' => 'Il numero di stanze deve essere un numero intero.',
            'room.min' => 'Il numero di stanze deve essere almeno 1.',

            'bed.required' => 'Il numero di letti è obbligatorio.',
            'bed.integer' => 'Il numero di letti deve essere un numero intero.',
            'bed.min' => 'Il numero di letti deve essere almeno 1.',

            'bathroom.required' => 'Il numero di bagni è obbligatorio.',
            'bathroom.integer' => 'Il numero di bagni deve essere un numero intero.',
            'bathroom.min' => 'Il numero di bagni deve essere almeno 1.',

            'sqm.required' => 'La superficie è obbligatoria.',
            'sqm.integer' => 'La superficie deve essere un numero intero.',
            'sqm.min' => 'La superficie deve essere almeno 10 metri quadrati.',

            'address.required' => "L'indirizzo è obbligatorio.",
            'address.string' => "L'indirizzo deve essere una stringa valida.",

            'img_path.string' => 'Il percorso dell\'immagine deve essere una stringa valida.',
            'img_name.string' => 'Il nome dell\'immagine deve essere una stringa valida.',
        ];
    }
}
