<div class="field is-grouped is-grouped-multiline">
  @foreach ($operations as $operation)
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
