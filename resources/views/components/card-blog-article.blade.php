@php
  $data = isset($data) && !empty($data) ? $data : [];
  $animate = isset($animate) ? $animate : false;

  $url = isset($data['url']) && !empty($data['url']) ? $data['url'] : [];
  $thumbnail = isset($data['thumbnail']) && !empty($data['thumbnail']) ? $data['thumbnail'] : [];
  $tags = isset($data['tags']) && !empty($data['tags']) ? $data['tags'] : [];
  $date = isset($data['date']) && !empty($data['date']) ? $data['date'] : [];
  $title = isset($data['title']) && !empty($data['title']) ? $data['title'] : [];

  $default_thumbnail = themosis_assets() . '/images/white_photo-off.svg';
@endphp

<article class="card--blog @if($animate) gsap-scrollreveal--horizontal @endif">
  <a href="{{ $data['url'] }}" class="card__thumbnail-link">
    @if(
      !empty($thumbnail) &&
      isset($thumbnail['url']) &&
      !empty($thumbnail['url'])
    )
    <img
      class="card__thumbnail"
      src="{{ $thumbnail['url'] }}"
      alt="{{ $thumbnail['alt'] ?? 'Imagen del articulo' }}"
      width="470"
      height="310"
    />
    @else
    <img
      class="card__thumbnail-off"
      src="{{ $default_thumbnail }}"
      alt="Imagen por defecto"
      role="presentation"
      width="80"
      height="80"
    />
    @endif
  </a>
  <div class="card__body">
    @if(!empty($tags))
    <div class="card__tags">
      @foreach($tags as $tag)
      <span class="card__tag" style="--bg-color: {{ $tag['color'] }}">
        {{ $tag['text'] }}
      </span>
      @endforeach
    </div>
    @endif
    @if(!empty($date))
    <span class="card__date">
      Fecha de publicación: {{ $date }}
    </span>
    @endif
    @if(!empty($title))
    <h3 class="card__title">
      <a href="{{ $url }}" class="card__title-link">
        {{ $title }}
      </a>
    </h3>
    @endif
    @if(!empty($url))
    <a href="{{ $url }}" class="card__link">
      Leer más
    </a>
    @endif
  </div>
</article>