@extends('admin.index')

@section('user')
    <div class="row justify-content-center">
        @foreach ($sponsors as $sponsor)
            <div class="card m-5 text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $sponsor->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $sponsor->price }}</h6>
                    <p class="card-text">{{ $sponsor->duration }}</p>
                    <a class="btn btn-secondary text-white" href="#" class="card-link">Acquista</a>
                </div>
            </div>
        @endforeach

    </div>
@endsection
