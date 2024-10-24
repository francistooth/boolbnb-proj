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
    public function index()
    {
        $messages = Message::with('apartment')
            ->whereHas('apartment', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($message) {
                return [
                    'received' => $message,
                    'apartment_name' => $message->apartment->title,
                ];
            });

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
