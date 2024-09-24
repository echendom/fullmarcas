@php
  $title = isset($title) && !empty($title) ? $title : '';
  $image = isset($image) && !empty($image) ? $image : [];
  $items = isset($items) && !empty($items) ? $items : [];

  $checkmark_icon = themosis_assets() . '/images/icons/black_checkmark.svg';
  $blue_lock = themosis_assets() . '/images/blue_lock.svg';
@endphp

<section class="benefits">
  <div class="benefits__container container">
    <div class="benefits__content-panel">
      <h2 class="benefits__title title-split">
        {!! $title !!}
      </h2>
      <div class="benefits__items gsap-animate">
        @foreach($items as $item)
        <div class="benefits__item gsap-scrollreveal">
          <span class="benefits__checkmark">
            <img
              class="benefits__checkmark-icon image-no-touch"
              src="{{ $checkmark_icon }}"
              alt="icono check"
              role="presentation"
              width="20"
              height="20"
              loading="lazy"
            />
          </span>
          <div class="benefits__item-content">
            <h3 class="benefits__item-heading">
              {{ $item['heading'] }}
            </h3>
            <div class="benefits__item-description">
              {!! $item['description'] !!}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="benefits__image-panel">
      <img
        class="benefits__image image-no-touch"
        src="{{ $image['url'] }}"
        alt="{{ $image['alt'] }}"
        width="550"
        height="480"
        loading="lazy"
      />
    </div>
    <img
      class="benefits__background-lock-image image-no-touch"
      src="{{ $blue_lock }}"
      role="presentation"
      width="616"
      height="869"
      loading="lazy"
    />
  </div>
</section>
