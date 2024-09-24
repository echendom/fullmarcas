@extends('layouts.default')

@section('content')
  @include('components.blog-content', [
    'link_back' => [
      'url' => '/blog',
      'title' => 'Volver',
      'target' => '_self'
    ],
    'thumbnail' => [
      'url' => themosis_assets() . '/images/article_thumbnail.png',
      'alt' => 'Mano sosteniendo vaso de helado'
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
    'author_info' => [
      'image' => [
        'url' => themosis_assets() . '/images/post_author.jpg',
        'alt' => 'Autor del artículo'
      ],
      'name' => 'Nombre Apellido',
      'role' => 'Periodista',
    ],
    'introduction' => '<p>Lorem ipsum dolor sit amet consectetur. Turpis rutrum a erat tempor dictumst arcu sed aliquam facilisi. Placerat bibendum dolor mauris sit nulla vivamus elit malesuada. Turpis amet sed amet.</p>',
    'content' => "
      <p>
        Wider best kpis now we've digital existing hit drawing-board shark. Make please it dear resources. Window door open let's activities goalposts my also. Panel club criticality want we donuts. Scope want circle to both is exploratory down. Savvy room usabiltiy tentative door giant monday. Talk value-added kimono power recap eye comms need close value-added. Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.
      </p>
      <p>
        Technologically bake helicopter feed an downloaded diligence sandwich crystallize. See feed no right alpha for space back. Would contribution dunder agile hard. Cc journey identify want deploy. Win customer beforehand sandwich to hit stakeholder. Tiger fit ask procrastinating ipsum they. Right pivot product take better options while replied uat. No most we've due masking algorithm 30,000ft one whistles. No-brainer as own low closer savvy land staircase. We playing culture it's pole. Pole feelers able make pivot whistles like. Zoom needle helicopter status invite start so issues hands.
      </p>
      <ul>
        <li>
          Adoption waste so policy blue regroup. Recap base ballpark optimal opportunity bandwagon floor.
        </li>
        <li>
          Optimize submit replied sexy loss roll ideal didn't is. Elephant without stop talk diligence welcome lean level.
        </li>
        <li>
          Involved including without client going manager standup individual you. Work strategy zoom contribution join feed previous boardroom language wider. Flesh idea without just dunder run squad view.
        </li>
        <li>
          Proceduralize pin savvy speed loss future-proof these. Hammer be native for including could left.
        </li>
        <li>
          Reach happenings growth driver's tomorrow circle low.
        </li>
        <li>
          Adoption points people baked data practices teams is focus.
        </li>
        <li>
          Get club ipsum were weaponize stakeholder crack base.
        </li>
        <li>
          Roll customer centric dear exploratory well. Assassin talk savvy initiative kimono box don't.
        </li>
      </ul>
      <p>
        4-blocker working floor ping then. Box your seat me issues post closest. Launch fit community when bake customer who's. Go pivot jumping note centric air tomorrow. Nobody illustration pain welcome ditching quick-win half first company territories. Happenings supervisor seat welcome engagement dunder. Needle unit contribution let's baseline club ping customer solutions long. Blue would moments guys sexy first-order third underlying interim baked. Journey client deliverables existing dive lot with create marketing. Gmail down able developing dear meat line. Accountable slipstream ladder running re-inventing sky eco-system land indicators previous. Sorry we hill place ourselves revision socialize knowledge on barn.
      </p>
    ",
    'image_gallery' => [
      [
        'url' => themosis_assets() . '/images/medicines.jpg',
        'alt' => 'Medicinas en una mesa'
      ],
      [
        'url' => themosis_assets() . '/images/medicines.jpg',
        'alt' => 'Medicinas en una mesa'
      ],
      [
        'url' => themosis_assets() . '/images/medicines.jpg',
        'alt' => 'Medicinas en una mesa'
      ],
      [
        'url' => themosis_assets() . '/images/medicines.jpg',
        'alt' => 'Medicinas en una mesa'
      ],
      [
        'url' => themosis_assets() . '/images/medicines.jpg',
        'alt' => 'Medicinas en una mesa'
      ]
    ],
    'inner_content' => [
      'subheading' => 'Subtítulo',
      'subcontent' => "<p>Technologically bake helicopter feed an downloaded diligence sandwich crystallize. See feed no right alpha for space back. Would contribution dunder agile hard. Cc journey identify want deploy. Win customer beforehand sandwich to hit stakeholder. Tiger fit ask procrastinating ipsum they. Right pivot product take better options while replied uat. No most we've due masking algorithm 30,000ft one whistles. No-brainer as own low closer savvy land staircase. We playing culture it's pole. Pole feelers able make pivot whistles like. Zoom needle helicopter status invite start so issues hands.</p>"
    ],
    'blockquote' => [
      'quote' => '<p>Lorem ipsum dolor sit amet consectetur. Vitae feugiat ipsum justo ut nisl vestibulum amet a. Eget varius a nibh tempus. Tellus pharetra sed ac est. Sit venenatis nisl ipsum ac bibendum. Duis risus varius ut metus at.”</p>',
      'author_image' => [
        'url' => themosis_assets() . '/images/testimonial_ana_garcia.png',
        'alt' => 'Ana García'
      ],
      'author_name' => 'Ana García',
      'author_role' => 'Jefa de Recursos Humanos at QualityWorks'
    ],
    'video_id' => 'mdQua3sAlIc', // Youtube video ID,
    'links_of_interest' => [
      [
        'label' => 'Nombre del enlace',
        'title' => 'Visitar sitio web',
        'url' => '/',
        'target' => '_blank'
      ],
      [
        'label' => 'Nombre del enlace',
        'title' => 'Visitar sitio web',
        'url' => '/',
        'target' => '_blank'
      ],
      [
        'label' => 'Nombre del enlace',
        'title' => 'Visitar sitio web',
        'url' => '/',
        'target' => '_blank'
      ]
    ],
    'share_links' => [
      [
        'icon' => [
          'url' => themosis_assets() . '/images/icons/brand_whatsapp.svg',
          'alt' => 'Icono de WhatsApp'
        ],
        'title' => 'WhatsApp',
        'url' => '/',
        'target' => '_blank',
        'background_color' => '#DFFBE9',
        'border_color' => '#25D366',
        'text_color' => '#090909',
        'text_color_hover' => '#090909'
      ],
      [
        'icon' => [
          'url' => themosis_assets() . '/images/icons/brand_facebook.svg',
          'alt' => 'Icono de Facebook'
        ],
        'title' => 'Facebook',
        'url' => '/',
        'target' => '_blank',
        'background_color' => '#DAE4FA',
        'border_color' => '#3B5998',
        'text_color' => '#090909',
        'text_color_hover' => '#FFF'
      ],
      [
        'icon' => [
          'url' => themosis_assets() . '/images/icons/brand_twitter.svg',
          'alt' => 'Icono de Twitter/X'
        ],
        'title' => 'Twitter',
        'url' => '/',
        'target' => '_blank',
        'background_color' => '#E9E9E9',
        'border_color' => '#090909',
        'text_color' => '#090909',
        'text_color_hover' => '#FFF'
      ]
    ]
  ])
  @include('components.blog-listing-inline', [
		'title' => 'Artículos relacionados',
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
			]
		],
		'link' => [
			'url' => '/blog-listing-page',
			'title' => 'Ver todas las entradas publicadas',
			'target' => '_self'
		]
	])
@endsection
