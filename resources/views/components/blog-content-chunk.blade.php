@php
  $content = isset($content) && !empty($content) ? $content : '';
@endphp

@if(!empty($content))
<div class="blog-content__content-chunk paragraph">
  {!! $content !!}
</div>
@endif
