@php
  $video_id = isset($video_id) && !empty($video_id) ? $video_id : '';
@endphp

@if(!empty($video_id))
<div class="blog-content__video">
  <iframe src="https://www.youtube.com/embed/{{$video_id}}" frameborder="0" allowfullscreen></iframe>
</div>
@endif