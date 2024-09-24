<?php

namespace App\Hooks\Ajax;

use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Ajax;
use App\Services\PaginateService;
use App\Services\UtilService;
use App\Models\Post;
use PostType;
use Taxonomy;
use Request;

class TrademarkRegistration extends Hookable
{
  public function register()
  {
    Ajax::listen('trademark-logo2', function () {
      $response = [
        'success' => true,
        'stored_image_url' => '/content/themes/meat-theme/dist/images/logo_fullmarcas.svg'
      ];

      return wp_send_json($response);
    });
    Ajax::listen('step-1_bk', function () {
      $response = [
        'success' => true,
        'id' => '11',
        'email' => 'doxas@mailinator.com',
        'categories' => [
          [
            'color' => '#B8E5B8',
            'icon' => [
              'url' => themosis_assets() . '/images/icons/white_mug.svg',
              'alt' => 'Icono de taza'
            ],
            'title' => 'Productos',
            'key' => 'productos',
            'description' => '
              <p>Bienes materiales que se ofrecen al mercado, con el objetivo de satisfacer una necesidad o deseo de los consumidores.</p>
            '
          ],
          [
            'color' => '#98E4E4',
            'icon' => [
              'url' => themosis_assets() . '/images/icons/white_heart_handshake.svg',
              'alt' => 'Icono de corazón'
            ],
            'title' => 'Servicios',
            'key' => 'servicios',
            'description' => '
              <p>Actividad intangible realizada por una persona o entidad para satisfacer las necesidades, deseos o requerimientos de los consumidores.</p>
            '
          ],
          [
            'color' => '#CCCCFF',
            'icon' => [
              'url' => themosis_assets() . '/images/icons/white_building_store.svg',
              'alt' => 'Icono de tienda'
            ],
            'title' => 'Tiendas',
            'key' => 'tiendas',
            'description' => '
              <p>Comercio de bienes en instalaciones físicas o medios digitales (ecommerce y redes sociales).</p>
            '
          ],
          [
            'color' => '#FFCCCC',
            'icon' => [
              'url' => themosis_assets() . '/images/icons/white_chef_hat.svg',
              'alt' => 'Icono de gorro de chef'
            ],
            'title' => 'Todas',
            'key' => 'todas',
            'description' => '
              <p>Establecimiento que ofrece alimentos y/o bebestibles para consumo en el mismo o solo para retirar.</p>
            '
          ],
          [
            'color' => '#EAEA83',
            'icon' => [
              'url' => themosis_assets() . '/images/icons/white_user_star.svg',
              'alt' => 'Icono de usuario'
            ],
            'title' => 'Artista',
            'key' => 'artista',
            'description' => '
              <p>Personas dedicadas a la creación, interpretación o expresión de formas artísticas (grupo musical/cantante o influencer).</p>
            '
          ]
        ]
      ];

      return wp_send_json($response);
    });
    Ajax::listen('step-2_bk', function () {
      $response = [
        'success' => true
      ];

      return wp_send_json($response);
    });
    Ajax::listen('step-3_bk', function () {
      $response =  [
        "available_domain" => true,
        "disclaimer" => '
          <p>
            Los resultados de la presente búsqueda pueden tener un breve desfase de tiempo con la base de datos de NIC Chile. Para más información lee nuestros <a href="https://full-marcas-website.dmeat.cl/terminos-y-condiciones/">términos y condiciones.</a>
          </p>
        ',
        "risk" => [
          "description" => "¡Excelente! no hay marcas parecidas a la tuya",
          "level" => "low",
          "title" => "Disponible"
        ],
        "selected_classes" => [
          [
            "description" => "",
            "key" => "20",
            "title" => "abanicos de mano;abanicos para uso personal (no el\u00e9ctricos)"
          ],
          [
            "description" => "",
            "key" => "9",
            "title" => "abalorios para tel\u00e9fonos m\u00f3viles"
          ],
          [
            "description" => "",
            "key" => "18",
            "title" => "abrigos para perros"
          ]
        ],
        "services_response" => [
          [
            "key" => "Honorarios por presentación y tramitación de la solicitud marca denominativa “Voluptate sunt fugia” en las clases “29” en Chile",
            "title" => "Honorarios por solicitud de registro x 1 Clase(s)",
            "id" => 1,
            "optional" => false,
            "group" => "Marca",
            "price" => "$107.250",
            "price_iva" => "$0",
            "net_price" => "$165.000",
            "discount_perc" => "35",
            "discount_value" => "$57.750"
          ],
          [
            "key" => "Tasa inicial para tramitación de la solicitud marca denominativa “Voluptate sunt fugia” en las clases “29” en Chile.", 
            "title" => "Tasa inicial para 1 Clase(s)",
            "id" => 2,
            "optional" => false,
            "group" => "Marca",
            "price" => "$64.343",
            "price_iva" => "$0",
            "net_price" => "$64.343",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ],
          [
            "key" => "Honorarios por presentación de solicitud de nombre de dominio voluptate-sunt-fugia.cl.",
            "title" => "Honorarios por solicitud de nombre de dominio",
            "id" => 3,
            "optional" => false,
            "group" => "Dominio",
            "price" => "$0",
            "price_iva" => "$0",
            "net_price" => "$0",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ],
          [
            "key" => "Tarifa inscripción 1 año de solicitud de nombre de dominio voluptate-sunt-fugia.cl.",
            "title" => "Tarifa inscripción 1 año voluptate-sunt-fugia.cl",
            "id" => 4,
            "optional" => false,
            "group" => "Dominio",
            "price" => "$9.900",
            "price_iva" => "$0",
            "net_price" => "$9.900",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ]
        ],
        "selected_services" => [
          [
            "key" => "Honorarios por presentación y tramitación de la solicitud marca denominativa “Voluptate sunt fugia” en las clases “29” en Chile",
            "title" => "Honorarios por solicitud de registro x 1 Clase(s)",
            "id" => 1,
            "optional" => false,
            "group" => "Marca",
            "price" => "$107.250",
            "price_iva" => "$0",
            "net_price" => "$165.000",
            "discount_perc" => "35",
            "discount_value" => "$57.750"
          ],
          [
            "key" => "Tasa inicial para tramitación de la solicitud marca denominativa “Voluptate sunt fugia” en las clases “29” en Chile.", 
            "title" => "Tasa inicial para 1 Clase(s)",
            "id" => 2,
            "optional" => false,
            "group" => "Marca",
            "price" => "$64.343",
            "price_iva" => "$0",
            "net_price" => "$64.343",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ],
          [
            "key" => "Honorarios por presentación de solicitud de nombre de dominio voluptate-sunt-fugia.cl.",
            "title" => "Honorarios por solicitud de nombre de dominio",
            "id" => 3,
            "optional" => false,
            "group" => "Dominio",
            "price" => "$0",
            "price_iva" => "$0",
            "net_price" => "$0",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ],
          [
            "key" => "Tarifa inscripción 1 año de solicitud de nombre de dominio voluptate-sunt-fugia.cl.",
            "title" => "Tarifa inscripción 1 año voluptate-sunt-fugia.cl",
            "id" => 4,
            "optional" => false,
            "group" => "Dominio",
            "price" => "$9.900",
            "price_iva" => "$0",
            "net_price" => "$9.900",
            "discount_perc" => "0",
            "discount_value" => "$0"
          ]
        ],
        "suggested_domain" => "voluptate-sunt-fugia.cl",
        "summary" => [
          "details_modal" => [
            "title" => "Título",
            "content" => '
              <p>
                Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.
              </p>
            '
          ],
          "total" => "$181.493"
        ],
        "similarity" => [
          [
            "id" => 1,
            "denomination" => "Marca Parecida 1",
            "request" => "659955",
            "classes" => "01, 02"
          ],
          [
            "id" => 2,
            "denomination" => "Marca Parecida 2",
            "request" => "632544",
            "classes" => "03, 05"
          ],
          [
            "id" => 3,
            "denomination" => "Marca Parecida 3",
            "request" => "63243444",
            "classes" => "03, 05"
          ],
          [
            "id" => 4,
            "denomination" => "Marca Parecida 2",
            "request" => "6324544",
            "classes" => "08, 10"
          ]
        ],
        "status" => 200,
        "success" => true
      ];

      return wp_send_json($response);
    });
    Ajax::listen('step-4_bk', function () {
      $response = [
        'success' => true,
        'risk' => [
          'level' => 'high', // Allowed values are: 'high', 'moderate', 'medium', 'low'.
          'title' => 'Alto riesgo',
          'description' => 'Existen marcas casi idénticas.'
        ],
        'available_domain' => true,
        'suggested_domain' => 'www.tumarca.cl',
        'disclaimer' => '
          <p>
            Disclaimer sobre el tiempo de desfase entre el resultado de la búsqueda y las marcas que se presentan ese mismo día en INAPI y los dominios en NIC Chile, para más información, lee nuestros <a href="/terminos-y-condiciones">términos y condiciones</a>
          </p>
        ',
        'summary' => [
          'services' => [
            [
              'title' => 'Honorarios por solicitud de registro x 3 Clase(s)',
              'key' => 'service-1',
              'details' => [
                [
                  "title" => "",
                  "key" => 'Honorarios por presentación y tramitación de la solicitud marca denominativa "asdasdas" en las clases "42" en Chile.',
                  "price" => "$177.300",
                  "price_iva" => "$0",
                  "net_price" => "$197.000",
                  "discount_perc" => "10",
                  "discount_value" => "$19.700"
                ]
              ]
            ],
            [
              'title' => 'Nombre del servicio',
              'key' => 'service-2',
              'details' => [
                [
                  'title' => 'Detalle del servicio',
                  'key' => 'service-2-detail-1',
                  'price' => '$197.000',
                  "price_iva" => "$0",
                  "net_price" => "$197.000",
                  "discount_perc" => "0",
                  "discount_value" => "0"
                ]
              ]
            ],
            [
              'title' => 'Tarifa inscripción 1 año www.tumarca.cl',
              'key' => 'service-3',
              'details' => [
                [
                  'title' => 'Detalle del servicio',
                  'key' => 'service-3-detail-2',
                  'price' => '$9.900',
                  "price_iva" => "$0",
                  "net_price" => "$9.900",
                  "discount_perc" => "0",
                  "discount_value" => "0"
                ]
              ]
            ]
          ],
          'total' => '$384.200',
          'details_modal' => [
            'title' => 'Título',
            'content' => '
              <p>Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.</p>
            '
          ]
        ],
        'selected_classes' => [
          [
            'title' => 'Clase 1',
            'key' => 'clase-1',
            'description' => '<p>Agencias inmobiliarias</p>'
          ]
        ],
        'selected_services' => [
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1'
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1'
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1'
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1'
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1'
          ],
          [
            'title' => 'Tarifa inscripción 1 año www.tumarca.cl',
            'key' => 'service-1'
          ]
        ],
        'total' => '$181.493'
      ];

      return wp_send_json($response);
    });
    Ajax::listen('step-5_bk', function () {
      $response = [
        'success' => true,
        'redirect' => '/registro-gracias'
      ];

      return wp_send_json($response);
    });
    Ajax::listen('categories_bk', function () {
      $response = [
        [
          'title' => 'Productos',
          'key' => 'productos'
        ],
        [
          'title' => 'Servicios',
          'key' => 'servicios'
        ],
        [
          'title' => 'Tiendas',
          'key' => 'tiendas'
        ],
        [
          'title' => 'Todas',
          'key' => 'todas'
        ],
        [
          'title' => 'Artista',
          'key' => 'artista'
        ]
      ];

      return wp_send_json($response);
    });
    Ajax::listen('subcategories_bk', function () {
      $response = [
        'success' => true,
        'id' => '11',
        'email' => 'doxas@mailinator.com',
        'subcategories' =>  [
          [
            'category_label' => 'Productos',
            'category_key' => 'productos',
            'subcategories' => [
              [
                'class' => 20,
                'title' => 'Productos',
                'description' => 'abanicos de mano',
                'key' => 'product-subcategory-1'
              ],
              [
                'class' => 20,
                'title' => 'Productos',
                'description' => 'abanicos para uso personal (no el\u00e9ctricos)',
                'key' => 'product-subcategory-12'
              ],
              [
                'class' => 9,
                'title' => 'Productos',
                'description' => 'abalorios para tel\u00e9fonos m\u00f3viles',
                'key' => 'product-subcategory-2'
              ],
              [
                'class' => 18,
                'title' => 'Productos',
                'description' => 'abrigos para perros',
                'key' => 'product-subcategory-3'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Producto 4',
                'description' => '<p>Local de preparación de café, té, pasteles y sandwiches.</p>',
                'key' => 'product-subcategory-4'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Producto 5',
                'description' => '<p>Local de preparación de helados.</p>',
                'key' => 'product-subcategory-5'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Producto 6',
                'description' => '<p>Pedidos en linea para la venta y reparto de comidas y bebidas.</p>',
                'key' => 'product-subcategory-6'
              ]
            ],
            'enable_word_search' => false,
            'pagination' => [
              'page' => 1,
              'next_page' => 0,
              'prev_page' => 0,
              'max_page' => 1,
              'per_page' => 12,
              'total_items' => 6,
            ]
          ],
          [
            'category_label' => 'Todas',
            'category_key' => 'todas',
            'subcategories' => [
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Academias de canto; Enseñanza de canto; Organización de eventos de canto</p>',
                'key' => 'service-subcategory-1'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Acompañamiento en sociedad (personas de compañía); Servicios personales y sociales prestados por terceros para satisfacer necesidades individuales</p>',
                'key' => 'service-subcategory-2'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Acupuntura</p>',
                'key' => 'service-subcategory-3'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Administración, planificación, análisis, estrategias, desarrollo, supervisión, organización, dirección, operación, eficiencia empresarial, implementación e integración de sistemas, gestión de negocios para terceros</p>',
                'key' => 'service-subcategory-4'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias de noticias</p>',
                'key' => 'service-subcategory-5'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias de seguros</p>',
                'key' => 'service-subcategory-6'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias de talento</p>',
                'key' => 'service-subcategory-7'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias de ivajes</p>',
                'key' => 'service-subcategory-8'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias inmobiliarias</p>',
                'key' => 'service-subcategory-9'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Agencias matrimoniales</p>',
                'key' => 'service-subcategory-10'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Almacenamiento de productos; Arriendo de contenedores de almacenamiento</p>',
                'key' => 'service-subcategory-11'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Análisis del agua; Control de la calidad del agua</p>',
                'key' => 'service-subcategory-12'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Apicultura; Arriendo de colmenas</p>',
                'key' => 'service-subcategory-13'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Arquitectura; Diseño arquitectónico; Planificación urbana</p>',
                'key' => 'service-subcategory-14'
              ],
              [
                'class' => 29,
                'title' => '',
                'description' => '<p>Arrendamiento de máquinas y aparatos para la industria madera</p>',
                'key' => 'service-subcategory-15'
              ]
            ],
            'enable_word_search' => false,
            'pagination' => [
              'page' => 1,
              'next_page' => 2,
              'prev_page' => 0,
              'max_page' => 5,
              'per_page' => 12,
              'total_items' => 300,
            ]
          ],
          [
            'category_label' => 'Tiendas',
            'category_key' => 'tiendas',
            'subcategories' => [
              [
                'class' => 29,
                'title' => 'Ropa y accesorios',
                'description' => '<p>Venta de ropa y accesorios de hombre, mujer y niños. (Ropa, calzado, sombreros, cinturones, carteras, mochilas, billeteras y accesorios para el cabello).</p>',
                'key' => 'store-subcategory-1'
              ],
              [
                'class' => 29,
                'title' => 'Belleza',
                'description' => '<p>Venta de productos cosméticos, maquillaje, perfumes, cuidado, tratamiento y productos electrónicos relacionados para hombre y mujer.</p>',
                'key' => 'store-subcategory-2'
              ],
              [
                'class' => 29,
                'title' => 'Joyerías',
                'description' => '<p>Venta de productos de joyería y bisutería.</p>',
                'key' => 'store-subcategory-3'
              ],
              [
                'class' => 29,
                'title' => 'Pastelería',
                'description' => '<p>Venta de productos de pastelería y repostería.</p>',
                'key' => 'store-subcategory-4'
              ],
              [
                'class' => 29,
                'title' => 'Chocolatería y confitería',
                'description' => '<p>Venta de chocolates y dulces.</p>',
                'key' => 'store-subcategory-5'
              ],
              [
                'class' => 29,
                'title' => 'Muebles y decoración',
                'description' => '<p>Venta de productos para muebles y decoración (adornos, figuras, alfombras, velas, candelabros, cuadros, decoración de papel, móviles, floreros)</p>',
                'key' => 'store-subcategory-6'
              ],
              [
                'class' => 29,
                'title' => 'Iluminación',
                'description' => '<p>Venta de productos para iluminación.</p>',
                'key' => 'store-subcategory-7'
              ]
            ],
            'enable_word_search' => true,
            'word_search_title' => 'No encontré mi tienda',
            'word_search_description' => 'Seleccionar manualmente los productos que vendo.',
            'search_title' => 'No encontré mi tienda',
            'search_description' => '<p>Seleccionar manualmente los productos que vendo.</p>',
            'pagination' => [
              'page' => 1,
              'next_page' => 0,
              'prev_page' => 0,
              'max_page' => 1,
              'per_page' => 12,
              'total_items' => 7,
            ]
          ],
          [
            'category_label' => 'Servicios',
            'category_key' => 'servicios',
            'subcategories' => [
              [
                'class' => 29,
                'title' => 'Restaurant / Comida al paso y para llevar',
                'description' => '<p>Local de preparación de alimentos y bebidas para servir, al paso o para llevar.</p>',
                'key' => 'restaurant-subcategory-1'
              ],
              [
                'class' => 29,
                'title' => 'Foodtruck / Carrito de comida',
                'description' => '<p>Preparación de alimentos y bebidas en la calle o al aire libre.</p>',
                'key' => 'restaurant-subcategory-2'
              ],
              [
                'class' => 29,
                'title' => 'Bar / Pub',
                'description' => '<p>Local de preparación de alimentos y bebidas.</p>',
                'key' => 'restaurant-subcategory-3'
              ],
              [
                'class' => 29,
                'title' => 'Cafetería / Salón de té',
                'description' => '<p>Local de preparación de café, té, pasteles y sandwiches.</p>',
                'key' => 'restaurant-subcategory-4'
              ],
              [
                'class' => 29,
                'title' => 'Heladería',
                'description' => '<p>Local de preparación de helados.</p>',
                'key' => 'restaurant-subcategory-5'
              ],
              [
                'class' => 29,
                'title' => 'Pedidos online y reparto',
                'description' => '<p>Pedidos en linea para la venta y reparto de comidas y bebidas.</p>',
                'key' => 'restaurant-subcategory-6'
              ]
            ],
            'enable_word_search' => false,
            'pagination' => [
              'page' => 1,
              'next_page' => 0,
              'prev_page' => 0,
              'max_page' => 1,
              'per_page' => 12,
              'total_items' => 6,
            ]
          ],
          [
            'category_label' => 'Artista',
            'category_key' => 'artista',
            'subcategories' => [
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 1',
                'description' => '<p>Local de preparación de alimentos y bebidas para servir, al paso o para llevar.</p>',
                'key' => 'artist-subcategory-1'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 2',
                'description' => '<p>Preparación de alimentos y bebidas en la calle o al aire libre.</p>',
                'key' => 'artist-subcategory-2'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 3',
                'description' => '<p>Local de preparación de alimentos y bebidas.</p>',
                'key' => 'artist-subcategory-3'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 4',
                'description' => '<p>Local de preparación de café, té, pasteles y sandwiches.</p>',
                'key' => 'artist-subcategory-4'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 5',
                'description' => '<p>Local de preparación de helados.</p>',
                'key' => 'artist-subcategory-5'
              ],
              [
                'class' => 29,
                'title' => 'Subcategoria Artista 6',
                'description' => '<p>Pedidos en linea para la venta y reparto de comidas y bebidas.</p>',
                'key' => 'artist-subcategory-6'
              ]
            ],
            'enable_word_search' => false,
            'pagination' => [
              'page' => 1,
              'next_page' => 0,
              'prev_page' => 0,
              'max_page' => 1,
              'per_page' => 12,
              'total_items' => 6,
            ]
          ],
        ]
      ];

      return wp_send_json($response);
    });
    Ajax::listen('subcategories-from_bk', function () {
      // This endpoint returns a page of a subcategories list from a subcategory.
      $response = [
        "status" => 200,
        "id" => "1371AD8D-9419-49A7-BEF4-999145D2D010",
        "email" => "zomeb@mailinator.com",
        "category_label" => "Todas",
        "category_key" => "Todas",
        "subcategories" => [
          [
            "title" => "",
            "key" => "42-0",
            "description" => "instalación, mantenimiento, reparación y servicio técnico de programas informáticos"
          ],
          [
            "title" => "",
            "key" => "42-1",
            "description" => "instalación, mantenimiento, reparación y servicio técnico de software"
          ],
          [
            "title" => "",
            "key" => "42-2",
            "description" => "instalación, mantenimiento, reparación y servicio técnico de software informático"
          ]
        ]
     ];

      return wp_send_json($response);
    });
    Ajax::listen('get-steps', function () {
      $response =  [
        'steps' => [
          "step1" => [
            "trademarkName" => "Adipisci consequatur",
            "email" => "fekuzapu@mailinator.com",
            "type" => "Denominativa",
            "trademarkFile" => "",
            "trademarkFilename" => "",
            "trademarkFilesize" => "",
            "filenameInput" => "",
            "storedFilename" => "",
            "fileValidated" => false,
            "uploadPercentage" => 0,
            "imageExtraInfo" => ""
          ],
          "step2" => [
            "checkedCategories" => [
              [
                "color" => "#98E4E4",
                "icon" => [
                  "url" => "http://localhost:8080/content/themes/meat-theme/dist/images/icons/white_heart_handshake.svg",
                  "alt" => "Icono de corazón"
                ],
                "title" => "Servicios",
                "key" => "servicios",
                "description" => "<p>Actividad intangible realizada por una persona o entidad para satisfacer las necesidades, deseos o requerimientos de los consumidores.</p>"
              ],
              [
                "color" => "#CCCCFF",
                "icon" => [
                  "url" => "http://localhost:8080/content/themes/meat-theme/dist/images/icons/white_building_store.svg",
                  "alt" => "Icono de tienda"
                ],
                "title" => "Tiendas",
                "key" => "tiendas",
                "description" => "<p>Comercio de bienes en instalaciones físicas o medios digitales (ecommerce y redes sociales).</p>"
              ]
            ]
          ],
          "step3" => null,
          "step4" => null,
          "step5" => null
        ],
        'order_data' => null
      ];

      return wp_send_json($response);
    });
  }
}
