<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $apartment_id = $request->get('apartment');
        $messages = Message::all()->where('apartment_id', $apartment_id);

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
        /*
        Sistemare il form di destrou delle email nelllo show degli appartamenti  bisogno passare anche il parametro apartamento id */
        $message->delete();
        return redirect()->route('admin.apartments.show')->with('delete', 'Il messaggio da ' . $message['email'] . ' è stato cancellato correttamente');
    }
}
