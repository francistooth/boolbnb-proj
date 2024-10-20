@extends('admin.index')

@section('user')
    <div class="card ms-5 w-25">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">{{ $user->email }}</li>
            @if ($user->name)
                <li class="list-group-item">{{ $user->name }}</li>
            @endif
            @if ($user->surname)
                <li class="list-group-item">{{ $user->surname }}</li>
            @endif
            @if ($user->date_birth)
                <li class="list-group-item">{{ $user->date_birth }}</li>
            @endif
        </ul>
    </div>
@endsection
