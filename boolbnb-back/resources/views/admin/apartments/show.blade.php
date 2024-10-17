@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('delete'))
            <div class="alert alert-danger mx-auto">
                {{ session('delete') }}
            </div>
        @endif
        @if (session('update'))
            <div class="alert alert-success mx-auto">
                {{ session('update') }}
            </div>
        @endif
        <h6> Proprietario degli appartamenti: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6>
        <h2>Show dell'appartamento</h2>
        <div class="d-flex flex-wrap mt-4">
            <div class="card " style="width: 18rem;">
                {{-- Immagine/i appartamento --}}
                <div class="picture">
                    <img src="{{ asset('storage/' . $apartment->img_path) }}" class="img-thumbnail"
                        onerror="this.src='/img/default-image.jpg'">
                </div>
                <div class="card-body">
                    {{-- Nome appartamento --}}
                    <h5 class="card-title">
                        {{ $apartment->title }}
                    </h5>
                    {{-- Descrizione appartamento --}}
                    <p class="card-text">
                    <p> {{ $apartment->description }} </p>
                    </p>
                    {{-- Caratteristiche dell'appartamento --}}
                    <div class="card-text d-flex flex-column">
                        <h5> Caratteristiche appartamento </h5>
                        <span> Numero Stanze : {{ $apartment->room }} </span>
                        <span>Numeri Letti :{{ $apartment->bed }}</span>
                        <span>Numero Bagni: {{ $apartment->bathroom }}</span>
                        <span>Grandezza: {{ $apartment->sqm }} m²</span>
                    </div>
                    {{-- Servizi Appartamento --}}
                    <div class="card-text d-flex flex-column">
                        <h5>Servizi : </h5>
                        @foreach ($apartment->services as $service)
                            <span>
                                {{ $service->name }}
                            </span>
                        @endforeach
                    </div>
                    {{-- Indirizzo appartamento --}}
                    <div class="card-text d-flex flex-column">
                        <h4> Indirizzo : </h4>
                        <span class="text-secondary">
                            {{ $apartment->address }}
                        </span>
                    </div>
                    {{-- Visibilità --}}
                    <div>
                        <h4>Visibilità</h4>
                        <button class="btn btn-success">
                            @if ($apartment->is_visible)
                                Si
                            @else
                                No
                            @endif
                        </button>
                        <button class="btn btn-warning text-white"><a
                                href="{{ route('admin.message.index', ['apartment' => $apartment->id]) }}"><i
                                    class="fa-regular fa-envelope"></i></a> </button>
                    </div>
                    <ul>
                        <li>Messaggi</li>
                        @foreach ($apartment->messages as $message)
                            <li>{{ $message->id }} {{ $message->message }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
