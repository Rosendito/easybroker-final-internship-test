@extends('layouts.app')

@section('content')

@php

$placeholder = (object) [
  'url' => 'https://lh3.googleusercontent.com/proxy/ATdKAtR0gvBn6IoZXDnmiqYZQ8PWixXmM1tIfbWJ55OvxHgZ2nZZyW2y8yE_t6uJX2JJ3nzE9Qiuqx1nqI0JvixJ5GCJ5SmbQvn0OreIz0xDqtjAzmo',
  'title' => 'Placeholder image',
];
$primaryImage = count($property->property_images) > 0 ? $property->property_images[0] : $placeholder;
$googleMap = "https://www.google.com.sa/maps/search/{$property->location->latitude},{$property->location->longitude}";

@endphp

<section class="hero is-info">
  <div class="hero-body">
    <div class="container has-text-centered">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li>
            <a
              href="{{ route('properties.list') }}"
            ">Propiedades</a>
          </li>
          <li class="is-active">
            <a href="#" aria-current="page">
              {{ $property->title }}
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="columns is-multiline">
      <div class="column is-6">
        <div class="card">
          <div class="card-image">
            <div class="card-image-tag tags has-addons">
              <span class="tag is-link is-medium">
               Tipo de propiedad
              </span>
              <span class="tag is-medium">
                {{ $property->property_type }}
              </span>
            </div>
            <div class="card-image-tag tags has-addons is-right">
              <span class="tag is-danger is-medium">
               ID
              </span>
              <span class="tag is-medium">
                {{ $property->public_id }}
              </span>
            </div>
            <figure class="image is-4by3">
              <img src="{{ $primaryImage->url }}" alt="{{ $primaryImage->title }}">
            </figure>
          </div>
        </div>
      </div>
      <div class="column is-6">
        <h1 class="title">
          {{ $property->title }}
        </h1>
        <p class="mb-2">
          {{ $property->description }}
        </p>
        <a href="{{ $googleMap }}" class="is-block mb-2" target="_blank">
          <small >
            {{ $property->location->name }}
          </small>
        </a>
        <x-property-operations :operations="$property->operations"/>
        <div class="mt-3">
          <h3 class="title is-6 mb-2">
            Agente vendedor
          </h3>
          <x-property-agent :agent="$property->agent"/>
        </div>
      </div>
    </div>
  </div>
</section>

@include('sections.property-contact-form', ['property' => $property])

@endsection
