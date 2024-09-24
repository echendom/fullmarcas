@php
  $title = isset($title) && !empty($title) ? $title : '';
  $subheading = isset($subheading) && !empty($subheading) ? $subheading : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $image = isset($image) && !empty($image) ? $image : [];
  $variant = isset($variant) && !empty($variant) ? $variant : 'primary';

  $white_lock_sillouette = themosis_assets() . '/images/white_lock_sillouette.svg';
@endphp

<section class="hero-page {{ $variant === 'primary' ? 'hero-page--use-padding' : 'hero-page--use-margin' }}">
  <div class="hero-page__container container">
    <h1 class="hero-page__title">
      {{ $title }}
    </h1>
    <div class="hero-page__banner--{{$variant}} gsap-animate">
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
      <div class="hero-page__image-box gsap-scrollreveal">
        <img
          class="hero-page__image image-no-touch"
          src="{{ $image['url'] }}"
          alt="{{ $image['alt'] }}"
          width="480"
          @if($variant === 'primary')
          height="420"
          @else
          height="400"
          @endif
        />
      </div>
      <div class="hero-page__content">
        @if(!empty($subheading))
        <h2 class="hero-page__subheading">
          {{ $subheading }}
        </h2>
        @endif
        @if(!empty($description))
        <div class="hero-page__description paragraph--large">
          {!! $description !!}
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
