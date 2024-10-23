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
            <div class="alert alert-success">
                {{ session('sponsor_success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <h2 class="mt-3 text-primary"> Dettaglio appartamento </h2>
        <h6 class="text-primary"> Proprietario: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6>

        <div class="mt-5 card">

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
                    </div>

                    <div class="d-flex">
                        {{-- visibilità --}}
                        <div class="text-center ms-3 me-4">
                            @if ($apartment->is_visible)
                                <button class="btn btn-success">
                                    Visibile al pubblico
                                </button>
                            @else
                                <button class="btn btn-warning">
                                    Non visibile al pubblico
                                </button>
                            @endif
                            </button>
                        </div>

                        <div class="text-center">
                            {{-- messaggi ricevuti --}}
                            <button class="btn btn-primary"><a
                                    href="{{ route('admin.message.index', ['apartment' => $apartment->id]) }}"><i
                                        class="fa-regular fa-envelope"></i></a>
                            </button>
                        </div>
                    </div>

                </div>

                <div>

                    <h3 class="mt-4 text-center">Sponsorizza l'appartamento</h3>
                    <div class="row justify-content-around">
                        @foreach ($sponsors as $sponsor)
                            {{-- modale per pagamento, dropin Braintree, form per pagamento --}}
                            @include('admin._partials.paymentForm')

                            <div class="card my-3 text-center" style="width: 18rem;">
                                <div class="card-body">
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


            </div>
        </div>
    </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Wg4A6lB1J6LOuYxgAs5f0bb5RmXsO1Huxy5Dke++dJzD5y" crossorigin="anonymous">
    </script>


    <script src="https://js.braintreegateway.com/web/dropin/1.33.7/js/dropin.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var client_token = "{{ $clientToken }}";

            // Itera su ogni sponsor per gestire le modali
            @foreach ($sponsors as $sponsor)
                var modal = document.getElementById('sponsorModal-{{ $sponsor->id }}');
                modal.addEventListener('show.bs.modal', function() {
                    var form = document.querySelector('#payment-form-{{ $sponsor->id }}');
                    var container = document.querySelector('#dropin-container-{{ $sponsor->id }}');

                    // Inizializza Braintree dropin quando la modale si apre
                    braintree.dropin.create({
                        authorization: client_token,
                        selector: container
                    }, function(err, instance) {
                        if (err) {
                            console.error(err);
                            return;
                        }
                        form.addEventListener('submit', function(event) {
                            event.preventDefault();
                            instance.requestPaymentMethod(function(err, payload) {
                                if (err) {
                                    console.error(err);
                                    return;
                                }
                                // Aggiungi il nonce al form e invia
                                var nonceInput = document.createElement('input');
                                nonceInput.setAttribute('type', 'hidden');
                                nonceInput.setAttribute('name',
                                    'payment_method_nonce');
                                nonceInput.setAttribute('value', payload.nonce);
                                form.appendChild(nonceInput);
                                form.submit();
                            });
                        });
                    });
                });
            @endforeach
        });
    </script> --}}
@endsection
