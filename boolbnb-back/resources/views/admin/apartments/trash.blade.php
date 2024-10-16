@extends('layouts.app')

@section('content')
    <div class="container-fluid overflow-auto">
        <table id="Dash" class="table ">
            <thead>
                <tr>
                    <th scope="col">#id
                    </th>

                    <th scope="col">
                        Titolo</th>
                    <th scope="col">
                        Indirizzo
                    </th>
                    <th scope="col">
                        Immagine
                    </th>
                    <th scope="col">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>

                        <td>{{ $apartment['id'] }}</td>
                        <td>{{ $apartment['title'] }}</td>
                        <td>{{ $apartment['address'] }}</td>
                        <td> <img src="{{ asset('storage/' . $apartment->img_path) }}" alt="{{ $apartment->img_name }}"
                                class="img-thumbnail w-25" onerror="this.src='/img/default-image.jpg'"></td>

                        <td>
                            <form class="d-inline" action="{{ route('admin.apartments.restore', $apartment->id) }}"
                                method="post"
                                onsubmit="return confirm('sei sicuro di voler ripristinare {{ $apartment['title'] }}')">
                                @csrf
                                @method('patch')
                                <button class="btn btn-success" type="submit" title='Ripristina'><i
                                        class="fa-solid fa-rotate-left"></i>
                                </button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.apartments.delete', $apartment->id) }}"
                                method="post"
                                onsubmit="return confirm('sei sicuro di voler eliminare definitivamente {{ $apartment['title'] }}')">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit" title='Cancella'><i
                                        class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
