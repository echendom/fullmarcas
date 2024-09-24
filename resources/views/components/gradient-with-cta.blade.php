@php
  $image = isset($image) && !empty($image) ? $image : [];
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $link = isset($link) && !empty($link) ? $link : [];
  $variant = isset($variant) && !empty($variant) ? $variant : 'primary';

  $blue_lock = themosis_assets() . '/images/blue_lock.svg';
  $blue_lock_sillouette = themosis_assets() . '/images/blue_lock_sillouette.svg';
@endphp

<section class="gradient-with-cta--{{$variant}}">
  <div class="gradient-with-cta__container container gsap-animate">
    <div class="gradient-with-cta__image-box">
      <div class="gradient-with-cta__decor-background-images">
        <img
          class="gradient-with-cta__decor-lock-sillouette image-no-touch"
          src="{{ $blue_lock_sillouette }}"
          alt="Silueta cerradura azul"
          role="presentation"
          width="220"
          height="355"
          loading="lazy"
        />
        <img
          class="gradient-with-cta__decor-lock-filled image-no-touch"
          src="{{ $blue_lock }}"
          alt="Cerradura azul solido"
          role="presentation"
          width="220"
          height="355"
          loading="lazy"
        />

        </div>
        <img
          class="gradient-with-cta__image image-no-touch"
          src="{{ $image['url'] }}"
          alt="{{ $image['alt'] }}"
          loading="lazy"
          @if($variant == 'primary')
          width="250"
          height="315"
          @else
          width="360"
          height="330"
          @endif
        />
    </div>
    <div class="gradient-with-cta__content gsap-scrollreveal">
      <h2 class="gradient-with-cta__title">
        {{ $title }}
      </h2>
      <div class="gradient-with-cta__description paragraph--large">
        {!! $description !!}
      </div>
      <a
        href="{{ $link['url'] }}"
        class="gradient-with-cta__link button--primary-inverted"
        target="{{ $link['target'] ?? '_self' }}"
        @if (($link['target'] ?? '_self') == '_blank')
        rel="noopener noreferrer"
        @endif
      >
        {{ $link['title'] }}
      </a>
    </div>
    <a
      href="{{ $link['url'] }}"
      class="gradient-with-cta__link--mobile button--primary-inverted"
      target="{{ $link['target'] ?? '_self' }}"
      @if (($link['target'] ?? '_self') == '_blank')
      rel="noopener noreferrer"
      @endif
    >
      {{ $link['title'] }}
    </a>
  </div>
</section>
