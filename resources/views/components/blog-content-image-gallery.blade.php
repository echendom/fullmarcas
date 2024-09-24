@php
  $image_gallery = isset($image_gallery) && !empty($image_gallery) ? $image_gallery : [];

  $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
  $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';
@endphp

@if(!empty($image_gallery))
<div class="blog-content__image-gallery">
  <div class="blog-content__image-slider spaced-slides--stuck-to-edge">
    @foreach($image_gallery as $image)
    <img
      class="blog-content__image"
      src="{{ $image['url'] }}"
      alt="{{ $image['alt'] ?? 'Imagen de galería' }}"
      width="850"
      height="440"
    />
    @endforeach
  </div>
  @if(count($image_gallery) > 1)
  <div class="blog-content__slider-footer">
    <div class="blog-content__progress-bar">
      <span class="blog-content__progress-fill"></span>
    </div>
    <div class="blog-content__slider-controls slider-controls">
      <button class="blog-content__button--prev slider-controls__button">
        <img
          class="blog-content__arrow-icon slider-controls__icon"
          src="{{ $arrow_left }}"
          alt="Flecha izquierda"
          width="20"
          height="20"
        />
      </button>
      <span class="blog-content__page-indicator slider-controls__page-indicator">
        1 de {{ count($image_gallery) }}
      </span>
      <button class="blog-content__button--next slider-controls__button">
        <img
          class="blog-content__arrow-icon slider-controls__icon"
          src="{{ $arrow_right }}"
          alt="Flecha derecha"
          width="20"
          height="20"
        />
      </button>
    </div>
  </div>
  @endif
</div>
@endif
