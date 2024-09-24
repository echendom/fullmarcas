@php
  $test_logo = [
    'url' => themosis_assets() . '/images/logo_header.svg',
    'alt' => 'Logo full marcas'
  ];
  $test_back = [
    'title' => 'Volver a fullmarcas.cl',
    'url' => '/'
  ];

  $logo = isset($logo) && !empty($logo) ? $logo : $test_logo;
  $back_button = isset($back_button) && !empty($back_button) ? $back_button : [];
@endphp

<header class="header header--secondary">
  <div class="header__container container">

    @if(isset($logo) && !empty($logo))
    <a href="/" class="header__logo" target="_self">
      <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" width="200" height="76" />
    </a>
    @endif

    @if(isset($back_button) && !empty($back_button))
    <a
      class="header__back-link"
      href="{{ $back_button['url'] }}"
      target="{{ $back_button['target'] ?? '_self' }}"
      @if(($back_button['target'] ?? '_self') == '_blank')
      rel="noopener noreferrer"
      @endif
    >
      {{ $back_button['title'] }}
    </a>
    @endif

  </div>
</header>
