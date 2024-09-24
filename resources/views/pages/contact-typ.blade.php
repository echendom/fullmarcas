@extends('layouts.default')

@section('content')
  @include('components.general-typ', [
    'pretitle' => '',
    'icon' => [],
    'title' => '¡Gracias por contactarnos!',
    'subtitle' => '',
    'description' => '
      <p>
        Hemos recibido tu mensaje. Nuestro equipo se pondrá en contacto contigo en breve para brindarte la ayuda que necesitas.
      </p>
      <p>
        Mientras tanto, te invitamos a revisar nuestra sección de <a href="/centro-de-ayuda#preguntas-frecuentes">preguntas frecuentes</a>, donde hemos recopilado algunas de las preguntas más comunes que recibimos y podrás encontrar respuestas rápidas y claras.
      </p>
    ',
    'primary_button' => [
      'title' => 'Ir a Preguntas Frecuentes',
      'url' => '/centro-de-ayuda#preguntas-frecuentes'
    ],
    'secondary_button' => [],
    'image' => [
      'url' => themosis_assets() . '/images/man_with_phone.jpg',
      'alt' => 'Hombre con celular'
    ]
  ])
@endsection
