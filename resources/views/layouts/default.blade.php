<!DOCTYPE html>
<html lang="es">
<head>
  @include('helpers.gtm-head')
  @include('helpers.google-analytics')
  @include('helpers.robots')

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  @include('helpers.favicons')
  @include('helpers.hotjar')
  @include('helpers.facebook-pixel')

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

  @wp_head

  <script>
    const themosis_assets = '{{ themosis_assets() }}';
  </script>
</head>

<body {{ body_class('body') }}>
  @include('helpers.gtm-body')

  @stack('modals')
  @php
  $header = get_field('header', 'option');
  $footer = get_field('footer', 'option');

  $header = (new App\Models\Post())->getHeader($header);
  $footer = (new App\Models\Post())->getFooter($footer);
@endphp
  <div class="site wrapper" id="app">
    <div class="site__header">
      @include('components.header-default', $header)
    </div>

    <div class="site__content">
      @yield("content")
    </div>

    <div class="site__footer">
      @include('components.footer-default', $footer)
    </div>
  </div>

  @wp_footer
  @include('helpers.google-maps-script')
  <script src="{{mix('/js/manifest.js')}}"></script>
  <script src="{{mix('/js/vendor.js')}}"></script>
  <script src="{{mix('/js/app.js')}}"></script>
  @include('helpers.chatbot-hubspot')
  @stack('scripts')
</body>
</html>
