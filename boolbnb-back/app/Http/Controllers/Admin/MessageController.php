<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartment_id = $request->get('apartment');
        if ($apartment_id) {
            $messages = Message::where('apartment_id', $apartment_id)->get();
        } else {
            $apartments = Apartment::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            $messages = [];
            foreach ($apartments as $apartment) {
                $messages_apartmet = Message::where('apartment_id', $apartment->id)->orderBy('apartment_id')->get();
                $messages = array_merge($messages, $messages_apartmet->toArray());
            }
        }
        dump($messages);
        return view('admin.message.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $success = true;
        // $data = $request->all();

        // $validator = Validator::make(
        //     $data,
        //     [
        //         'email' => 'required|email|max:100',
        //         'message' => 'required|string|min:10|max:2000',
        //         'slug' => 'required|string|exists:apartments,slug',
        //     ],
        //     [
        //         'name.required' => 'Il campo nome è obbligatorio',
        //         'name.string' => 'Il campo nome deve essere una stringa',
        //         'name.max' => 'Il campo nome può contenere al massimo :max caratteri',

        //         'email.required' => 'Il campo email è obbligatorio',
        //         'email.email' => 'Il campo email deve essere un indirizzo email valido',
        //         'email.max' => 'Il campo email può contenere al massimo :max caratteri',

        //         'message.required' => 'Il campo messaggio è obbligatorio',
        //         'message.string' => 'Il campo messaggio deve essere una stringa',
        //         'message.min' => 'Il campo messaggio deve contenere almeno :min caratteri',
        //         'message.max' => 'Il campo messaggio può contenere massimo :max caratteri',

        //         'slug.required' => 'Non è stato specificato l\'appartamento a cui vuoi inviare il messaggio',
        //         'slug.string' => 'L\'appartamento specificato non è del formato richiesto',
        //         'slug.exists' => 'L\'appartamento specificato non è in database',
        //     ]

        // );

        // if ($validator->fails()) {
        //     $success = false;
        //     $errors = $validator->errors();
        //     return response()->json(compact('success', 'errors'));
        // }

        // $related_apartment = Apartment::where('slug', $request['slug'])->firstOrFail();

        // $message = new Message();

        // $message->email = $request['email'];
        // $message->message = $request['message'];
        // $message->apartment_id = $related_apartment->id;

        // $message->save();

        return response()->json(compact('success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {

        $user_id = $message->apartment->user_id;

        $message->delete();
        return redirect()->route('admin.message.index',  ['user' => $user_id])->with('delete', 'Il messaggio da ' . $message['email'] . ' è stato cancellato correttamente');
    }
}
