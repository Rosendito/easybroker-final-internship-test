@php
  $image =
    $property->title_image_thumb ??
    'https://lh3.googleusercontent.com/proxy/ATdKAtR0gvBn6IoZXDnmiqYZQ8PWixXmM1tIfbWJ55OvxHgZ2nZZyW2y8yE_t6uJX2JJ3nzE9Qiuqx1nqI0JvixJ5GCJ5SmbQvn0OreIz0xDqtjAzmo';
@endphp

<a href="{{ route('properties.show', $property->public_id) }}">
  <div class="card">
    <div class="card-image">
      <span class="card-image-tag tag is-link is-medium">
        {{ $property->property_type }}
      </span>
      <span class="card-image-tag tag is-danger is-medium is-right">
        {{ $property->public_id }}
      </span>
      <figure class="image is-4by3">
        <img src="{{ $image }}" alt="{{ $property->title }} Thumbnail">
      </figure>
    </div>
    <div class="card-content">
      <h3 class="title is-5 mb-2">
        {{ $property->title }}
      </h3>
      <div class="is-flex is-justify-content-between mb-2">
        <small>
          {{ $property->location }}
        </small>
      </div>
      <x-property-operations :operations="$property->operations"/>
    </div>
  </div>
</a>
