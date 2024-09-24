@php
  // $test_logo = [
  //   'url' => themosis_assets() . '/images/logo_footer.svg',
  //   'alt' => 'Logo Full marcas'
  // ];
  // $test_description = '<p>Párrafo para posicionamiento Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>';
  // $test_links = [
  //   [
  //     'title' => 'Qué hacemos',
  //     'url' => '/que-hacemos',
  //     'target' => '_self'
  //   ],
  //   [
  //     'title' => 'Quiénes somos',
  //     'url' => '/quienes-somos',
  //     'target' => '_self'
  //   ],
  //   [
  //     'title' => 'Blog',
  //     'url' => '/blog',
  //     'target' => '_self'
  //   ],
  //   [
  //     'title' => 'Registra tu marca',
  //     'url' => '/registra-tu-marca',
  //     'target' => '_self'
  //   ]
  // ];
  // $test_socials = [
  //   [
  //     'url' => 'https://tiktok.com',
  //     'title' => 'Tiktok',
  //     'target' => '_blank',
  //     'icon' => [
  //       'url' => themosis_assets() . '/images/icons/pink_tiktok.svg',
  //       'alt' => 'Icono Tiktok'
  //     ],
  //     'icon_mobile' => [
  //       'url' => themosis_assets() . '/images/icons/black_tiktok.svg',
  //       'alt' => 'Icono Tiktok'
  //     ],
  //   ],
  //   [
  //     'url' => 'https://instagram.com',
  //     'title' => 'Instagram',
  //     'target' => '_blank',
  //     'icon' => [
  //       'url' => themosis_assets() . '/images/icons/pink_instagram.svg',
  //       'alt' => 'Icono Instagram'
  //     ],
  //     'icon_mobile' => [
  //       'url' => themosis_assets() . '/images/icons/black_instagram.svg',
  //       'alt' => 'Icono Instagram'
  //     ],
  //   ],
  //   [
  //     'url' => 'https://linkedin.com',
  //     'title' => 'Linkedin',
  //     'target' => '_blank',
  //     'icon' => [
  //       'url' => themosis_assets() . '/images/icons/pink_linkedin.svg',
  //       'alt' => 'Icono Linkedin'
  //     ],
  //     'icon_mobile' => [
  //       'url' => themosis_assets() . '/images/icons/black_linkedin.svg',
  //       'alt' => 'Icono Linkedin'
  //     ],
  //   ],
  //   [
  //     'url' => 'https://youtube.com',
  //     'title' => 'Youtube',
  //     'target' => '_blank',
  //     'icon' => [
  //       'url' => themosis_assets() . '/images/icons/pink_youtube.svg',
  //       'alt' => 'Icono Youtube'
  //     ],
  //     'icon_mobile' => [
  //       'url' => themosis_assets() . '/images/icons/black_youtube.svg',
  //       'alt' => 'Icono Youtube'
  //     ],
  //   ]
  // ];
  // $test_contact_info = [
  //   'contact_page' => [
  //     'title' => 'Centro de ayuda',
  //     'url' => '/centro-de-ayuda',
  //     'target' => '_self'
  //   ],
  //   'address' => [
  //     'title' => 'Gran Santiago, Región Metropolitana de Santiago, Chile',
  //     'url' => 'https://maps.app.goo.gl/ntYm7vMdFg9PiHJ98',
  //     'target' => '_blank'
  //   ],
  //   'phone' => '+56 9 1234 5678',
  //   'whatsapp' => '+56 9 1234 5678',
  //   'email' => 'contacto@fullmarcas.cl'
  // ];
  // $test_policies_pages = [
  //   [
  //     'title' => 'Términos y condiciones',
  //     'url' => '/terminos-y-condiciones',
  //     'target' => '_self'
  //   ],
  //   [
  //     'title' => 'Políticas de privacidad',
  //     'url' => '/politicas-de-privacidad',
  //     'target' => '_self'
  //   ]
  // ];
  // $test_copyright_text = '&copy; 2023 Full Marcas';
  // $test_meatcode_text = 'Sitio desarrollado por <a href="https://meat.cl" target="_blank" rel="noopener noreferrer">Meat Code</a>';

  $icon_info = themosis_assets() . '/images/icons/pink_info.svg';
  $icon_pin = themosis_assets() . '/images/icons/pink_pin.svg';
  $icon_phone = themosis_assets() . '/images/icons/pink_phone.svg';
  $icon_whatsapp = themosis_assets() . '/images/icons/pink_whatsapp.svg';
  $icon_mail = themosis_assets() . '/images/icons/pink_mail.svg';
  $caret_icon = themosis_assets() . '/images/icons/pink_caret_down.svg';

  // $logo = isset($logo) && !empty($logo) ? $logo : $test_logo;
  // $description = isset($description) && !empty($description) ? $description : $test_description;
  // $links = isset($links) && !empty($links) ? $links : $test_links;
  // $socials = isset($socials) && !empty($socials) ? $socials : $test_socials;
  // $contact_info = isset($contact_info) && !empty($contact_info) ? $contact_info : $test_contact_info;
  // $policies_pages = isset($policies_pages) && !empty($policies_pages) ? $policies_pages : $test_policies_pages;
  // $copyright_text = isset($copyright_text) && !empty($copyright_text) ? $copyright_text : $test_copyright_text;
  // $meatcode_text = isset($meatcode_text) && !empty($meatcode_text) ? $meatcode_text : $test_meatcode_text;
@endphp

<footer class="footer footer--default">
  <div class="footer__container container">
    <div class="footer__logo-column">
      <img
        class="footer__logo"
        src="{{ $logo['url'] }}"
        alt="{{ $logo['alt'] }}"
        width="120"
        height="45"
        loading="lazy"
      />
      <div class="footer__description paragraph--small">
        {!! $description !!}
      </div>
    </div>
    @if(!empty($links))
    <div class="footer__links-column">
      <span class="footer__links-heading">Enlaces</span>
      <nav class="footer__nav-links">
        <ul>
          @foreach($links as $link)
          <li>
            <a
              href="{{ $link['url'] }}"
              target="{{ $link['target'] ?? '_self' }}"
              @if(($link['target'] ?? '_self') == '_blank')
              rel="noopener noreferrer"
              @endif
            >
              {{ $link['title'] }}
            </a>
          </li>
          @endforeach
        </ul>
      </nav>
    </div>
    @endif
    @if(!empty($socials))
    <div class="footer__links-column footer__links-column--social">
      <span class="footer__links-heading">Redes sociales</span>
      <div class="footer__links">
        @foreach($socials as $social)
        <a class="footer__link" href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
          @if(isset($social['icon']) && !empty($social['icon']))
          <img
            class="footer__link-icon"
            src="{{ $social['icon']['url'] }}"
            alt="{{ $social['icon']['alt'] }}"
            width="20"
            height="20"
            loading="lazy"
          />
          @endif
          @if(isset($social['icon_mobile']) && !empty($social['icon_mobile']))
          <img
            class="footer__link-icon-mobile"
            src="{{ $social['icon_mobile']['url'] }}"
            alt="{{ $social['icon_mobile']['alt'] }}"
            width="30"
            height="30"
            loading="lazy"
          />
          @endif
          <span class="footer__link-text">
            {{ $social['title'] }}
          </span>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    @if(!empty($contact_info))
    <div class="footer__links-column footer__links-column--accordion">
      <span class="footer__links-heading">
        Contacto
        <img
          class="footer__links-accordion-icon"
          src="{{ $caret_icon }}"
          alt="Icono acordeon"
          width="30"
          height="30"
          loading="lazy"
        />
      </span>
      <address class="footer__links">
        @if(isset($contact_info['contact_page']) && !empty($contact_info['contact_page']))
        <a
          class="footer__link"
          href="{{ $contact_info['contact_page']['url'] }}"
          target="{{ $contact_info['contact_page']['target'] ?? '_self' }}"
          @if(($contact_info['contact_page']['target'] ?? '_self') == '_blank')
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
          {{ $contact_info['contact_page']['title'] }}
        </a>
        @endif

        @if(isset($contact_info['address']) && !empty($contact_info['address']))
        <a
          class="footer__link"
          href="{{ $contact_info['address']['url'] }}"
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
          {{ $contact_info['address']['title'] }}
        </a>
        @endif

        @if(isset($contact_info['phone']) && !empty($contact_info['phone']))
        <a
          class="footer__link"
          href="tel:{{ $contact_info['phone'] }}"
        >
          <img
            class="footer__link-icon"
            src="{{ $icon_phone }}"
            alt="Icono de teléfono"
            width="20"
            height="20"
            loading="lazy"
          />
          {{ $contact_info['phone'] }}
        </a>
        @endif

        @if(isset($contact_info['whatsapp']) && !empty($contact_info['whatsapp']))
        @php
          $trim_whatsapp = str_replace(' ', '', $contact_info['whatsapp']);
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
          {{ $contact_info['whatsapp'] }}
        </a>
        @endif

        @if(isset($contact_info['email']) && !empty($contact_info['email']))
        <a
          class="footer__link"
          href="mailto:{{ $contact_info['email'] }}"
        >
          <img
            class="footer__link-icon"
            src="{{ $icon_mail }}"
            alt="Icono de carta"
            width="20"
            height="20"
            loading="lazy"
          />
          {{ $contact_info['email'] }}
        </a>
        @endif
      </address>
    </div>
    @endif
  </div>
  <div class="footer__bottom container">
    <div class="footer__policies-pages">
      @foreach($policies_pages as $policy_page)
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
      @if(isset($copyright_text) && !empty($copyright_text))
      <span class="footer__copyright-text">
        {!! $copyright_text !!}
      </span>
      @endif
      {{-- <span class="footer__meatcode-text paragraph">
        {!! $meatcode_text !!}
      </span> --}}
    </div>
  </div>
</footer>
