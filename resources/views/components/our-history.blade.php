@php
  $pretitle = isset($pretitle) && !empty($pretitle) ? $pretitle : '';
  $title = isset($title) && !empty($title) ? $title : '';
  $items = isset($items) && !empty($items) ? $items : [];

  $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
  $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';
  $image_off = themosis_assets() . '/images/white_photo-off.svg';
@endphp

<section class="our-history">
  <div class="our-history__container container">
    <div class="our-history__header">
      @if(!empty($pretitle))
      <span class="our-history__pretitle paragraph--small">
        {{ $pretitle }}
      </span>
      @endif

      @if(!empty($title))
      <h2 class="our-history__title">
        {{ $title }}
      </h2>
      @endif
    </div>

    @if(!empty($items))
    <div class="our-history__slider spaced-slides equal-height-slides">
      @foreach($items as $item)
      <div
        class="our-history__slide"
        @if($loop->index === 0)
        data-active="true"
        @else
        data-active="false"
        @endif
        data-index="{{ $loop->index }}"
      >
        <div class="our-history__slide-content">
          <div class="our-history__image-box">
            @if(isset($item['image']) && !empty($item['image']))
            <img
              class="our-history__slide-image"
              data-lazy="{{ $item['image']['url'] }}"
              alt="{{ $item['image']['alt'] }}"
              width="410"
              height="250"
            />
            @else
            <img
              class="our-history__image-default__image"
              data-lazy="{{ $image_off }}"
              alt="Imagen por defecto"
              width="80"
              height="80"
            />
            @endif
          </div>
          <div class="our-history__slide-body">
            @if(isset($item['tag']) && !empty($item['tag']))
            <span class="our-history__slide-tag">{{ $item['tag'] }}</span>
            @endif
            @if(isset($item['title']) && !empty($item['title']))
            <h3 class="our-history__slide-title">{{ $item['title'] }}</h3>
            @endif
            @if(isset($item['description']) && !empty($item['description']))
            <div class="our-history__slide-description">{!! $item['description'] !!}</div>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="our-history__slider-mobile-footer">
      <div class="our-history__progress-bar">
        <span class="our-history__progress-fill"></span>
      </div>
      <div class="our-history__slider-mobile-controls">
        <button class="our-history__slider-mobile-button--prev slider-controls__button">
          <img
            class="our-history__slider-button-icon"
            src="{{ $arrow_left }}"
            alt="Flecha izquierda"
            width="20"
            height="20"
            loading="lazy"
          />
        </button>
        <button class="our-history__slider-mobile-button--next slider-controls__button">
          <img
            class="our-history__slider-button-icon"
            src="{{ $arrow_right }}"
            alt="Flecha derecha"
            width="20"
            height="20"
            loading="lazy"
          />
        </button>
      </div>
    </div>
    <div class="our-history__slider-controls slider-controls">
      <button class="our-history__slider-button--prev slider-controls__button">
        <img
          class="our-history__slider-button-icon"
          src="{{ $arrow_left }}"
          alt="Flecha izquierda"
          width="20"
          height="20"
          loading="lazy"
        />
      </button>
      <span class="our-history__slider-indicators">
        1 de {{ count($items) }}
      </span>
      <button class="our-history__slider-button--next slider-controls__button">
        <img
          class="our-history__slider-button-icon"
          src="{{ $arrow_right }}"
          alt="Flecha derecha"
          width="20"
          height="20"
          loading="lazy"
        />
      </button>
    </div>
    @endif
  </div>
</section>
