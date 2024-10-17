@extends('layouts.app')

@section('content')
    @foreach ($sponsors as $sponsor)
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $sponsor->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $sponsor->price }}</h6>
                <p class="card-text">{{ $sponsor->duration }}</p>
                <a href="#" class="card-link">Acquista</a>

            </div>
        </div>
    @endforeach
@endsection
