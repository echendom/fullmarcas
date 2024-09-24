@extends('layouts.default')

@section('content')
  @include('components.hero-blog', [
    'title' => 'Blog',
    'highlighted_posts' => [
      [
        'thumbnail' => [
          'url' => themosis_assets() . '/images/hand-with-icecream.png',
          'alt' => 'Mano con vaso de helado'
        ],
        'tags' => [
          [
            'color' => '#CCF',
            'text' => 'Pequeñas empresas'
          ],
          [
            'color' => '#B8E5B8',
            'text' => 'Novedades'
          ],
          [
            'color' => '#98E4E4',
            'text' => 'Consejos'
          ]
        ],
        'date' => '10/10/2010',
        'title' => 'Marca tu éxito: El ABC del registro de marcas en Chile',
        'description' => '<p>Asegura tu marca y avanza con tu emprendimiento sin complicaciones por el proceso legal. Conoce todo del proceso y más en el siguiente artículo.</p>',
        'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile/'
      ],
      [
        'thumbnail' => [
          'url' => themosis_assets() . '/images/hand-with-icecream.png',
          'alt' => 'Mano con vaso de helado'
        ],
        'tags' => [
          [
            'color' => '#CCF',
            'text' => 'Pequeñas empresas'
          ],
          [
            'color' => '#B8E5B8',
            'text' => 'Novedades'
          ],
          [
            'color' => '#98E4E4',
            'text' => 'Consejos'
          ]
        ],
        'date' => '10/10/2010',
        'title' => '¿Por qué es importante proteger mi marca?',
        'description' => '<p>Asegura tu marca y avanza con tu emprendimiento sin complicaciones por el proceso legal. Conoce todo del proceso y más en el siguiente artículo.</p>',
        'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile/'
      ],
    ]
  ])
  @include('components.blog-listing', [
    'categories' => [
      [
        'slug' => 'pequenas-empresas',
        'label' => 'Pequeñas empresas'
      ],
      [
        'slug' => 'novedades',
        'label' => 'Novedades'
      ],
      [
        'slug' => 'consejos',
        'label' => 'Consejos'
      ],
    ],
    'action' => 'blog',
    'emptystate' => [
      'image' => [
        'url' => themosis_assets() . '/images/skyblue_folder-search.svg',
        'alt' => 'Icono de carpeta con lupa'
      ],
      'heading' => 'No se encontraron resultados',
      'description' => '<p>Estamos en blanco aquí. Intenta ajustar tu búsqueda o explora nuestras categorías para encontrar contenido interesante.</p>'
    ]
  ])
@endsection
