@extends('admin.index')

@section('user')
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

        @if (session('sponsor_success'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="sponsorToast" class="toast align-items-center text-bg-success border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('sponsor_success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- modale eliminazione -->
        <div class="modal fade" id="deleteModal-{{ $apartment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma
                            Eliminazione</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare l'appartamento "{{ $apartment->title }}"?
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <!-- form eliminazione -->
                        <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success">Conferma</button>
                        </form>

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                    </div>
                </div>
            </div>
        </div>


        <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2> Dettaglio appartamento </h2>
                {{-- <h6 class="text-secondary"> Proprietario: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6> --}}
            </div>
            <div class="alert alert-secondary text-center">
                @if ($sponsor)
                    <p>Sponsorizzato</p>
                    <button class="btn btn-success">
                        Fino al {{ \Carbon\Carbon::parse($sponsor)->format('d/m/Y') }}
                    </button>
                @else
                    <button class="btn btn-secondary">
                        Nessuna sponsorizzazione
                    </button>
                @endif
            </div>
        </div>

        <div class="mt-1 card">

            <div class="row no-gutters">
                <div class="col-sm-5">
                    <img src="{{ asset('storage/' . $apartment->img_path) }}" class="img-thumbnail"
                        onerror="this.src='/img/default-image.jpg'">
                </div>
                <div class="col-sm-7">
                    <div class="card-body">
                        {{-- Nome appartamento --}}
                        <h3 class="card-title">
                            {{ $apartment->title }}
                        </h3>

                        {{-- Descrizione appartamento --}}
                        <p class="card-text"> {{ $apartment->description }} </p>

                        {{-- Caratteristiche dell'appartamento --}}
                        <h5> Caratteristiche: </h5>
                        <div class="card-text d-flex flex-column">
                            <span> Numero Stanze : {{ $apartment->room }} </span>
                            <span>Numeri Letti :{{ $apartment->bed }}</span>
                            <span>Numero Bagni: {{ $apartment->bathroom }}</span>
                            <span>Grandezza: {{ $apartment->sqm }} m²</span>
                        </div>

                        {{-- Servizi Appartamento --}}
                        <h5 class="mt-2">Servizi: </h5>
                        <div class="card-text d-flex flex-column">
                            @foreach ($apartment->services as $service)
                                <span>
                                    {{ $service->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Indirizzo appartamento --}}
                        <h5 class="mt-2"> Indirizzo: </h5>
                        <span class="card-text">
                            {{ $apartment->address }}
                        </span>
                        <h5 class="mt-2">Visibile:
                            <span class="small">
                                @if ($apartment->is_visible)
                                    Si
                                @else
                                    No
                                @endif
                            </span>
                        </h5>
                    </div>
                    {{-- messaggi ricevuti --}}
                    <a class="btn btn-secondary text-light ms-3"
                        href="{{ route('admin.message.messagesForApartment', ['apa_id' => $apartment->id]) }}">
                        <i class="fa-regular fa-envelope"></i>

                    </a>

                    {{-- modifica appartamento --}}
                    <a class="btn btn-secondary text-light " href="{{ route('admin.apartments.edit', $apartment) }}">
                        <i class="fa-solid fa-pen">
                        </i>
                    </a>

                    <!-- bottone trigger modale eliminazione -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#deleteModal-{{ $apartment->id }}">
                        <i class="fa-solid fa-trash text-light"></i>
                    </button>

                </div>

            </div>

            <div>

                <h3 class="mt-4 text-center">Sponsorizza l'appartamento</h3>
                <div class="row justify-content-around">
                    @foreach ($sponsors as $sponsor)
                        {{-- modale per pagamento, dropin Braintree, form per pagamento --}}
                        @include('admin._partials.paymentForm')

                        <div class="card my-3 text-center" style="width: 18rem;">
                            <div class="card-body bronze">
                                <h5 class="card-title">{{ $sponsor->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $sponsor->price }} €</h6>
                                <p class="card-text">{{ $sponsor->duration }} ore</p>

                                {{-- button trigger modale --}}
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#sponsorModal-{{ $sponsor->id }}">
                                    Procedi al pagamento
                                </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @include('admin._partials.statistic')

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sponsor = document.getElementById('sponsorToast');
            if (sponsor) {
                var toast = new bootstrap.Toast(sponsor, {
                    delay: 5000
                });
                toast.show();
            }
        });
    </script>
@endsection
