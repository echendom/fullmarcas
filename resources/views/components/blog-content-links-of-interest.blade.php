@php
  $links_of_interest = isset($links_of_interest) && !empty($links_of_interest) ? $links_of_interest : [];
@endphp

@if(!empty($links_of_interest))
<div class="blog-content__links-of-interest">
  @foreach($links_of_interest as $link)
  <div class="blog-content__link-block">
    <h2 class="blog-content__link-label">
      {{ $link['label'] }}
    </h2>
    <a
      class="blog-content__link-of-interest button--primary-inverted"
      href="{{ $link['url'] }}"
      target="{{ $link['target'] ?? '_self' }}"
      @if(($link['target'] ?? '_self') == '_blank')
      rel="noopener noreferrer"
      @endif
    >
      <span class="blog-content__external-link-title">
        Visitar sitio web
      </span>
      <span class="blog-content__external-link-title--mobile">
        Visitar
      </span>
      @if(($link['target'] ?? '_self') == '_blank')
      <img
        class="blog-content__external-link-icon"
        alt="Icono link externo"
        src="{{ $external_icon }}"
        loading="lazy"
        role="presentation"
        width="20"
        height="20"
      />
      @endif
    </a>
  </div>
  @endforeach
</div>
@endif
