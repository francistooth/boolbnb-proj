@extends('admin.index')

@section('user')
    <div class="container">
        @if (session('delete'))
            <div id="delete-alert" class="alert alert-danger d-block text-center">
                {{ session('delete') }}
            </div>
        @endif

        <div class="container d-flex justify-content-between align-items-center gap-2 mt-4 mb-4">
            <h2>
                @if (!$apartments->isEmpty())
                    {{ count($apartments) > 1 ? count($apartments) . ' Appartamenti:' : count($apartments) . ' Appartamento:' }}
                @endif
            </h2>
            <div>
                <a class="btn btn-secondary" href="{{ route('admin.apartments.create') }}">
                    <span class="d-none d-md-block">Aggiungi appartamento</span>
                    <i class="fa-solid fa-plus d-md-none"></i>
                </a>
            </div>
        </div>

        @if ($apartments->isEmpty())
            <div class="alert alert-dark text-center mt-5">
                Nessun appartamento aggiunto.
            </div>
        @else
            <div class="ms-2">

            </div>

            <div class="table-responsive overflow-x-hidden">
                <table class="table rounded backtable">
                    <thead>
                        <tr>
                            <th scope="col"> Immagine </th>
                            <th scope="col"> Titolo </th>
                            <th scope="col" class="d-none d-md-table-cell"> Sponsorizzato </th>
                            <th scope="col" class="d-none d-md-table-cell"> Visibile </th>
                            <th scope="col" class="d-none d-md-table-cell"> Azioni </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $apartment)
                            <!-- modale -->
                            <div class="modal fade" id="deleteModal-{{ $apartment->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma
                                                Eliminazione</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Sei sicuro di voler eliminare l'appartamento "{{ $apartment->title }}"?
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <!-- form eliminazione -->
                                            <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-success">Conferma</button>
                                            </form>

                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Annulla</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <tr>

                                <td onclick="window.location='{{ route('admin.apartments.show', $apartment) }}'"
                                    class="pointer w-10">
                                    <img class="rounded img-apartment" src="{{ asset('storage/' . $apartment->img_path) }}"
                                        alt="{{ $apartment->img_name }}" onerror="this.src='/img/default-image.jpg'">
                                </td>

                                <td onclick="window.location='{{ route('admin.apartments.show', $apartment) }}'"
                                    class="pointer">
                                    {{ $apartment->title }}
                                </td>

                                <td onclick="window.location='{{ route('admin.apartments.show', $apartment) }}'"
                                    class="d-none d-md-table-cell pointer">
                                    {{ $sponsored_apartments[$apartment->id] ? 'Fino al ' . \Carbon\Carbon::parse($sponsored_apartments[$apartment->id])->format('d/m/Y \o\r\e H:i') : 'Nessuna sponsorizzazione' }}
                                </td>

                                <td onclick="window.location='{{ route('admin.apartments.show', $apartment) }}'"
                                    class="d-none d-md-table-cell pointer"> {{ $apartment->is_visible ? 'Si' : 'No' }}
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="d-flex justify-content-center gap-2 z-3">
                                        <a class="btn btn-primary text-light"
                                            href="{{ route('admin.apartments.edit', $apartment) }}">
                                            <i class="fa-solid fa-pen">
                                            </i>
                                        </a>
                                        <a
                                            href="{{ route('admin.message.messagesForApartment', ['apa_id' => $apartment->id]) }}">
                                            <button class="btn btn-secondary text-light"><i
                                                    class="fa-regular fa-envelope"></i>
                                            </button>
                                        </a>

                                        <!-- bottone trigger modale -->
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $apartment->id }}">
                                            <i class="fa-solid fa-trash text-light"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- JS bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Wg4A6lB1J6LOuYxgAs5f0bb5RmXsO1Huxy5Dke++dJzD5y" crossorigin="anonymous">
    </script>

    <script>
        setTimeout(() => {
            document.getElementById('delete-alert').classList.add('d-none');
        }, 3000);
    </script>
@endsection
