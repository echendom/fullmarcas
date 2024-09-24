@php
  $title = isset($title) && !empty($title) ? $title : 'Artículos relacionados';
  $items = isset($items) && !empty($items) ? $items : [];
  $link = isset($link) && !empty($link) ? $link : [];

  $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';
  $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
@endphp

@if(!empty($items))
<section class="blog-listing-inline">
  <div class="blog-listing-inline__container container">
    @if(!empty($title))
    <h2 class="blog-listing-inline__title">
      {{ $title }}
    </h2>
    @endif
    <div class="blog-listing-inline__items-container">
      <div class="blog-listing-inline__items">
        <div class="blog-listing-inline__list spaced-slides equal-height-slides gsap-animate">
          @foreach($items as $item)
            @include('components.card-blog-article', ['data' => $item, 'animate' => true])
          @endforeach
        </div>
        <div class="blog-listing-inline__slide-footer">
          <div class="blog-listing-inline__progress-bar">
            <span class="blog-listing-inline__progress-fill"></span>
          </div>
          <div class="blog-listing-inline__slide-controls">
            <button class="blog-listing-inline__button-left button--primary-inverted">
              <img
                class="blog-listing-inline__button-icon"
                width="20"
                height="20"
                loading="lazy"
                src="{{ $arrow_left }}"
                alt="Icono flecha anterior"
              />
            </button>
            <button class="blog-listing-inline__button-right button--primary-inverted">
              <img
                class="blog-listing-inline__button-icon"
                width="20"
                height="20"
                loading="lazy"
                src="{{ $arrow_right }}"
                alt="Icono flecha anterior"
              />
            </button>
          </div>
        </div>
        @if(!empty($link))
        <div class="blog-listing-inline__link-block">
          <a
            href="{{ $link['url'] }}"
            class="button--primary-inverted"
            target="{{ $link['target'] ?? '_self' }}"
            @if(($link['target'] ?? '_self') == '_blank')
            rel="noopener noreferrer"
            @endif
          >
            {{ $link['title'] }}
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif