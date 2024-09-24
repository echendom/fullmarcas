@php
  /*
    Variables
  */
  $link_back = isset($link_back) && !empty($link_back) ? $link_back : [];
  $thumbnail = isset($thumbnail) && !empty($thumbnail) ? $thumbnail : [];
  $tags = isset($tags) && !empty($tags) ? $tags : [];
  $date = isset($date) && !empty($date) ? $date : '';
  $title = isset($title) && !empty($title) ? $title : '';
  $author_info = isset($author_info) && !empty($author_info) ? $author_info : [];
  $introduction = isset($introduction) && !empty($introduction) ? $introduction : '';
  $content = isset($content) && !empty($content) ? $content : '';
  $image_gallery = isset($image_gallery) && !empty($image_gallery) ? $image_gallery : [];
  $inner_content = isset($inner_content) && !empty($inner_content) ? $inner_content : [];
  $blockquote = isset($blockquote) && !empty($blockquote) ? $blockquote : [];
  $video_id = isset($video_id) && !empty($video_id) ? $video_id : '';
  $links_of_interest = isset($links_of_interest) && !empty($links_of_interest) ? $links_of_interest : [];
  $share_links = isset($share_links) && !empty($share_links) ? $share_links : [];

  /*
    Assets
  */
  $arrow_back = themosis_assets() . '/images/icons/gray_arrow-left.svg';
  $quote_icon = themosis_assets() . '/images/icons/black_quote_icon.svg';
  $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
  $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';
  $external_icon = themosis_assets() . '/images/icons/white_external-link.svg';
  $white_lock = themosis_assets() . '/images/white_lock.svg';

  $copy_icon = themosis_assets() . '/images/icons/black_icon_copy.svg';
@endphp

<section class="blog-content">
  <div class="blog-content__animated-background">
    <img
      class="blog-content__animated-lock animated-background__white-lock image-no-touch"
      src="{{ $white_lock }}"
      alt="Candado blanco"
      role="presentation"
      width="450"
      height="640"
    />
    <img
      class="blog-content__animated-lock animated-background__white-lock image-no-touch"
      src="{{ $white_lock }}"
      alt="Candado blanco"
      role="presentation"
      width="450"
      height="640"
    />
  </div>
  <div class="blog-content__container container">
    @if(!empty($link_back))
    <a class="blog-content__back-link" href="{{$link_back['url']}}">
      <img
        class="blog-content__back-icon"
        src="{{ $arrow_back }}"
        alt="Icono volver"
        width="20"
        height="20"

      />
      {{$link_back['title']}}
    </a>
    @endif
    @if(!empty($thumbnail))
    <img
      class="blog-content__thumbnail"
      src="{{ $thumbnail['url'] }}"
      alt="{{ $thumbnail['alt'] ?? 'Thumbnail' }}"
      width="1130"
      height="550"
    />
    @endif
    <div class="blog-content__content">
      <div class="blog-content__header">
        @if(!empty($tags) || !empty($date))
        <div class="blog-content__tags-date">
          @if(!empty($tags))
          <div class="blog-content__tags">
            @foreach($tags as $tag)
            <span class="blog-content__tag common--tag" style="--tag-color: {{ $tag['color'] }}">
              {{ $tag['text'] }}
            </span>
            @endforeach
          </div>
          @endif
          @if(!empty($date))
          <span class="blog-content__date">Fecha de publicación: {{ $date }}</span>
          @endif
        </div>
        @endif
        @if(!empty($title))
        <h1 class="blog-content__title">
          {{ $title }}
        </h1>
        @endif
        @if(!empty($author_info))
        <div class="blog-content__author">
          @if(
            isset($author_info['image']) &&
            !empty($author_info['image']) &&
            isset($author_info['image']['url']) &&
            !empty($author_info['image']['url'])
          )
          <img
            class="blog-content__author-image"
            src="{{ $author_info['image']['url'] }}"
            alt="{{ $author_info['image']['alt'] ?? 'Autor del artículo' }}"
            width="80"
            height="80"
            loading="lazy"
          />
          @endif
          <div class="blog-content__author-info">
            @if(
              isset($author_info['name']) &&
              !empty($author_info['name'])
            )
            <span class="blog-content__author-name">
              {{ $author_info['name'] }}
            </span>
            @endif
            @if(
              isset($author_info['role']) &&
              !empty($author_info['role'])
            )
            <span class="blog-content__author-role">
              {{ $author_info['role'] }}
            </span>
            @endif
          </div>
        </div>
        @endif
      </div>
      <div class="blog-content__body">
        @include('components.blog-content-introduction', ['introduction' => $introduction])
        @include('components.blog-content-chunk', ['content' => $content])
        @include('components.blog-content-image-gallery', ['image_gallery' => $image_gallery])
        @include('components.blog-content-inner-content', ['inner_content' => $inner_content])
        @include('components.blog-content-blockquote', ['blockquote' => $blockquote])
        @include('components.blog-content-video', ['video_id' => $video_id])
        @include('components.blog-content-links-of-interest', ['links_of_interest' => $links_of_interest])
      </div>
    </div>
    <div class="blog-content__share">
      <h2 class="blog-content__share-title">
        Comparte este artículo
      </h2>
      <div class="blog-content__share-buttons">
        @foreach($share_links as $share_link)
        <a
          class="blog-content__share-button"
          href="{{ $share_link['url'] }}"
          target="{{ $share_link['target'] ?? '_self' }}"
          @if(($share_link['target'] ?? '_self') == '_blank')
          rel="noopener noreferrer"
          @endif
          style="
            --border-color: {{$share_link['border_color'] ?? ''}};
            --bg-color: {{$share_link['background_color'] ?? ''}};
            --text-color: {{$share_link['text_color'] ?? ''}};
            --text-color-hover: {{$share_link['text_color_hover'] ?? ''}};
          "
        >
          @if(
            isset($share_link['icon']) &&
            !empty($share_link['icon']) &&
            isset($share_link['icon']['url']) &&
            !empty($share_link['icon']['url'])
          )
          <img
            class="blog-content__share-icon img-to-svg"
            src="{{ $share_link['icon']['url'] }}"
            alt="{{ $share_link['icon']['alt'] ?? 'Icono social' }}"
            width="20"
            height="20"
            loading="lazy"
          />
          @endif
          @if(isset($share_link['title']) && !empty($share_link['title']))
          {{ $share_link['title'] }}
          @endif
        </a>
        @endforeach
        <button
          class="blog-content__share-button"
          style="
            --border-color: #8020A6;
            --bg-color: #F4E3EB;
            --text-color: #090909;
            --text-color-hover: #FFF;
          "
        >
          <img
            class="blog-content__share-icon img-to-svg"
            src="{{ $copy_icon }}"
            alt="Icono clip"
            width="20"
            height="20"
            loading="lazy"
          />
          <span class="blog-content__share-text">
            Copiar enlace
          </span>
        </button>
      </div>
    </div>
  </div>
</section>
