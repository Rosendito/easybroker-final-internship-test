@php
  $placeholder = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIxyT0DAa5_kwzb-e-bpTvAXIyW0OispA76Q&usqp=CAU';
@endphp

<article class="media">
  <figure class="media-left" style="width: 64px">
    <p class="image is-square">
      <img src="{{ $agent->profile_image_url ?? $placeholder }}" class="is-rounded is-image-fit" />
    </p>
  </figure>
  <div class="media-content">
    <div class="content">
      <p>
        <strong>
          {{ $agent->full_name }}
        </strong>
        <br>
        <a href="mailto:{{ $agent->email }}">
          <small>{{ $agent->email }}</small>
        </a>
        <br>
        <a href="tel:{{ $agent->mobile_phone }}">
          <small>{{ $agent->mobile_phone }}</small>
        </a>
      </p>
    </div>
  </div>
</article>
