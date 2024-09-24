@extends('layouts.default')

@section('content')
  @include('components.hero-page', [
    'title' => 'Qué hacemos',
    'subheading' => '¿Qué hacemos en Full Marcas?',
    'description' => '<p>Estamos comprometidos con la <strong>protección de la identidad comercial de tu negocio o emprendimiento, ofreciéndote servicios y asesorías de excelencia</strong> a un precio conveniente para el registro y vigilancia de tu marca. Al trabajar con nuestro equipo podrás resguardar tus signos distintivos, protegiendo al público de posibles confusiones con productos o servicios de tu competencia.</p>',
    'image' => [
      'url' => themosis_assets() . '/images/sitting-person-with-computer.png',
      'alt' => 'Persona sentada con computadora'
    ],
    // Allowed values for variant are 'secondary' and 'primary'. Default value is 'primary'.
    // 
    // In primary variant, height is defined by how tall the content is,
    // and the image overflows below the component if it is taller than the component itself.
    // Image size for primary variant is 480px wide and 420px high.
    // 
    // In the secondary variant, image is inside the component layout (does not overflow).
    // Image size for this variant is 480px wide and 400px high.
    'variant' => 'primary'
  ])
	@include('components.step-by-step', [
		'title' => 'Paso a paso <strong>Así de fácil</strong>',
		'description' => '<p>En Full Marcas te brindamos seguridad y protección legal junto a un monitoreo completo siguiendo estos pasos.</p>',
		'steps' => [
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_list-search.svg',
					'alt' => 'Icono lupa en lista'
				],
				'color' => '#B8E5B8',
				'description' => 'Análisis de distintividad y búsqueda de disponibilidad'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_forms.svg',
					'alt' => 'Icono campo de búsqueda'
				],
				'color' => '#98E4E4',
				'description' => 'Presentación de solicitud ante INAPI'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_file-text.svg',
					'alt' => 'Icono archivo de texto'
				],
				'color' => '#CCCCFF',
				'description' => 'Examen de forma'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_mail-check.svg',
					'alt' => 'Icono correo con verificación'
				],
				'color' => '#FFCCCC',
				'description' => 'Aceptación a trámite y publicación en el Diario Oficial'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_file-smile.svg',
					'alt' => 'Icoono archivo con carita feliz'
				],
				'color' => '#F2D27E',
				'description' => 'Examen de Fondo y Demandas de Oposición'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_certificate.svg',
					'alt' => 'Icono certificado'
				],
				'color' => '#88B8E5',
				'description' => 'Aceptación a registro y Obtención de Certificado o Título'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_eye.svg',
					'alt' => 'Icono ojo'
				],
				'color' => '#EAEA83',
				'description' => 'Vigilancia y custodia'
			]
		],
		'link' => [
			'url' => '/',
			'title' => 'Conocer más sobre lo que hacemos',
			'target' => '_self'
		]
	])
	@include('components.content-with-image', [
		'image' => [
			'url' => themosis_assets() . '/images/girl-with-binoculars.png',
			'alt' => 'Chica con binoculares'
		],
		'title' => 'Vigilancia y custodia',
		'description' => 'Ofrecemos servicios para el <strong>monitoreo en línea de tu marca registrada</strong>, comunicándote toda actividad relacionada con su vigencia y renovación. Además, monitoreamos la presentación de nuevas solicitudes para signos idénticos o similares a tu marca y poder evitar su registro, protegiendo la identidad de tu emprendimiento. '
	])
	@include('components.features', [
		'title' => '¿Por qué elegir Full Marcas?',
		'description' => '<p>Ofrecemos un <strong>servicio rápido, accesible y cercano</strong>, donde no sólo podrás registrar tu marca de manera efectiva, sino que también acceder a servicios destinados a protegerla durante su vigencia.</p>',
		'items' => [
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_user-hexagon.svg',
					'alt' => 'icono usuario'
				],
				'color' => '#B8E5B8',
				'title' => 'Experiencia y conocimiento',
				'description' => '<p>Nuestro equipo conformado por expertos en Propiedad Intelectual, cuentan con los conocimientos técnicos y la experiencia para lograr con éxito el registro y la protección de tu marca.</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_building.svg',
					'alt' => 'icono edificio'
				],
				'color' => '#98E4E4',
				'title' => 'Asesoría legal integral',
				'description' => '<p>Nuestros servicios no solo se limitan a registrar con éxito tu marca, también te acompañamos durante toda su vigencia a través de nuestra asesoría legal completa.</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_heart-handshake.svg',
					'alt' => 'icono corazon'
				],
				'color' => '#CCCCFF',
				'title' => 'Gestión de trámites y documentación',
				'description' => '<p>Nos encargamos de gestionar el registro y la custodia de tu marca, obteniendo todos los certificados, títulos y comprobantes asociados.</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_award.svg',
					'alt' => 'icono recompensa'
				],
				'color' => '#FFCCCC',
				'title' => 'Vigilancia y custodia permanente',
				'description' => '<p>Te acompañamos en su protección, a través del envío de avisos y alertas para su renovación y para impedir que otras personas o tu competencia registren signos idénticos.</p>'
			],
		],
		// Allowed value for variant are 'primary' and 'secondary'. Default value is 'primary'.
		// In the primary variant, items don't have border and box-shadow,
		// whereas in the secondary variant, items do.
		'variant' => 'secondary'
	])
	@include('components.gradient-with-cta', [
		'image' => [
			'url' => themosis_assets() . '/images/man-pointing-left.png',
			'alt' => 'Hombre apuntando a la izquierda'
		],
		'title' => 'Descubre qué tan viable es el registro de tu marca, de forma gratuita',
		'description' => '<p>Antes de iniciar el proceso para el registro de tu marca, te ofrecemos una búsqueda de disponibilidad a través de nuestro buscador inteligente actualizado según la base de datos de INAPI y una evaluación preliminar de su distintividad, para determinar qué tan factible es su inscripción.</p>',
		'link' => [
			'title' => 'Registrar mi marca',
			'url' => '/registra-tu-marca',
			'target' => '_self'
		],
		// Allowed values for variant are 'primary' and 'secondary'. Default value is 'primary'
		// In the primary variant, the image is placed at the left,
		// and it is 250px wide and 315px high.
		// 
		// In the secondary variant, the image is placed at the right,
		// and it is 360px wide and 330px high
		'variant' => 'secondary'
	])
	@include('components.faq-accordions', [
		'title' => 'Preguntas frecuentes',
		'description' => 'Revisa las siguientes preguntas sobre el proceso de registro de marca',
		'items' => [
			[
				'heading' => '¿Por qué es importante registrar mi marca comercial?',
				'content' => '<p>Al proteger tu marca a través de su registro ante el Instituto Nacional de Propiedad Industrial (INAPI) adquieres, como su titular, un <strong>derecho exclusivo y excluyente para impedir que otros registren o usen una expresión idéntica o similar para identificar en el mercado los mismos productos y/o servicios.</strong></p>'
			],
			[
				'heading' => '¿A qué riesgos me expongo si no registro mi marca?',
				'content' => '
					<p>
						Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,<strong>consectetur, adipisci velit</strong>.
						<ul>
							<li>
								What is Lorem Ipsum?
							</li>
							<li>
								Why do we use it?
							</li>
							<li>
								Where does it come from?
							</li>
							<li>
								Where can I get some?
							</li>
						</ul>
					</p>
				'
			],
			[
				'heading' => '¿Por qué es importante realizar un análisis de factibilidad antes de solicitar el registro de mi marca comercial?',
				'content' => '
					<p>
						Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,<strong>consectetur, adipisci velit</strong>.
						<ol>
							<li>
								What is Lorem Ipsum?
							</li>
							<li>
								Why do we use it?
							</li>
							<li>
								Where does it come from?
							</li>
							<li>
								Where can I get some?
							</li>
						</ol>
					</p>
				'
			],
			[
				'heading' => '¿Por cuánto tiempo me protege el registro de mi marca?',
				'content' => '<p>
						Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,<strong>consectetur, adipisci velit</strong>.
					</p><br />
					<a href="/">test link</a>
				'
			],
			[
				'heading' => '¿Cuál es el costo de registrar mi marca?',
				'content' => '<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,<strong>consectetur, adipisci velit</strong>.</p>'
			],
			[
				'heading' => '¿Cuánto dura el proceso de registro?',
				'content' => '<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,<strong>consectetur, adipisci velit</strong>.</p>'
			]
		]
	])
@endsection
