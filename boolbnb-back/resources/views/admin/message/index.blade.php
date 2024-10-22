@extends('admin.index')

@section('user')
    @if (session('delete'))
        <div class="alert alert-danger mx-auto">
            {{ session('delete') }}
        </div>
    @endif
    <div class="container-fluid overflow-auto">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Indirizzo Mittente</th>
                    <th scope="col">Nome Mittente</th>
                    <th scope="col">Appartamento id</th>
                    <th scope="col">Testo</th>
                    <th scope="col">Data</th>
                    <th scope="col">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>

                        <td>{{ $message['email'] }}</td>
                        <td>{{ $message['name'] }}</td>
                        <td>{{ $message['apartment_id'] }}</td>
                        <td>{{ $message['message'] }}</td>
                        <td>{{ date('d-m-Y' , strtotime($message['created_at'])) }}</td>


                        <td>
                            <form action="{{ route('admin.message.destroy', $message['id']) }}" method="POST"
                                onsubmit="return confirm('Sei sicuro di voler cancellare il messaggio di {{ $message['name'] }} ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="text-light fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
