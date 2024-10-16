@extends('layouts.app')

@section('content')
  <div class="container">
    
    <h6> Proprietario: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6>

    <div class="d-flex justify-content-between align-items-center mt-4">
      <h2>Show dell'appartamento</h2>

      <h2> $new_apartment->title </h2>
      <div class="picture"></div>
      <p> $new_apartment->description </p>
      <div class="d-flex flex-column">
        <h3> caratteristiche appartamento </h3>
        <span> $new_apartment->room </span>
        <span>$new_apartment->bed</span>
        <span>$new_apartment->bathroom</span>
        <span>$new_apartment->sqm</span>
      </div>

      <h4>
        Servizi
      </h4>

      <span>
        Service_id
      </span>

      <h4> Adress </h4>
      <span class="text-secondary">
        $new_apartment->address
      </span> 

      <span class="text-secondary">
        $new_apartment->coordinate_long_lat
      </span> 

      <button class="btn btn-success">
        $new_apartment->is_visible
      </button>
      
      {{-- .picture{
        width: 400px;
        height: 200px;
        background-color: yellow;
        border: black 2px solid
      } --}}
    </div>

@endsection