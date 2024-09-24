@php
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $items = isset($items) && !empty($items) ? $items : [];

  $left_items = array();
  $right_items = array();

  foreach ($items as $index => $item) {
    if ($index % 2 == 0) {
      $left_items[] = $item;
    } else {
      $right_items[] = $item;
    }
  }
@endphp

<section class="faq-accordions">
  <div class="faq-accordions__container container">
    <div class="faq-accordions__header">
      @if(!empty($title))
      <h2 class="faq-accordions__title">{{ $title }}</h2>
      @endif
      @if(!empty($description))
      <div class="faq-accordions__description paragraph">
        {!! $description !!}
      </div>
      @endif
    </div>
    <div class="faq-accordions__items">
      <div class="faq-accordions__column gsap-animate">
        @foreach ($left_items as $item)
        <div class="faq-accordions__accordion-item gsap-scrollreveal">
          <h3 class="faq-accordions__item-heading">
            <span class="faq-accordions__item-heading-text">
              {{ $item['heading'] }}
            </span>
            <span class="faq-accordions__cross"></span>
          </h3>
          <div class="faq-accordions__item-content paragraph">
            {!! $item['content'] !!}
          </div>
        </div>
        @endforeach
      </div>
      <div class="faq-accordions__column gsap-animate">
        @foreach ($right_items as $item)
        <div class="faq-accordions__accordion-item gsap-scrollreveal">
          <h3 class="faq-accordions__item-heading">
            <span class="faq-accordions__item-heading-text">
              {{ $item['heading'] }}
            </span>
            <span class="faq-accordions__cross"></span>
          </h3>
          <div class="faq-accordions__item-content paragraph">
            {!! $item['content'] !!}
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
