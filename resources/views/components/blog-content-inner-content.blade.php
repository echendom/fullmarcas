@php
  $inner_content = isset($inner_content) && !empty($inner_content) ? $inner_content : [];
@endphp

@if(!empty($inner_content))
<div class="blog-content__inner-content">
  @if(isset($inner_content['subheading']) && !empty($inner_content['subheading']))
  <h2 class="blog-content__subheading">
    {{ $inner_content['subheading'] }}
  </h2>
  @endif
  @if(isset($inner_content['subcontent']) && !empty($inner_content['subcontent']))
  <div class="blog-content__subcontent paragraph">
    {!! $inner_content['subcontent'] !!}
  </div>
  @endif
</div>
@endif
