@extends('layouts.app')

@section('content')

<section class="hero is-info">
  <div class="hero-body">
    <div class="container has-text-centered">
      <h1 class="title">
        Propiedades
      </h1>
      <p>
        Listado de propiedades de EasyBroker
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="columns is-multiline">
      @foreach ($properties as $property)
        <div class="column is-4">
          <x-property-card :property="$property"/>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
