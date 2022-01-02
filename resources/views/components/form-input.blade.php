<div class="field">
  <label for="form_{{ $name }}" class="label">
    {{ $label }}
  </label>
  @if ($type === 'textarea')
    <textarea
      id="form_{{ $name }}"
      name="{{ $name }}"
      class="textarea @error($name) is-danger @enderror"
      placeholder="{{ $placeholder }}"
      @if ($required) required @endif
    >{{ old($name) }}</textarea>
  @else
    <input
    class="input @error($name) is-danger @enderror"
    id="form_{{ $name }}"
    type="{{ $type }}"
    value="{{ old($name) }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    @if ($required) required @endif
  >
  @error($name)
    <small class="has-text-danger">
      {{ $message }}
    </small>
  @enderror

  @endif
</div>
