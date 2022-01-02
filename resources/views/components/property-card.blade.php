@php
  $propertyTypes = [
    'sale' => [
      'class' => 'is-success',
      'text' => 'Venta'
    ],
    'rental' => [
      'class' => 'is-info',
      'text' => 'Arriendo',
    ],
    'temporary_rental' => [
      'class' => 'is-danger',
      'text' => 'Arriendo temporal',
    ],
  ];

@endphp

<a href="">
  <div class="card">
    <div class="card-image">
      <figure class="image is-4by3">
        <img src="{{ $property->title_image_thumb }}" alt="{{ $property->title }} Thumbnail">
      </figure>
    </div>
    <div class="card-content">
      <h3 class="title is-5">
        {{ $property->title }}
      </h3>
      <div class="field is-grouped is-grouped-multiline">
        @foreach ($property->operations as $operation)
          <div class="control">
            <div class="tags has-addons">
              <span
                class="tag {{ $propertyTypes[$operation->type]['class'] }}"
              >
                {{ $propertyTypes[$operation->type]['text'] }}
              </span>
              <span class="tag">
                {{ $operation->formatted_amount }}
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</a>
