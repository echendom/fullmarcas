@php
  $test_links = [
    [
      'title' => 'Inicio',
      'url' => '/',
      'target' => '_self'
    ],
    [
      'title' => 'Qué hacemos',
      'url' => '/que-hacemos',
      'target' => '_self'
    ],
    [
      'title' => 'Quiénes somos',
      'url' => '/quienes-somos',
      'target' => '_self'
    ],
    [
      'title' => 'Blog',
      'url' => '/blog-listing-page',
      'target' => '_self'
    ],
    [
      'title' => 'Centro de ayuda',
      'url' => '/centro-de-ayuda',
      'target' => '_self'
    ]
  ];
  $test_logo = [
    'url' => themosis_assets() . '/images/logo_header.svg',
    'alt' => 'Logo full marcas'
  ];
  $test_logo_white = [
    'url' => themosis_assets() . '/images/logo_header_white.svg',
    'alt' => 'Logo full marcas'
  ];
  $pink_arrow_right = themosis_assets() . '/images/icons/pink_arrow_right.svg';
  $test_cta = [
    'title' => 'Registra tu marca',
    'url' => '/registra-tu-marca'
  ];
  $test_socials = [
    [
      'url' => '/',
      'icon' => [
        'url' => themosis_assets() . '/images/icons/white_tiktok.svg',
        'alt' => 'tiktok'
      ]
    ],
    [
      'url' => '/',
      'icon' => [
        'url' => themosis_assets() . '/images/icons/white_instagram.svg',
        'alt' => 'instagram'
      ]
    ],
    [
      'url' => '/',
      'icon' => [
        'url' => themosis_assets() . '/images/icons/white_linkedin.svg',
        'alt' => 'linkedin'
      ]
    ],
    [
      'url' => '/',
      'icon' => [
        'url' => themosis_assets() . '/images/icons/white_youtube.svg',
        'alt' => 'youtube'
      ]
    ],
    [
      'url' => '/',
      'icon' => [
        'url' => themosis_assets() . '/images/icons/white_whatsapp.svg',
        'alt' => 'whatsapp'
      ]
    ]
  ];

  $socials = isset($socials) && !empty($socials) ? $socials : $test_socials;

  $url = $_SERVER['REQUEST_URI'];

  $transparent_top = false;

  if ($url == '/') {
    // The header background is transparent only in homepage.
    $transparent_top = true;
  }

  $logo = isset($logo) && !empty($logo) ? $logo : $test_logo;
  $links = isset($links) && !empty($links) ? $links : $test_links;
  $cta_button = isset($cta_button) && !empty($cta_button) ? $cta_button : $test_cta;
  $logo_white = isset($logo_white) && !empty($logo_white) ? $logo_white : $test_logo_white;
@endphp


@if(isset($cta_button) && !empty($cta_button))
<v-cta-button
  class="header__cta-button--mobile hidden"
  :url="{{json_encode($cta_button['url'])}}"
  :target="{{json_encode($cta_button['target'] ?? '_self')}}"
  :title="{{json_encode($cta_button['title'])}}"
></v-cta-button>
@endif

<header class="header {{ $transparent_top ? 'header--transparent-top' : 'header--default' }}">
  <div class="header__container container">

    @if(isset($logo) && !empty($logo))
    <a href="/" class="header__logo" target="_self">
      <img class="header__logo-desktop" src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" width="200" height="76" />
      <img class="header__logo-mobile" src="{{ $logo_white['url'] }}" alt="{{ $logo_white['alt'] }}" width="90" height="34" />
    </a>
    @endif

    @if(isset($links) && !empty($links))
    <nav class="header__links">
      <ul>
        @foreach($links as $link)
        <li>
          <a
            @if(isset($link['active']) && $link['active'])
            class="header__link--active"
            @endif
            href="{{ $link['url'] }}"
            target="{{ $link['target'] ?? '_self' }}"
            @if(($link['target'] ?? '_self') == '_blank')
            rel="noopener noreferrer"
            @endif
          >{{ $link['title'] }}</a>
        </li>
        @endforeach
      </ul>
    </nav>
    @endif

    @if(isset($cta_button) && !empty($cta_button))
    <v-cta-button
      class="header__cta-button"
      :url="{{json_encode($cta_button['url'])}}"
      :target="{{json_encode($cta_button['target'] ?? '_self')}}"
      :title="{{json_encode($cta_button['title'])}}"
    ></v-cta-button>
    @endif

    <button class="header__mobile-button button--primary">
      <span class="header__mobile-button-line"></span>
    </button>

  </div>
  <div class="header__menu-mobile-container">
    <div class="header__menu-mobile-links">
      <ul>
        @foreach($links as $link)
        <li>
          <a
            @if(isset($link['active']) && $link['active'])
            class="header__link--active"
            @endif
            href="{{ $link['url'] }}"
            target="{{ $link['target'] ?? '_self' }}"
            @if(($link['target'] ?? '_self') == '_blank')
            rel="noopener noreferrer"
            @endif
          >
            {{ $link['title'] }}
            <img
              class="header__menu-mobile-link-arrow"
              src="{{ $pink_arrow_right }}"
              alt="Flecha link"
              width="17"
              height="15"
              loading="lazy"
            />
          </a>
        </li>
        @endforeach
      </ul>
    </div>
    @if(!empty($socials))
    <div class="header__menu-mobile-socials">
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
</header>
