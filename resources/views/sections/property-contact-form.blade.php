<section class="section">
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-8">
        <h2 class="title is-3">
          Contacta con nosotros para comprar la propiedad
        </h2>
        @if (session()->has('success'))
        <div class="notification is-primary">
          <a href="{{ url()->current() }}" class="delete"></a>
          Mensaje enviado exitosamente.
        </div>
        @endif
        <form method="POST" action="{{ route('properties.contact', $property->public_id) }}">
          @csrf

          <x-form-input
            :name="'name'"
            :type="'text'"
            :label="'Nombre'"
            :placeholder="'Juan Martínez'"
          />
          <x-form-input
            :name="'email'"
            :type="'email'"
            :label="'Correo electrónico'"
            :placeholder="'juan@ejemplo.com'"
          />
          <x-form-input
            :name="'phone'"
            :type="'text'"
            :label="'Teléfomo de contacto'"
            :placeholder="'+52 (55) 5555-5555'"
          />
          <x-form-input
            :name="'message'"
            :type="'textarea'"
            :label="'Mensaje'"
            :placeholder="'Escribe aquí tu mensaje'"
          />

          <div class="field">
            <button type="submit" class="button is-primary">
              Enviar mensaje
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
