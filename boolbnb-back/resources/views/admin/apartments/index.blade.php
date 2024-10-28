@extends('admin.index')

@section('user')
    <div class="container d-flex justify-content-between align-items-center gap-2 mt-4">
        <h2 class="text-secondary"> Appartamenti di {{ Auth::user()->name }} {{ Auth::user()->surname }} </h2>
        <div>
            <a class="btn btn-secondary" href="{{ route('admin.apartments.create') }}">
                <span class="d-none d-md-block">Aggiungi appartamento</span>
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="container">
        @if (session('delete'))
            <div class="alert alert-danger d-block">
                {{ session('delete') }}
            </div>
        @endif

        @if ($apartments->isEmpty())
            <div class="alert alert-dark text-center mt-5">
                Nessun appartamento aggiunto.
            </div>
        @else
            <div class="table-responsive mt-5 overflow-x-hidden">
                <table class="table rounded backtable">
                    <thead>
                        <tr>
                            <th scope="col"> Immagine </th>
                            <th scope="col"> Titolo </th>
                            <th scope="col" class="d-none d-md-table-cell"> Sponsorizzato </th>
                            <th scope="col" class="d-none d-md-table-cell"> Visibile </th>
                            <th scope="col"> Azioni </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $apartment)
                            <!-- modale -->
                            <div class="modal fade" id="deleteModal-{{ $apartment->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000">
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annulla</button>

                                            <!-- form eliminazione -->
                                            <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Conferma</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <tr>
                                <td class="w-10">
                                    <a href="{{ route('admin.apartments.show', $apartment) }}">
                                        <img class="max-h-100 rounded img-apartment"
                                            src="{{ asset('storage/' . $apartment->img_path) }}"
                                            alt="{{ $apartment->img_name }}" onerror="this.src='/img/default-image.jpg'">
                                    </a>
                                </td>
                                <td> {{ $apartment->title }} </td>

                                <td class="d-none d-md-table-cell">
                                    {{ $sponsored_apartments[$apartment->id] ? 'Fino al ' . \Carbon\Carbon::parse($sponsored_apartments[$apartment->id])->format('d/m/Y') : 'Nessuna sponsorizzazione' }}
                                </td>

                                <td class="d-none d-md-table-cell"> {{ $apartment->is_visible ? 'Si' : 'No' }} </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
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
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
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
@endsection
