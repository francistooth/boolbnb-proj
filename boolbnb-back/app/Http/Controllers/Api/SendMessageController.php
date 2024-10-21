<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Apartment;
use App\Models\Message;

class SendMessageController extends Controller
{
    public function store(Request $request)
    {
        $success = true;
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name' => 'required|string|max:100|min:3',
                'email' => 'required|email|max:100',
                'message' => 'required|string|min:10|max:2000',
                'slug' => 'required|string|exists:apartments,slug',
            ],
            [
                'name.required' => 'Il campo nome è obbligatorio',
                'name.string' => 'Il campo nome deve essere una stringa',
                'name.max' => 'Il campo nome può contenere al massimo :max caratteri',
                'name.min' => 'Il campo nome deve contenere almeno :min caratteri',

                'email.required' => 'Il campo email è obbligatorio',
                'email.email' => 'Il campo email deve essere un indirizzo email valido',
                'email.max' => 'Il campo email può contenere al massimo :max caratteri',

                'message.required' => 'Il campo messaggio è obbligatorio',
                'message.string' => 'Il campo messaggio deve essere una stringa',
                'message.min' => 'Il campo messaggio deve contenere almeno :min caratteri',
                'message.max' => 'Il campo messaggio può contenere massimo :max caratteri',

                'slug.required' => 'Non è stato specificato l\'appartamento a cui vuoi inviare il messaggio',
                'slug.string' => 'L\'appartamento specificato non è del formato richiesto',
                'slug.exists' => 'L\'appartamento specificato non è in database',
            ]

        );

        if ($validator->fails()) {
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }

        $related_apartment = Apartment::where('slug', $request['slug'])->first();

        $data['apartment_id'] = $related_apartment['id'];

        Message::create($data);

        //data è per debug
        return response()->json(compact('success', 'data'));
    }
}
