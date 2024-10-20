@extends('admin.index')

@section('user')

    {{-- il contenuto della card non è responsive va sistemato --}}
    <div class="containeer-fluid ">
        <div class="card border border-2 border-dark mx-auto my-5 w-25 backcard">
            <ul>
                <li class=" text-nowrap"><strong>Email:</strong> {{ $user->email }}</li>

                @if ($user->name || $user->surname)
                    <li class=" text-nowrap">
                        @if ($user->name)
                            <strong>Nome: </strong> {{ $user->name }}
                        @endif
                        @if ($user->surname)
                            <strong class="ms-2">Cognome: </strong> {{ $user->surname }}
                        @endif
                    </li>
                @endif
                @if ($user->date_birth)
                    <li class=" text-nowrap"><strong>Data di Nascita:</strong> {{ $user->date_birth }}</li>
                @endif
            </ul>
        </div>
    </div>
@endsection
