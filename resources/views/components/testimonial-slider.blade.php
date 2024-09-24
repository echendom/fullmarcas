@php
  $pretitle = isset($pretitle) && !empty($pretitle) ? $pretitle : '';
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $items = isset($items) && !empty($items) ? $items : [];
  
  $blue_lock_sillouette = themosis_assets() . '/images/blue_lock_sillouette.svg';
@endphp

<section class="testimonial-slider">

  <div class="animated-background">
    <img
      class="animated-background__blue-lock animated-background__blue-lock--1"
      src="{{ $blue_lock_sillouette }}"
      width="150"
      height="210"
      role="presentation"
      alt="Silueta de candado azul"
    />
    <img
      class="animated-background__blue-lock animated-background__blue-lock--2"
      src="{{ $blue_lock_sillouette }}"
      width="150"
      height="210"
      role="presentation"
      alt="Silueta de candado azul"
    />
    <img
      class="animated-background__blue-lock animated-background__blue-lock--3"
      src="{{ $blue_lock_sillouette }}"
      width="150"
      height="210"
      role="presentation"
      alt="Silueta de candado azul"
    />
  </div>

  <div class="testimonial-slider__header">
    @if(!empty($pretitle))
    <span class="testimonial-slider__pretitle paragraph--small">
      {{ $pretitle }}
    </span>
    @endif

    @if(!empty($title))
    <h2 class="testimonial-slider__title">
      {{ $title }}
    </h2>
    @endif

    @if(!empty($description))
    <div class="testimonial-slider__description paragraph">
      {!! $description !!}
    </div>
    @endif
  </div>

  @if(!empty($items))
  <div class="testimonial-slider__slider spaced-slides equal-height-slides gsap-animate">
    @foreach($items as $item)
    <div class="testimonial-slider__testimonial-container gsap-scrollreveal--horizontal">
      <blockquote class="testimonial-slider__testimonial-item">
        <div class="testimonial-slider__quote paragraph--large">
          {!! $item['quote'] !!}
        </div>
        <footer class="testimonial-slider__testimonial-footer">
          @if(
            isset($item['author_image']) &&
            !empty($item['author_image']) &&
            isset($item['author_image']['url']) &&
            !empty($item['author_image']['url'])
          )
          <img
            class="testimonial-slider__author-image"
            src="{{ $item['author_image']['url'] }}"
            alt="{{ $item['author_image']['alt'] }}"
            width="30"
            height="30"
            loading="lazy"
          />
          @endif
          <div class="testimonial-slider__author-data paragraph--small">
            <span class="testimonial-slider__author-name">{{ $item['author_name'] }},</span>
            <span class="testimonial-slider__author-role">{{ $item['author_role'] }}</span>
          </div>
        </footer>
      </blockquote>
    </div>
    @endforeach
  </div>
  @endif
</section>
