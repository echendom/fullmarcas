@php
  $title = isset($title) && !empty($title) ? $title : '';
  $highlighted_posts = isset($highlighted_posts) && !empty($highlighted_posts) ? $highlighted_posts : [];

  $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
  $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';

  $white_lock_sillouette = themosis_assets() . '/images/white_lock_sillouette.svg';
@endphp

<section class="hero-blog">
  <div class="hero-blog__container container">
    @if(!empty($title))
    <h1 class="hero-blog__title">
      {{ $title }}
    </h1>
    @endif
    @if(!empty($highlighted_posts))
    <div class="hero-blog__highlighted-posts">
      <div class="animated-background--secondary">
        <img
          class="animated-background__white-lock animated-background__white-lock--1"
          src="{{ $white_lock_sillouette }}"
          width="420"
          height="594"
          role="presentation"
          alt="Silueta de candado blanco"
        />
        <img
          class="animated-background__white-lock animated-background__white-lock--2"
          src="{{ $white_lock_sillouette }}"
          width="420"
          height="594"
          role="presentation"
          alt="Silueta de candado blanco"
        />
      </div>
      <div class="hero-blog__slider spaced-slides">
        @foreach($highlighted_posts as $item)
        <article>
          <div class="hero-blog__post">
            <a class="hero-blog__thumbnail-link" href="{{ $item['url'] }}">
              <img
                class="hero-blog__thumbnail"
                src="{{ $item['thumbnail']['url'] }}"
                alt="{{ $item['thumbnail']['alt'] }}"
                width="470"
                height="310"
              />
            </a>
            <div class="hero-blog__post-body">
              <div class="hero-blog__tags">
                @foreach($item['tags'] as $tag)
                <span class="hero-blog__tag" style="--tag-color: {{ $tag['color'] }}">
                  {{ $tag['text'] }}
                </span>
                @endforeach
              </div>
              <span class="hero-blog__date">
                Fecha de publicación: {{ $item['date'] }}
              </span>
              <h2 class="hero-blog__post-title">
                <a class="hero-blog__title-link" href="{{ $item['url'] }}">
                  {{ $item['title'] }}
                </a>
              </h2>
              <a class="hero-blog__description" href="{{ $item['url'] }}">
                {!! $item['description'] !!}
              </a>
              <a class="hero-blog__link" href="{{ $item['url'] }}">
                Leer más
              </a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
      @if(count($highlighted_posts) > 1)
      <div class="hero-blog__slider-controls slider-controls">
        <button class="hero-blog__button--prev slider-controls__button">
          <img
            class="hero-blog__arrow-icon slider-controls__icon"
            src="{{ $arrow_left }}"
            alt="Flecha izquierda"
            width="20"
            height="20"
          />
        </button>
        <span class="hero-blog__page-indicator slider-controls__page-indicator">
          1 de {{ count($highlighted_posts) }}
        </span>
        <button class="hero-blog__button--next slider-controls__button">
          <img
            class="hero-blog__arrow-icon slider-controls__icon"
            src="{{ $arrow_right }}"
            alt="Flecha derecha"
            width="20"
            height="20"
          />
        </button>
      </div>
      @endif
    </div>
    @endif
  </div>
</section>
