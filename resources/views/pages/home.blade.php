@extends('layouts.default')

@section('content')
	@include('components.hero-home', [
		'title' => 'Avanza protegido con <strong>Full Marcas</strong>',
		'description' => '<p>Somos tu partner para proteger tu marca, brindándote un servicio legal de excelencia, seguro y a un precio accesible.</p>',
		'image' => [
			'url' => themosis_assets() . '/images/home-image.png',
			'alt' => 'Persona con laptop'
		],
		'registration_link' => [
			'url' => '/registra-tu-marca',
			'title' => 'Ver factibilidad'
		],
		'features' => [
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_heart.svg',
					'alt' => 'Icono corazón'
				],
				'text' => ''
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_shield.svg',
					'alt' => 'Icono escudo'
				],
				'text' => ''
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_stairs.svg',
					'alt' => 'Icono escaleras'
				],
				'text' => ''
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_like.svg',
					'alt' => 'Icono like'
				],
				'text' => '<p>5 años de experiencia</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_check.svg',
					'alt' => 'Icono marca verificado'
				],
				'text' => '<p>Garantía de calidad</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_smile.svg',
					'alt' => 'Icono sonrisa'
				],
				'text' => '<p><strong>100%</strong> de satisfacción</p>'
			],
			[
				'icon' => [
					'url' => themosis_assets() . '/images/icons/violet_handshake.svg',
					'alt' => 'Icono manos'
				],
				'text' => '<p>Acompañamiento total</p>'
			],
		],
		'socials' => [
			[
				'url' => '/',
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_tiktok.svg',
					'alt' => 'tiktok'
				]
			],
			[
				'url' => '/',
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_instagram.svg',
					'alt' => 'instagram'
				]
			],
			[
				'url' => '/',
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_linkedin.svg',
					'alt' => 'linkedin'
				]
			],
			[
				'url' => '/',
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_youtube.svg',
					'alt' => 'youtube'
				]
			],
			[
				'url' => '/',
				'icon' => [
					'url' => themosis_assets() . '/images/icons/white_whatsapp.svg',
					'alt' => 'whatsapp'
				]
			],
		]
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
	@include('components.benefits', [
		'title' => 'Beneficios que <strong>Marcan la diferencia</strong>',
		'image' => [
			'url' => themosis_assets() . '/images/business_woman.png',
			'alt' => 'mujer de negocios'
		],
		'items' => [
			[
				'heading' => 'Vigilancia incluida por 10 años',
				'description' => '<p>Ofrecemos un servicio de vigilancia durante los 10 años de vigencia de tu marca, informándote constantemente de las nuevas solicitudes que presenten otras personas y que puedan entrar en conflicto con la tuya.</p>'
			],
			[
				'heading' => 'Aviso de renovación',
				'description' => '<p>Cuando el registro de tu marca esté pronto a vencer, te avisaremos para renovarlo.</p>'
			],
			[
				'heading' => 'Seguro Full Marcas',
				'description' => '<p>Obtienes un seguro en caso de que la marca no quede registrada. Este servicio va incluido en el paquete inicial. <a href="/">Para más información haz clic aquí.</a></p>'
			],
			[
				'heading' => 'Publicación y certificado',
				'description' => '<p>Gestionamos la publicación de tu marca comercial en el Diario Oficial y la obtención de certificados o títulos relacionados a esta ante INAPI, sin errores que alarguen el proceso.</p>'
			],
			[
				'heading' => 'Servicios con tecnología integrada',
				'description' => '<p>Integramos tecnología que nos permite brindar una asesoría de excelencia a un precio conveniente.</p>'
			]
		]
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
	@include('components.gradient-with-cta', [
		'image' => [
			'url' => themosis_assets() . '/images/enthusiastic-man.png',
			'alt' => 'Hombre entusiasmado'
		],
		'title' => 'Protege tu marca comercial con nosotros',
		'description' => '<p>Nuestros servicios te permiten registrar tu marca comercial de manera fácil y rápida, 100% online y sin costos sorpresa.</p>',
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
		'variant' => 'primary'
	])
	@include('components.testimonial-slider', [
		'pretitle' => 'Testimonios',
		'title' => 'Nuestros clientes dicen de nosotros',
		'description' => '<p>Revisa las experiencias de quienes ya confiaron en nuestros servicios</p>',
		'items' => [
			[
				'quote' => '<p>"Et lectus tortor justo urna nisl sed ❤️."</p>',
				'author_image' => [
					'url' => themosis_assets() . '/images/testimonial_carlos_perez.png',
					'alt' => 'Carlos Pérez'
				],
				'author_name' => 'Carlos Pérez',
				'author_role' => 'Gerente de Ventas at Visionary Services Group'
			],
			[
				'quote' => '<p>"Et euismod tortor mauris 👍 rutrum massa fringilla libero 🚀."</p>',
				'author_image' => [
					'url' => themosis_assets() . '/images/testimonial_laura_rodriguez.png',
					'alt' => 'Laura Rodriguez'
				],
				'author_name' => 'Laura Rodríguez',
				'author_role' => 'CEO at Innovatech Solutions'
			],
			[
				'quote' => '<p>"Cursus neque quisque egestas enim nisi neque augue dictum faucibus. Lectus tellus velit egestas malesuada."</p>',
				'author_image' => [
					'url' => themosis_assets() . '/images/testimonial_ana_garcia.png',
					'alt' => 'Ana García'
				],
				'author_name' => 'Ana García',
				'author_role' => 'Jefa de Recursos Humanos at QualityWorks'
			],
			[
				'quote' => '<p>"Cursus neque quisque egestas enim nisi neque augue dictum faucibus. Lectus tellus velit egestas malesuada."</p>',
				'author_image' => [],
				'author_name' => 'Ana García',
				'author_role' => 'Jefa de Recursos Humanos at QualityWorks'
			]
		]
	])
	@include('components.blog-listing-inline', [
		'title' => 'Últimas entradas del blog',
		'items' => [
			[
				'thumbnail' => [
					'url' => themosis_assets() . '/images/thumbnail_article-1.png',
					'alt' => 'Persona en computadora'
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
					],
				],
				'date' => '10/10/2010',
				'title' => 'Marca tu éxito: El ABC del registro de marcas en Chile',
				'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
			],
			[
				'thumbnail' => [
					'url' => themosis_assets() . '/images/thumbnail_article-2.png',
					'alt' => 'Dos personas decorando productos de floristeria'
				],
				'tags' => [
					[
						'color' => '#98E4E4',
						'text' => 'Consejos'
					],
				],
				'date' => '10/10/2010',
				'title' => '¿Por qué es importante proteger mi marca?',
				'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
			],
			[
				'thumbnail' => [
					'url' => themosis_assets() . '/images/thumbnail_article-3.png',
					'alt' => 'Persona de negocios en llamada'
				],
				'tags' => [
					[
						'color' => '#EAEA83',
						'text' => 'Historias'
					],
					[
						'color' => '#98E4E4',
						'text' => 'Consejos'
					],
				],
				'date' => '10/10/2010',
				'title' => 'Errores Comunes al registrar una marca y cómo evitarlos',
				'url' => '/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile',
			]
		],
		'link' => [
			'url' => '/blog-listing-page',
			'title' => 'Ver todas las entradas publicadas',
			'target' => '_self'
		]
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
				'heading' => '¿Por cuánto tiempo me protege el registro de mi marca? ¿Por cuánto tiempo me protege el registro de mi marca? ¿Por cuánto tiempo me protege el registro de mi marca?',
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
