@php
  $blockquote = isset($blockquote) && !empty($blockquote) ? $blockquote : [];
@endphp

<blockquote class="blog-content__blockquote">
  <img
    src="{{ $quote_icon }}"
    alt="Icono de cita"
    width="32"
    height="32"
    loading="lazy"
    role="presentation"
  />
  <div class="blog-content__blockquote-content">
    @if(isset($blockquote['quote']) && !empty($blockquote['quote']))
    <div class="blog-content__quote paragraph--large">
      {!! $blockquote['quote'] !!}
    </div>
    @endif
    <footer class="blog-content__quote-footer">
      @if(
        isset($blockquote['author_image']) &&
        !empty($blockquote['author_image']) &&
        isset($blockquote['author_image']['url']) &&
        !empty($blockquote['author_image']['url'])
      )
      <img
        class="blog-content__quote-author-image"
        src="{{ $blockquote['author_image']['url'] }}"
        alt="{{ $blockquote['author_image']['alt'] ?? 'Autor de la cita' }}"
        width="30"
        height="30"
        loading="lazy"
      />
      @endif
      <div class="blog-content__quote-author-data paragraph--small">
        <span class="blog-content__quote-author-name">{{ $blockquote['author_name'] }},</span>
        <span class="blog-content__quote-author-role">{{ $blockquote['author_role'] }}</span>
      </div>
    </footer>
  </div>
</blockquote>