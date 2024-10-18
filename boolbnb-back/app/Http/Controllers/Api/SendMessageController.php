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
        //
        $success = true;
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                //name da eliminare?
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'message' => 'required|string|min:10|max:2000',
                'slug' => 'required|string|exists:apartments,slug',
            ],
            [
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

        $related_apartment = Apartment::where('slug', $request['slug'])->firstOrFail();

        $message = new Message();

        //name da eliminare?
        $message->name = $request['email'];
        $message->email = $request['email'];
        $message->message = $request['message'];
        $message->apartment_id = $related_apartment->id;

        $message->save();

        return response()->json(compact('success', 'data'));
    }
}
