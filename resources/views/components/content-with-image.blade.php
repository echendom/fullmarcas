@php
  $image = isset($image) && !empty($image) ? $image : '';
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';

  $blue_lock = themosis_assets() . '/images/blue_lock.svg';
@endphp

<section class="content-with-image">
  <div class="content-with-image__container container gsap-animate">
    <div class="content-with-image__image-panel image-no-touch">
      <img
        class="content-with-image__decor-lock-filled"
        src="{{ $blue_lock }}"
        alt="Candado azul"
        role="presentation"
        width="615"
        height="870"
        loading="lazy"
      />
      <img
        class="content-with-image__image"
        src="{{ $image['url'] }}"
        alt="{{ $image['alt'] }}"
        width="550"
        height="480"
        loading="lazy"
      />
    </div>
    <div class="content-with-image__content-panel gsap-scrollreveal">
      @if(!empty($title))
      <h2 class="content-with-image__title">
        {{ $title }}
      </h2>
      @endif
      @if(!empty($description))
      <div class="content-with-image__description paragraph--large">
        {!! $description !!}
      </div>
      @endif
    </div>
  </div>
</section>
