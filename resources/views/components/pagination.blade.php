<div>
  <nav class="pagination" role="navigation" aria-label="pagination">
    <a
      href="?page={{ $paginator->current_page - 1 }}"
      class="pagination-previous"
      title="This is the first page"
      {{ $paginator->has_previous ? '' : 'disabled' }}
    >
      Anterior
    </a>
    <a
      href="?page={{ $paginator->current_page + 1 }}"
      class="pagination-next"
      {{ $paginator->has_next ? '' : 'disabled' }}
    >
      Siguiente
    </a>
    <ul class="pagination-list">
      @for($i = 1; $i <= $paginator->pages && $i <= 5; $i++)
        <li>
          <a
            href="?page={{ $i }}"
            class="pagination-link {{ $paginator->current_page == $i ? 'is-current' : '' }}"
          >
            {{ $i }}
          </a>
        </li>
      @endfor
      @if($paginator->pages > 5)
        <li>
          <span class="pagination-ellipsis">&hellip;</span>
        </li>
        <li>
          <a
            href="?page={{ $paginator->pages }}"
            class="pagination-link"
          >
            {{ $paginator->pages }}
          </a>
        </li>
      @endif
    </ul>
  </nav>
</div>
