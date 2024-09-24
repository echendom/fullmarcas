@extends('layouts.default')

@section('content')
  @include('components.hero-page', [
    'title' => 'Quiénes somos',
    'subheading' => 'Acerca de nosotros',
    'description' => '<p>En Full Marcas contamos con un equipo multidisciplinario  especializado en Propiedad Intelectual que busca educar, informar, empoderar y acompañar a los emprendedores en el proceso de registro y en la protección de sus marcas y nombres de dominio de Internet.</p>',
    'image' => [
      'url' => themosis_assets() . '/images/couple-with-computer.png',
      'alt' => 'Una pareja con computadora'
    ],
    // Allowed values for variant are 'secondary' and 'primary'. Default value is 'primary'.
    // 
    // In primary variant, height is defined by how tall the content is,
    // and the image overflows below the component if it is taller than the component itself.
    // Image size for primary variant is 480px wide and 420px high.
    // 
    // In the secondary variant, image is inside the component layout (does not overflow).
    // Image size for this variant is 480px wide and 400px high.
    'variant' => 'secondary'
  ])
	@include('components.features', [
		'title' => 'Nuestras cifras',
		'description' => '<p>Somos un equipo multidisciplinario y altamente calificado, dedicados a proteger y fortalecer las marcas de emprendedores a través de servicios de excelencia a un precio conveniente.</p>',
		'items' => [
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_user-hexagon.svg',
					'alt' => 'icono usuario'
				],
				'color' => '#B8E5B8',
				'title' => 'XX+ Clientes',
				'description' => '<p>Han confiado en nosotros, protegiendo sus marcas a través de nuestros servicios para fortalecer sus emprendimientos.</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_building.svg',
					'alt' => 'icono edificio'
				],
				'color' => '#98E4E4',
				'title' => 'XX+ Marcas comerciales registradas ',
				'description' => '<p>Marcas han finalizado de manera exitosa su proceso de registro con nosotros. ¡Súmate a la experiencia Full Marcas!</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_heart-handshake.svg',
					'alt' => 'icono corazon'
				],
				'color' => '#CCCCFF',
				'title' => '10+ Años de experiencia',
				'description' => '<p>Contamos con una sólida trayectoria y una amplia experiencia en Propiedad Intelectual, lo que nos permite brindar una asesoría de excelencia y  proteger adecuadamente tu marca comercial.</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_award.svg',
					'alt' => 'icono recompensa'
				],
				'color' => '#FFCCCC',
				'title' => 'XX% de ahorro ',
				'description' => '<p>Ofrecemos uno de los precios más accesibles y competitivos del mercado, sin sorpresas ni letra chica que aumente los costos para tu negocio.</p>'
			],
		],
		// Allowed value for variant are 'primary' and 'secondary'. Default value is 'primary'.
		// In the primary variant, items don't have border and box-shadow,
		// whereas in the secondary variant, items do.
		'variant' => 'primary'
	])
  @include('components.our-history', [
    'pretitle' => 'Nuestra historia',
		'title' => 'Nuestros clientes dicen de nosotros',
		'items' => [
			[
				'image' => [
					'url' => themosis_assets() . '/images/team.png',
					'alt' => 'Equipo'
				],
				'tag' => '2019',
				'title' => 'Comienzo profesional',
				'description' => '<p>Somos Rodrigo y Catalina, abogado y periodista de profesión. Nos conocimos trabajando en uno de los mejores estudios de abogados del área de Propiedad Intelectual en Chile. Ahí, fuimos profundizando nuestros conocimientos en el área y en el proceso de registro, defensa y vigilancia de una marca.</p>'
			],
			[
				'image' => [
					'url' => themosis_assets() . '/images/team-2.png',
					'alt' => 'Equipo en reunion de mesa'
				],
				'tag' => '2024',
				'title' => 'Comienzo Full Marcas',
				'description' => '<p>Tiempo después, surge la idea de crear un servicio más cercano y ameno para que los emprendedores pudieran no solo registrar su marca, sino que también acceder a muchos servicios relacionados e ir a la vez aprendiendo de esta materia.</p>'
			],
			[
				'image' => [
					'url' => themosis_assets() . '/images/notebook-with-coffee.png',
					'alt' => 'Laptop con cafe'
				],
				'tag' => '2024',
				'title' => 'Objetivos a futuro',
				'description' => '<p>Queremos que este proceso sea una oportunidad para aprender y crecer en el campo de la Propiedad Intelectual. Nuestro compromiso es acompañarte en cada paso del camino, desde el registro de tu marca, hasta su protección y crecimiento continuo.</p>'
			],
			[
				'image' => [],
				'tag' => '2019',
				'title' => 'Comienzo profesional',
				'description' => '<p>Somos Rodrigo y Catalina, abogado y periodista de profesión. Nos conocimos trabajando en uno de los mejores estudios de abogados del área de Propiedad Intelectual en Chile. Ahí, fuimos profundizando nuestros conocimientos en el área y en el proceso de registro, defensa y vigilancia de una marca.</p>'
			],
			[
				'image' => [
					'url' => themosis_assets() . '/images/team-2.png',
					'alt' => 'Equipo en reunion de mesa'
				],
				'tag' => '2024',
				'title' => 'Comienzo Full Marcas',
				'description' => '<p>Tiempo después, surge la idea de crear un servicio más cercano y ameno para que los emprendedores pudieran no solo registrar su marca, sino que también acceder a muchos servicios relacionados e ir a la vez aprendiendo de esta materia.</p>'
			]
		]
  ])
@endsection
