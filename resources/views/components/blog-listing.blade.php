@php
  $categories = isset($categories) && !empty($categories) ? $categories : [];
  $emptystate = isset($emptystate) && !empty($emptystate) ? $emptystate : [];
  $action = isset($action) && !empty($action) ? $action : 'blog';
@endphp

<v-blog-listing
  :categories="{{json_encode($categories)}}"
  :emptystate="{{json_encode($emptystate)}}"
  :action="{{json_encode($action)}}"
></v-blog-listing>
