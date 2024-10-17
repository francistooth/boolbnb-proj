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
            'room' => 'required|numeric|min:1|max:250',
            'bed' => 'required|numeric|min:1|max:250',
            'bathroom' => 'required|numeric|min:1|max:250',
            'sqm' => 'required|numeric|min:10|max:50000',
            'img_path' => 'nullable',
            'img_name' => 'nullable',
            'services' => 'required',
            /*  'address' => 'required' string, */
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.string' => 'Il titolo deve essere una stringa.',
            'title.max' => 'Il titolo non può superare i :max caratteri.',

            'description.required' => 'La descrizione è obbligatoria.',
            'description.string' => 'La descrizione deve essere un testo valido.',

            'room.required' => 'Il numero di stanze è obbligatorio.',
            'room.integer' => 'Il numero di stanze deve essere un numero intero.',
            'room.min' => 'Il numero di stanze deve essere almeno :min',
            'room.max' => 'Il numero delle stanze non può superare le :max',

            'bed.required' => 'Il numero di letti è obbligatorio.',
            'bed.integer' => 'Il numero di letti deve essere un numero intero.',
            'bed.min' => 'Il numero di letti deve essere almeno :min',
            'bed.max' => 'Il numero dei letti non può superare i :max',

            'bathroom.required' => 'Il numero di bagni è obbligatorio.',
            'bathroom.integer' => 'Il numero di bagni deve essere un numero intero.',
            'bathroom.min' => 'Il numero di bagni deve essere almeno :min',
            'bathroom.max' => 'Il numero dei bagni non può superare i :max',

            'sqm.required' => 'La superficie è obbligatoria.',
            'sqm.integer' => 'La superficie deve essere un numero intero.',
            'sqm.min' => 'La superficie deve essere almeno :min metri quadrati.',
            'sqm.max' => 'La superficie può essere massimo di :max metri quadrati.',

            /* 'address.required' => "L'indirizzo è obbligatorio.",
             'address.string' => "L'indirizzo deve essere una stringa valida.", */

            'img_path.string' => 'Il percorso dell\'immagine deve essere una stringa valida.',
            'img_name.string' => 'Il nome dell\'immagine deve essere una stringa valida.',

            'services.required' => 'I servizi sono obbligatori.'
        ];
    }
}
