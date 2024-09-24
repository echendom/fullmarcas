@extends('layouts.default')

@section('content')
  @include('components.help-center', [
    'title' => 'Centro de ayuda',
    'typ' => '/contacto-gracias',
    'faq_tab' => [
      'title' => 'Preguntas frecuentes',
      'categories' => [
        [
          'title' => 'Todas las categorías',
          'icon' => [
            'url' => themosis_assets() . '/images/icons/black_triangle-square-circle.svg',
            'alt' => 'Icono figuras geométricas'
          ],
          'questions' => [
            [
              'title' => '¿Por qué es importante registrar mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Cuál es el costo de registrar mi marca?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿A qué riesgos me expongo si no registro mi marca?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por cuánto tiempo me protege el registro de mi marca?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Qué debo considerar antes de solicitar el registro de mi marca?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ]
          ]
        ],
        [
          'title' => 'Categoría 1',
          'icon' => [
            'url' => themosis_assets() . '/images/icons/black_walk.svg',
            'alt' => 'Figura de persona caminando'
          ],
          'questions' => [
            [
              'title' => '¿Por qué es importante registrar mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ]
          ]
        ],
        [
          'title' => 'Categoría 2',
          'icon' => [
            'url' => themosis_assets() . '/images/icons/black_vocabulary.svg',
            'alt' => 'Figura de libro'
          ],
          'questions' => [
            [
              'title' => '¿Por qué es importante registrar mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ]
          ]
        ],
        [
          'title' => 'Categoría 3',
          'icon' => [
            'url' => themosis_assets() . '/images/icons/black_registered.svg',
            'alt' => 'Símbolo registrado'
          ],
          'questions' => [
            [
              'title' => '¿Por qué es importante registrar mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ]
          ]
        ],
        [
          'title' => 'Categoría 4',
          'icon' => [
            'url' => themosis_assets() . '/images/icons/black_device-laptop.svg',
            'alt' => 'Figura de computador'
          ],
          'questions' => [
            [
              'title' => '¿Por qué es importante registrar mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ],
            [
              'title' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
              'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios. </p>'
            ]
          ]
        ]
      ]
    ],
    'contact_tab' => [
      'title' => 'Contacto',
      'terms' => [
        'url' => '/',
        'target' => '_blank'
      ],
      'button_text' => 'Enviar mensaje',
      'info' => [
        'title' => '¿Dónde encontrarnos?',
        'address' => [
          'title' => 'Gran Santiago, Región Metropolitana de Santiago, Chile',
          'url' => 'https://maps.app.goo.gl/ntYm7vMdFg9PiHJ98',
          'target' => '_blank'
        ],
        'phone' => '+56 9 1234 5678',
        'whatsapp' => '+56 9 1234 5678',
        'email' => 'contacto@fullmarcas.cl'
      ]
    ]
  ])
@endsection
