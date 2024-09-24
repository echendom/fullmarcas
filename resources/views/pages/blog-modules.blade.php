@extends('layouts.default')

@section('content')
    <section class="blog-content">
        <div class="blog-content__animated-background">
            <img class="blog-content__animated-lock animated-background__white-lock image-no-touch" src="{{ $white_lock }}"
                alt="Candado blanco" role="presentation" width="450" height="640" />
            <img class="blog-content__animated-lock animated-background__white-lock image-no-touch" src="{{ $white_lock }}"
                alt="Candado blanco" role="presentation" width="450" height="640" />
        </div>
        <div class="blog-content__container container">
            @if (!empty($link_back))
                <a class="blog-content__back-link" href="{{ $link_back['url'] }}">
                    <img class="blog-content__back-icon" src="{{ $arrow_back }}" alt="Icono volver" width="20"
                        height="20" />
                    {{ $link_back['title'] }}
                </a>
            @endif
            @if (!empty($thumbnail))
                <img class="blog-content__thumbnail" src="{{ $thumbnail['url'] }}"
                    alt="{{ $thumbnail['alt'] ?? 'Thumbnail' }}" width="1130" height="550" />
            @endif
            <div class="blog-content__content">
                <div class="blog-content__header">
                    @if (!empty($tags) || !empty($date))
                        <div class="blog-content__tags-date">
                            @if (!empty($tags))
                                <div class="blog-content__tags">
                                    @foreach ($tags as $tag)
                                        <span class="blog-content__tag common--tag"
                                            style="--tag-color: {{ $tag['color'] }}">
                                            {{ $tag['text'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($date))
                                <span class="blog-content__date">Fecha de publicación: {{ $date }}</span>
                            @endif
                        </div>
                    @endif
                    @if (!empty($title))
                        <h1 class="blog-content__title">
                            {{ $title }}
                        </h1>
                    @endif
                    @if (!empty($author_info))
                        <div class="blog-content__author">
                            @if (isset($author_info['image']) &&
                                    !empty($author_info['image']) &&
                                    isset($author_info['image']['url']) &&
                                    !empty($author_info['image']['url']))
                                <img class="blog-content__author-image" src="{{ $author_info['image']['url'] }}"
                                    alt="{{ $author_info['image']['alt'] ?? 'Autor del artículo' }}" width="80"
                                    height="80" loading="lazy" />
                            @endif
                            <div class="blog-content__author-info">
                                @if (isset($author_info['name']) && !empty($author_info['name']))
                                    <span class="blog-content__author-name">
                                        {{ $author_info['name'] }}
                                    </span>
                                @endif
                                @if (isset($author_info['role']) && !empty($author_info['role']))
                                    <span class="blog-content__author-role">
                                        {{ $author_info['role'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="blog-content__body">
                    @if (isset($fields['layout_modules']) && !empty($fields['layout_modules']))
                        @foreach ($fields['layout_modules'] as $key => $module)
                            @if ($module['acf_fc_layout'])
                                @if (isset($module['inside']) && $module['inside'])
                                    @php
                                        unset($fields['layout_modules'][$key]);
                                    @endphp
                                    @include('components.' . $module['acf_fc_layout'], $module)
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="blog-content__share">
                <h2 class="blog-content__share-title">
                    Comparte este artículo
                </h2>
                <div class="blog-content__share-buttons">
                    @foreach ($share_links as $share_link)
                        <a class="blog-content__share-button" href="{{ $share_link['url'] }}"
                            target="{{ $share_link['target'] ?? '_self' }}"
                            @if (($share_link['target'] ?? '_self') == '_blank') rel="noopener noreferrer" @endif
                            style="
            --border-color: {{ $share_link['border_color'] ?? '' }};
            --bg-color: {{ $share_link['background_color'] ?? '' }};
            --text-color: {{ $share_link['text_color'] ?? '' }};
            --text-color-hover: {{ $share_link['text_color_hover'] ?? '' }};
          ">
                            @if (isset($share_link['icon']) &&
                                    !empty($share_link['icon']) &&
                                    isset($share_link['icon']['url']) &&
                                    !empty($share_link['icon']['url']))
                                <img class="blog-content__share-icon img-to-svg" src="{{ $share_link['icon']['url'] }}"
                                    alt="{{ $share_link['icon']['alt'] ?? 'Icono social' }}" width="20" height="20"
                                    loading="lazy" />
                            @endif
                            @if (isset($share_link['title']) && !empty($share_link['title']))
                                {{ $share_link['title'] }}
                            @endif
                        </a>
                    @endforeach
                    <button class="blog-content__share-button"
                        style="
            --border-color: #8020A6;
            --bg-color: #F4E3EB;
            --text-color: #090909;
            --text-color-hover: #FFF;
          ">
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
    @if (isset($fields['layout_modules']) && !empty($fields['layout_modules']))
        @foreach ($fields['layout_modules'] as $module)
            @if ($module['acf_fc_layout'])
                @include('components.' . $module['acf_fc_layout'], $module)
            @endif
        @endforeach
    @endif
    {{-- 
    @include('components.blog-listing-inline', [
        'title' => 'Artículos relacionados',
        'items' => [
            [
                'thumbnail' => [
                    'url' => themosis_assets() . '/images/thumbnail_article-1.png',
                    'alt' => 'Persona en computadora',
                ],
                'tags' => [
                    [
                        'color' => '#CCF',
                        'text' => 'Pequeñas empresas',
                    ],
                    [
                        'color' => '#B8E5B8',
                        'text' => 'Novedades',
                    ],
                    [
                        'color' => '#98E4E4',
                        'text' => 'Consejos',
                    ],
                ],
                'date' => '10/10/2010',
                'title' => 'Marca tu éxito: El ABC del registro de marcas en Chile',
                'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
            ],
            [
                'thumbnail' => [
                    'url' => themosis_assets() . '/images/thumbnail_article-2.png',
                    'alt' => 'Dos personas decorando productos de floristeria',
                ],
                'tags' => [
                    [
                        'color' => '#98E4E4',
                        'text' => 'Consejos',
                    ],
                ],
                'date' => '10/10/2010',
                'title' => '¿Por qué es importante proteger mi marca?',
                'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
            ],
            [
                'thumbnail' => [
                    'url' => themosis_assets() . '/images/thumbnail_article-3.png',
                    'alt' => 'Persona de negocios en llamada',
                ],
                'tags' => [
                    [
                        'color' => '#EAEA83',
                        'text' => 'Historias',
                    ],
                    [
                        'color' => '#98E4E4',
                        'text' => 'Consejos',
                    ],
                ],
                'date' => '10/10/2010',
                'title' => 'Errores Comunes al registrar una marca y cómo evitarlos',
                'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
            ],
        ],
        'link' => [
            'url' => '/blog-listing-page',
            'title' => 'Ver todas las entradas publicadas',
            'target' => '_self',
        ],
    ]) --}}
@endsection
