@extends ('layouts.app')

@section('content')
    <div class="container-fluid overflow-auto">
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">#id
                    </th>

                    <th scope="col">
                        Indirizzo Mittente</th>
                    <th scope="col">
                        Nome Mittente
                    </th>
                    <th scope="col">
                        Testo
                    </th>
                    <th scope="col">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td>{{ $message['id'] }}</td>
                        <td>{{ $message['email'] }}</td>
                        <td>{{ $message['name'] }}</td>
                        <td>{{ $message['message'] }}</td>
                        <td>
                            <form
                                class="btn btn-danger rounded border-0 z-3 w-25 d-flex align-items-center justify-content-center"
                                action="{{ route('admin.message.destroy', $message) }}" method="POST"
                                onsubmit="return confirm('sei sicuro di voler cancellare {{ $message->id }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn"> <i class="text-light fa-solid fa-trash">
                                    </i></button>
                            </form>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
