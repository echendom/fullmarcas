@php

  $footer = get_field('footer_sec', 'option');
  $footer = (new App\Models\Post())->getFooterSec($footer);

  $icon_info = themosis_assets() . '/images/icons/pink_info.svg';
  $icon_pin = themosis_assets() . '/images/icons/pink_pin.svg';
  $icon_phone = themosis_assets() . '/images/icons/pink_phone.svg';
  $icon_whatsapp = themosis_assets() . '/images/icons/pink_whatsapp.svg';
  $icon_mail = themosis_assets() . '/images/icons/pink_mail.svg';

@endphp

<footer class="footer footer--secondary">
  <div class="footer__container container">
    @if(!empty($footer['contact_info']))
    <address class="footer__links">
      @if(isset($footer['contact_info']['contact_page']) && !empty($footer['contact_info']['contact_page']))
      <a
        class="footer__link"
        href="{{ $footer['contact_info']['contact_page']['url'] }}"
        target="{{ $footer['contact_info']['contact_page']['target'] ?? '_self' }}"
        @if(($footer['contact_info']['contact_page']['target'] ?? '_self') == '_blank')
        rel="noopener noreferrer"
        @endif
      >
        <img
          class="footer__info-icon"
          src="{{ $icon_info }}"
          alt="Icono de informacion"
          width="20"
          height="20"
          loading="lazy"
        />
        {{ $footer['contact_info']['contact_page']['title'] }}
      </a>
      @endif

      @if(isset($footer['contact_info']['address']) && !empty($footer['contact_info']['address']))
      <a
        class="footer__link"
        href="{{ $footer['contact_info']['address']['url'] }}"
        target="_blank"
        rel="noopener noreferrer"
      >
        <img
          class="footer__link-icon"
          src="{{ $icon_pin }}"
          alt="Icono de marcador de mapa"
          width="20"
          height="20"
          loading="lazy"
        />
        {{ $footer['contact_info']['address']['title'] }}
      </a>
      @endif

      @if(isset($footer['contact_info']['phone']) && !empty($footer['contact_info']['phone']))
      <a
        class="footer__link"
        href="tel:{{ $footer['contact_info']['phone'] }}"
      >
        <img
          class="footer__link-icon"
          src="{{ $icon_phone }}"
          alt="Icono de teléfono"
          width="20"
          height="20"
          loading="lazy"
        />
        {{ $footer['contact_info']['phone'] }}
      </a>
      @endif

      @if(isset($footer['contact_info']['whatsapp']) && !empty($footer['contact_info']['whatsapp']))
      @php
        $trim_whatsapp = str_replace(' ', '', $footer['contact_info']['whatsapp']);
        $formatted_whatsapp = str_replace('+', '', $trim_whatsapp);
      @endphp
      <a
        class="footer__link"
        href="https://wa.me/{{ $formatted_whatsapp }}"
        target="_blank"
        rel="noopener noreferrer"
      >
        <img
          class="footer__link-icon"
          src="{{ $icon_whatsapp }}"
          alt="Icono de whatsapp"
          width="20"
          height="20"
          loading="lazy"
        />
        {{ $footer['contact_info']['whatsapp'] }}
      </a>
      @endif

      @if(isset($footer['contact_info']['email']) && !empty($footer['contact_info']['email']))
      <a
        class="footer__link"
        href="mailto:{{ $footer['contact_info']['email'] }}"
      >
        <img
          class="footer__link-icon"
          src="{{ $icon_mail }}"
          alt="Icono de carta"
          width="20"
          height="20"
          loading="lazy"
        />
        {{ $footer['contact_info']['email'] }}
      </a>
      @endif
    </address>
    @endif
  </div>
  @if (isset($footer['policies_pages']) && !empty($footer['policies_pages']))  
  <div class="footer__bottom container">
    <div class="footer__bottom-content">
      <div class="footer__policies-pages">
        @foreach($footer['policies_pages'] as $policy_page)
        <a
          class="footer__policy-page-link"
          href="{{ $policy_page['url'] }}"
          target="{{ $policy_page['target'] ?? '_self' }}"
          @if(($policy_page['target'] ?? '_self') == '_blank')
          rel="noopener noreferrer"
          @endif
        >{{ $policy_page['title'] }}</a>
        @endforeach
      </div>
      <div class="footer__copyright">
        @if(isset($footer['copyright_text']) && !empty($footer['copyright_text']))
        <span class="footer__copyright-text">
          {!! $footer['copyright_text'] !!}
        </span>
        @endif
        {{-- <span class="footer__meatcode-text paragraph">
          {!! $meatcode_text !!}
        </span> --}}
      </div>
    </div>
  </div>
  @endif

</footer>
