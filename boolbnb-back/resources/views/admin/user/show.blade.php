@extends('admin.index')

@section('user')

    {{-- il contenuto della card non è responsive va sistemato --}}
    <div class="container">
        <div class="card" style="width:30rem;">
          <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted ">Email:  <span class="text-secondary">{{ $user->email }}</span> </h6>
            @if ($user->name || $user->surname)
                @if ($user->name)
                    <h6 class="card-subtitle mb-2 text-muted ">Nome:  <span class="text-secondary">{{ $user->name }}</span></h6>
                @endif
                @if ($user->surname)
                    <h6 class="card-subtitle mb-2 text-muted ">Cognome:  <span class="text-secondary">{{ $user->surname }}</span> </h6>
                @endif
            @endif
            @if ($user->date_birth)
                <h6 class="card-subtitle mb-2 text-muted ">Data di Nascita:  <span class="text-secondary">{{ $user->date_birth }}</span> </h6>
            @endif
          </div>
        </div>
    </div>
@endsection