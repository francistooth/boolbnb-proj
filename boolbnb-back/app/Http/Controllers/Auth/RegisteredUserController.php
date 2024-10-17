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
use Illuminate\Support\Str;

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
                'name' => ['string', 'max:50', 'min:3', 'nullable', 'regex:/^[\pL\s\-]+$/u'],
                'surname' => ['string', 'max:50', 'min:3', 'nullable', 'regex:/^[\pL\s\-]+$/u'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:' . User::class],
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'max:20',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/',
                    Rules\Password::defaults()
                ],
                'year' => ['nullable', 'numeric', 'digits:4', 'min:' . (date('Y') - 100), 'max:' . (date('Y') - 18)],
                'month' => ['nullable', 'numeric', 'between:1,12'],
                'day' => ['nullable', 'numeric', 'between:1,31'],
            ],

            [
                'name.string' => 'Il campo nome deve essere una stringa',
                'name.max' => 'Il campo nome può contenere massimo :max caratteri',
                'name.regex' => 'Il nome può contenere solo lettere e spazi.',

                'surname.string' => 'Il campo cognome deve essere una stringa',
                'surname.max' => 'Il campo cognome può contenere massimo :max caratteri',
                'surname.regex' => 'Il cognome può contenere solo lettere e spazi.',

                'email.required' => 'Il campo email è obbligatorio',
                'email.string' => 'Il campo email deve essere una stringa',
                'email.lowercase' => 'Il campo email deve contenere caratteri minuscoli',
                'email.email' => 'Il campo email deve essere una email valida',
                'email.max' => 'Il campo email può contenere massimo :max caratteri',
                'email.unique' => 'La email inserita è già stata utilizzata',

                'password.required' => 'Il campo password è obbligatorio',
                'password.confirmed' => 'Le password devono combaciare',
                'password.min' => 'Il campo password deve contenere almeno :min caratteri',
                'password.max' => 'Il campo password può contenere massimo :max caratteri',
                'password.regex' => 'La password deve contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale.',

                'year.numeric' => 'L\'anno di nascita deve essere un numero.',
                'year.digits' => 'L\'anno di nascita deve essere composto da :digits cifre.',
                'year.min' => 'L\'anno di nascita non può essere inferiore a :min.',
                'year.max' => 'L\'anno di nascita non può essere superiore a :max.',

                'month.numeric' => 'Il mese di nascita deve essere un numero.',
                'month.between' => 'Il mese di nascita deve essere compreso tra 1 e 12.',

                'day.numeric' => 'Il giorno di nascita deve essere un numero.',
                'day.between' => 'Il giorno di nascita deve essere compreso tra 1 e 31.',
            ]

        );


        if ($request->name === null) {
            $request->name = Str::before($request->email, '@');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'surname' => $request->surname,
            'date_birth' => $request->date_birth
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
