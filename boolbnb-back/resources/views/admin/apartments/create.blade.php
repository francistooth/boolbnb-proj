@extends('admin.index')

@section('user')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-4">

        <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h2 class="text-secondary my-4">Inserisci appartamento</h2>

        <div class="mt-4">

            <form id="apartmentForm" method="POST" action="{{ route('admin.apartments.store') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="title">Titolo: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('title') }}" type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror" required>

                    @error('title')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Descrizione: <strong class="text-danger">*</strong></label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>

                    @error('description')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-md-flex justify-content-between gap-4">
                    <div class="form-group mb-3">
                        <label for="room">Numero stanze: <strong class="text-danger">*</strong></label>
                        <input value="{{ old('room') }}" type="number" id="room" name="room"
                            class="form-control @error('room') is-invalid @enderror" required min="1" max="250"
                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                        @error('room')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="bathroom">Numero di bagni: <strong class="text-danger">*</strong></label>
                        <input value="{{ old('bathroom') }}" type="number" id="bathroom" name="bathroom"
                            class="form-control @error('bathroom') is-invalid @enderror" required min="1"
                            max="250"
                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                        @error('bathroom')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="bed">Numero di letti: <strong class="text-danger">*</strong></label>
                        <input value="{{ old('bed') }}" type="number" id="bed" name="bed"
                            class="form-control @error('bed') is-invalid @enderror" required min="1" max="250"
                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                        @error('bed')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="sqm">Metri quadrati: <strong class="text-danger">*</strong></label>
                        <input value="{{ old('sqm') }}" type="number" id="sqm" name="sqm"
                            class="form-control @error('sqm') is-invalid @enderror" required min="1" max="50000"
                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                        @error('sqm')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- input address con logica JS --}}
                @include('admin._partials.apiAddress', ['old' => old('address')])

                <div class="mb-3">
                    <label for="services" class="form-label d-block">Servizi disponibili: <strong
                            class="text-danger">*</strong></label>
                    <div class="d-flex justify-content-center flex-wrap gap-2" style="width: 90%; margin: 0 auto;">
                        @foreach ($services as $service)
                            <input value="{{ $service->id }}" name="services[]" type="checkbox" class="btn-check"
                                id="service-{{ $service->id }}" autocomplete="off"
                                @if (in_array($service->id, old('services', []))) checked @endif>
                            <label class="btn btn-outline-warning"
                                for="service-{{ $service->id }}">{{ $service->name }}</label>
                        @endforeach
                    </div>

                    @error('services')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group mb-3">
                    <label for="img_path">Immagine:</label>
                    <input type="file" id="img_path" name="img_path" class="form-control mb-4"
                        onchange="Preview(event)">
                    <img value='{{ old('img_path') }}' src="\img\default-image.jpg" id="thumb"
                        class="img-thumbnail w-25 mt-2">
                    @error('img_path')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_visible" value="0">
                        <input name="is_visible" class="form-check-input" type="checkbox" role="switch" value="1"
                            id="is_visible" checked>
                        <label class="form-check-label" for="is_visible">Appartamento visibile al pubblico</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Conferma</button>
                <a type="reset" href="{{ route('admin.apartments.index') }}" class="btn btn-danger">Annulla</a>

            </form>
        </div>
    </div>

    <script>
        function Preview(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
