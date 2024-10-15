<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['string', 'max:50'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:' . User::class],
                'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
                'surname' => ['string', 'max:50'],
                'date_birth' => ['date', 'date_format:d/m/Y']
            ],

            [
                'name.string' => 'Il campo nome deve essere una stringa',
                'name.max' => 'Il campo nome può contenere massimo :max caratteri',

                'email.required' => 'Il campo email è obbligatorio',
                'email.string' => 'Il campo email deve essere una stringa',
                'email.lowercase' => 'Il campo email deve contenere caratteri minuscoli',
                'email.email' => 'Il campo email deve essere una email valida',
                'email.max' => 'Il campo email può contenere massimo :max caratteri',
                'email.unique' => 'La email inserita è già stata utilizzata',

                'password.required' => 'Il campo password è obbligatorio',
                'password.confirmed' => 'Le password devono combaciare',
                'password.min' => 'Il campo password deve contenere almeno :min caratteri',

                'surname.string' => 'Il campo cognome deve essere una stringa',
                'surname.max' => 'Il campo cognome può contenere massimo :max caratteri',

                'date_birth.date' => 'Il campo Data di Nascita deve essere una data',
                'date_birth.date_format' => 'Il campo Data di Nascita deve essere del seguente formato GG/MM/AAAA',
            ]

        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'surname' => $request->surname,
            'date_birth' => date("Y-m-d", strtotime($request->date_birth)),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
