@php
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $image = isset($image) && !empty($image) ? $image : [];
  $features = isset($features) && !empty($features) ? $features : [];
  $socials = isset($socials) && !empty($socials) ? $socials : [];
  $registration_link = isset($registration_link) && !empty($registration_link) ? $registration_link : [];

  $blue_lock = themosis_assets() . '/images/blue_lock.svg';
  $blue_lock_sillouette = themosis_assets() . '/images/blue_lock_sillouette.svg';
@endphp

<section class="hero-home">
  <div class="hero-home__container container">
    <div class="animated-background">
      <img
        class="animated-background__blue-lock animated-background__blue-lock--1"
        src="{{ $blue_lock_sillouette }}"
        width="265"
        height="375"
        role="presentation"
        alt="Silueta de candado azul"
      />
      <img
        class="animated-background__blue-lock animated-background__blue-lock--2"
        src="{{ $blue_lock_sillouette }}"
        width="265"
        height="375"
        role="presentation"
        alt="Silueta de candado azul"
      />
    </div>
    <div class="hero-home__welcome">
      <h1 class="hero-home__title">
        {!! $title !!}
      </h1>
      <div class="hero-home__description paragraph paragraph--large">
        {!! $description !!}
      </div>
      <div class="hero-home__form">
        <v-form-hero :registration_link="{{json_encode($registration_link)}}"></v-form-hero>
      </div>
    </div>
    <div class="hero-home__image-panel">
      <div class="hero-home__decor-panel">
        <img
          class="hero-home__decor-lock-filled image-no-touch"
          src="{{ $blue_lock }}"
          alt="Candado azul"
          width="520"
          height="850"
          role="presentation"
        />
      </div>
      {{-- Slick Slider --}}
      <div class="home-hero-slider">
        @if (isset($images) && !empty($images))
          @foreach($images as $image)
            <div class="home-hero-slider__slide">
              <img
                class="hero-home__image image-no-touch"
                src="{{ $image['image']['url'] }}"
                alt="{{ $image['image']['alt'] ?? $image['name'] }}"
                width="520"
                height="645"
              />
            </div>
          @endforeach
        @endif
      </div>
      {{-- end Slick Slider --}}
      @if(!empty($features))
        <div class="hero-home__features">
          @foreach($features as $feature)
          <div class="hero-home__feature hero-home__feature--{{$loop->index + 1}}">
            @if(isset($feature['icon']) && !empty($feature['icon']))
            <img
              class="hero-home__feature-icon image-no-touch"
              src="{{ $feature['icon']['url'] }}"
              alt="{{ $feature['icon']['alt'] ?? 'icono' }}"
              width="30"
              height="30"
            />
            @endif
            @if(isset($feature['text']) && !empty($feature['text']))
            <div class="hero-home__feature-text paragraph paragraph--large">
              {!! $feature['text'] !!}
            </div>
            @endif
          </div>
          @endforeach
        </div>
      @endif
    </div>
    @if(!empty($socials))
    <div class="hero-home__socials">
      @foreach($socials as $social)
      <a class="hero-home__social" href="{{$social['url']}}" target="_blank" rel="noopener noreferrer">
        <img
          class="hero-home__social-icon image-no-touch"
          src="{{$social['icon']['url']}}"
          alt="{{$social['icon']['alt']}}"
          width="25"
          height="25"
        />
      </a>
      @endforeach
    </div>
    @endif
  </div>
</section>
