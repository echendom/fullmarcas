@php
  $title = isset($title) && !empty($title) ? $title : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $steps = isset($steps) && !empty($steps) ? $steps : [];
  $link = isset($link) && !empty($link) ? $link : [];
  $arrow = themosis_assets() . '/images/white_dotted-arrow.svg';
  $arrow_mobile = themosis_assets() . '/images/white_dotted_arrow_down.svg';
@endphp

<section class="step-by-step">
  <div class="step-by-step__container container">
    <div class="step-by-step__header">
      <h2 class="step-by-step__title title-split">
        {!! $title !!}
      </h2>
      @if(!empty($description))
      <div class="paragraph paragraph--medium step-by-step__description">
        {!! $description !!}
      </div>
      @endif
    </div>
    <div class="step-by-step__steps gsap-animate">
      @foreach($steps as $step)
      <div class="step-by-step__step gsap-scrollreveal--horizontal">
        @if($loop->index > 0)
        <picture class="step-by-step__step-arrow">
          <source
            media="(min-width: 768px)"
            srcset="{{ $arrow }}"
          />
          <img
            class="step-by-step__step-arrow-image image-no-touch"
            src="{{ $arrow_mobile }}"
            alt="flecha"
            role="presentation"
            width="85"
            height="12"
            loading="lazy"
          />
        </picture>
        @endif
        <div class="step-by-step__step-card">
          <div class="step-by-step__step-header">
            <span class="step-by-step__step-index">
              {{ $loop->index + 1 }}
            </span>
            <div class="step-by-step__icon-box" style="--card-color: {{ $step['color'] }}">
              <img
                class="step-by-step__icon"
                src="{{ $step['icon']['url'] }}"
                alt="{{ $step['icon']['alt'] }}"
                loading="lazy"
                width="45"
                height="45"
              />
            </div>
          </div>
          <div class="step-by-step__step-description">
            {{ $step['description'] }}
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @if(isset($link) && !empty($link))
    <div class="step-by-step__cta">
      <a
        class="button--primary-inverted"
        href="{{ $link['url'] }}"
        target="{{ $link['target'] ?? '_self' }}"
        @if(($link['target'] ?? '_self') == '_blank')
        rel="noopener noreferrer"
        @endif
      >
        {{ $link['title'] }}
      </a>
    </div>
    @endif
  </div>
</section>
