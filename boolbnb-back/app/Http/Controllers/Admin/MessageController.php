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

    public function messagesForApartment(string $id)
    {

        $apartment = Apartment::where('id', $id)->first();

        if ($apartment->user_id !== Auth::id()) {
            abort(404);
        }

        $messages = Message::with('apartment')
            ->where('apartment_id', $id)
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

        return view('admin.message.messagesApartment', compact('messages', 'apartment'));
    }

    public function destroy(Message $message)
    {

        $user_id = $message->apartment->user_id;

        $message->delete();
        return redirect()->route('admin.message.index',  ['user' => $user_id])->with('delete', 'Il messaggio da ' . $message['email'] . ' è stato cancellato correttamente');
    }
}
