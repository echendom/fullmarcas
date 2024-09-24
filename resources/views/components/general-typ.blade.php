@php
  $clear_storage = isset($clear_storage) ? $clear_storage : false;
  $pretitle = isset($pretitle) && !empty($pretitle) ? $pretitle : '';
  $icon = isset($icon) && !empty($icon) ? $icon : [];
  $title = isset($title) && !empty($title) ? $title : '';
  $subtitle = isset($subtitle) && !empty($subtitle) ? $subtitle : '';
  $description = isset($description) && !empty($description) ? $description : '';
  $order_details = isset($order_details) && !empty($order_details) ? $order_details : '';
  $primary_button = isset($primary_button) && !empty($primary_button) ? $primary_button : [];
  $secondary_button = isset($secondary_button) && !empty($secondary_button) ? $secondary_button : [];
  $image = isset($image) && !empty($image) ? $image : [];
@endphp

<section class="general-typ">
  @if($clear_storage)
  <v-clear-storage></v-clear-storage>
  @endif
  <div class="general-typ__container container">
    <div class="general-typ__content-panel">
      @if(!empty($pretitle))
      <span class="general-typ__pretitle">
        {{ $pretitle }}
      </span>
      @endif
      @if(!empty($title))
      <h1 class="general-typ__title">
        @if(
          !empty($icon) &&
          isset($icon['url']) &&
          !empty($icon['url'])
        )
        <img
          class="general-typ__icon image-no-touch"
          src="{{ $icon['url'] }}"
          alt="{{ $icon['alt'] ?? 'Icono' }}"
          width="30"
          height="30"
          role="presentation"
        />
        @endif
        {{ $title }}
      </h1>
      @endif
      @if(!empty($subtitle))
      <p class="general-typ__subtitle">
        {{ $subtitle }}
      </p>
      @endif
      @if(!empty($description))
      <div class="general-typ__description paragraph--large">
        {!! $description !!}
      </div>
      @endif

      @if(!empty($order_details))
      <div class="general-typ__order-details">
        <h2 class="general-typ__order-details-title">
          {{$order_details['title']}}
          @if(
            isset($order_details['trademark_name']) &&
            !empty($order_details['trademark_name'])
          )
          <strong>{{$order_details['trademark_name']}}</strong>
          @endif
        </h2>
        <div class="general-typ__summary-services">
          @foreach($order_details['summary']['services'] as $service)
          <div class="general-typ__summary-service">
            <h3 class="general-typ__summary-service-title">
              {{ $service['title'] }}
            </h3>
            <div class="general-typ__summary-service-details">
              <div class="general-typ__summary-service-detail">
                <h4 class="general-typ__summary-service-detail-title">
                  
                </h4>
                <span class="general-typ__summary-service-detail-price">
                  {{ '$' . number_format((int)$service['price'], 0, '', '.') }}
                </span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="general-typ__summary-footer">
          <div class="general-typ__summary-total">
            <span>Total</span>
            <span>{{ $order_details['summary']['total'] }}</span>
          </div>
          @if(
            isset($order_details['summary']['details_modal']) &&
            !empty($order_details['summary']['details_modal'])
          )
          <v-details-modal-button
            title="{{ $order_details['summary']['details_modal']['title'] }}"
            content="{{ $order_details['summary']['details_modal']['content'] }}"
          ></v-details-modal-button>
          @endif
        </div>
      </div>
      @endif

      @if(
        !empty($primary_button) || 
        !empty($secondary_button)
      )
      <div class="general-typ__buttons">
        @if(!empty($primary_button))
        <a class="general-typ__button button--primary-inverted" href="{{ $primary_button['url'] }}">
          {{ $primary_button['title'] }}
        </a>
        @endif
        @if(!empty($secondary_button))
        <a class="general-typ__button button--secondary-white" href="{{ $secondary_button['url'] }}">
          {{ $secondary_button['title'] }}
        </a>
        @endif
      </div>
      @endif
    </div>
    @if(
      !empty($image) &&
      isset($image['url']) &&
      !empty($image['url'])
    )
    <img
      class="general-typ__image image-no-touch"
      src="{{ $image['url'] }}"
      alt="{{ $image['alt'] ?? 'Imagen' }}"
      width="440"
      height="550"
    />
    @endif
  </div>
</section>
