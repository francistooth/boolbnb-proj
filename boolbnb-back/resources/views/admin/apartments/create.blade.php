@extends('layouts.app')

@section('content')
  <div class="container">

    <h2> Inserisci appartamento</h2>
    <h6> Proprietario: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-4">

      <form class="d-flex flex-column gap-4" method="POST" action="{{ route('admin.apartments.store') }}">
        @csrf

        <div class="form-group">
          <label for="title">Title:</label>
          <input
            type="text"
            id="title"
            name="title"
            class="form-control"
            required>
        </div>

        <div class="form-group">
          <label for="description">Description:</label>
          <textarea
            id="description"
            name="description"
            class="form-control"
            required></textarea>
        </div>

        <div class="form-group">
          <label for="room">Number of Rooms:</label>
          <input
            type="number"
            id="room"
            name="room"
            class="form-control"
            required>
        </div>

        <div class="form-group">
          <label for="bathroom">Number of Bathrooms:</label>
          <input
            type="number"
            id="bathroom"
            name="bathroom"
            class="form-control"
            required>
        </div>

        <div class="form-group">
          <label for="sqm">Square Meters:</label>
          <input
            type="number"
            id="sqm"
            name="sqm"
            class="form-control"
            required>
        </div>

        <div class="form-group">
          <label for="address">Address:</label>
          <input
            type="text"
            id="address"
            name="address"
            class="form-control"
            required>
        </div>

        <div class="form-group">
          <label for="img_path">Image:</label>
          <input
            type="file"
            id="img_path"
            name="img_path"
            class="form-control mb-4"
            required>
        </div>

        <button type="submit" class="btn btn-primary">Crea Appartamento</button>
      </form>
    </div>
  </div>
@endsection