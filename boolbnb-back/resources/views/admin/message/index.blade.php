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
            </tbody>
        </table>
    </div>
@endsection
