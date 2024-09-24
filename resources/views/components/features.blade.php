@php
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $items = isset($items) && !empty($items) ? $items : [];

  $variant = isset($variant) && !empty($variant) ? $variant : 'primary';
@endphp

<section class="features--{{$variant}}">
  <div class="features__container container">
    <div class="features__aside">
      <h2 class="features__title">
        {{ $title }}
      </h2>
      <div class="features__description paragraph">{!! $description !!}</div>
    </div>
    <div class="features__items gsap-animate">
      @foreach($items as $item)
      <div class="features__item gsap-scrollreveal--horizontal">
        <span class="features__icon-box" style="--item-color: {{ $item['color'] }}">
          <img
            class="features__icon image-no-touch"
            src="{{ $item['icon']['url'] }}"
            alt="{{ $item['icon']['alt'] }}"
            loading="lazy"
            width="30"
            height="30"
          />
        </span>
        <div class="features__item-body">
          <h3 class="features__item-title">{{ $item['title'] }}</h3>
          <div class="features__item-description paragraph--small">{!! $item['description'] !!}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
