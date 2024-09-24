@php
  $introduction = isset($introduction) && !empty($introduction) ? $introduction : '';
@endphp

@if(!empty($introduction))
<div class="blog-content__introduction paragraph--large">
  {!! $introduction !!}
</div>
@endif
