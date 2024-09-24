@php
  $title = isset($title) && !empty($title) ? $title : '';
  $last_updated = isset($last_updated) && !empty($last_updated) ? $last_updated : '';
  $content = isset($content) && !empty($content) ? $content : '';
@endphp

<section class="terms-and-policies">
  <div class="terms-and-policies__header">
    <div class="terms-and-policies__header-content">
      @if(!empty($title))
      <h1 class="terms-and-policies__title">
        {{ $title }}
      </h1>
      @endif
      @if(!empty($last_updated))
      <span class="terms-and-policies__last-updated">
        Actualizado el: {{ $last_updated }}
      </span>
      @endif
    </div>
  </div>
  <div class="terms-and-policies__content paragraph">
    {!! $content !!}
  </div>
</section>
