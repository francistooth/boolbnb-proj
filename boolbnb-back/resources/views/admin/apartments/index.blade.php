@extends('admin.index')

@section('user')
    <div class="container d-flex justify-content-between align-items-center mt-4">
        <h2 class="text-primary"> Appartamenti di {{ Auth::user()->name }} {{ Auth::user()->surname }} </h2>
        <div>
            <a class="btn btn-success" href="{{ route('admin.apartments.create') }}"> Aggiungi un appartamento <i
                    class="fa-solid fa-plus"> </i></a>
        </div>
    </div>
    <div class="container">
        @if (session('delete'))
            <div class="alert alert-danger d-block">
                {{ session('delete') }}
            </div>
        @endif

        <div class="table-responsive mt-5">
            <table class="table rounded backtable">
                <thead>
                    <tr>
                        <th scope="col"> Immagine </th>
                        <th scope="col"> Titolo </th>
                        <th scope="col"> Sponsorizzato </th>
                        <th scope="col"> Visibile </th>
                        <th scope="col"> Azioni </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr class="">
                            <td class="w-25">
                                <a href="{{ route('admin.apartments.show', $apartment) }}">
                                    <img class="w-50 rounded" src="{{ asset('storage/' . $apartment->img_path) }}"
                                        alt="{{ $apartment->img_name }}" onerror="this.src='/img/default-image.jpg'">
                                </a>
                            </td>
                            <td class=""> {{ $apartment->title }} </td>
                            <td> {{ $apartment->sponsors->count() }} </td>
                            <td> {{ $apartment->is_visible ? 'Si' : 'No' }} </td>
                            <td class="w-10">
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <a class="btn btn-warning text-light"
                                        href="{{ route('admin.apartments.edit', $apartment) }}">
                                        <i class="fa-solid fa-pen">
                                        </i>
                                    </a>
                                    <button class="btn btn-secondary"><a href="{{ route('admin.sponsor.index') }}"><i
                                                class="fa-solid fa-sack-dollar"></i></a></button>
                                    <form class="d-flex align-items-center border-0 m-2 w-25"
                                        action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                                        onsubmit="return confirm('sei sicuro di voler cancellare {{ $apartment['title'] }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded z-3"> <i
                                                class="text-light fa-solid fa-trash"> </i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @empty($apartments)
                        <li> You own no apartments. </li>
                    @endempty
                </tbody>
            </table>
        </div>

    </div>
@endsection
