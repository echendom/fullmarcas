<?php

namespace App\Hooks\Ajax;

use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Ajax;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
// use ReCaptcha\ReCaptcha;
use App\Models\Post;
use stdClass;
use App\Services\PaginateService;
use Carbon\Carbon;

class Blog extends Hookable
{
  public function register()
  {

    Ajax::listen('blog', function () {
      global $wpdb;
      global $paged;
      global $currentpage;
      extract($_GET);
      extract($_POST);

      $cards = array();

      $page = 1;
      if(!empty(Request::get('page'))){
          $page = Request::get('page');
      }
      $per_page = 9;
      if(!empty(Request::get('per_page'))){
          $per_page = Request::get('per_page');
      }
      $tax = [];
      $data = (new PaginateService('blog'))->setPpp($per_page)->setPage($page);
    
      $search = Request::get('search');
      if (isset($search) && strlen($search) >= 3) {
          $data = $data->setSearch($search);
      }

      $categories = Request::get('categories');
      if (isset($categories) && !empty($categories) && $categories != 'all') {
                  $tax[] = [
                      'tax' => 'tag_blog',
                      'field' => 'slug',
                      'term' => $categories,
                  ];
      }

    
      if (!empty($tax)) {
          $data = $data->setFilterByTaxonomyId($tax);
      }

      $data = $data->get();
      $response['data'] = [];
      if (isset($data['data']['posts']) && !empty($data['data']['posts'])) {
          $response['data'] = (new Post())->getBlogItems($data['data']['posts']);
      }

      $response['pagination'] =  $data['pagination'];

      wp_send_json($response);
  });

    Ajax::listen('blog2', function () {
      $articles = [
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
        ],
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
          'thumbnail' => [],
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
        ],
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
        ],
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
        ],
      ];
      $response = [
        'data' => $articles,
        'pagination' => [
          'page' => 1,
          'next_page' => 2,
          'prev_page' => 0,
          'max_pages' => 5,
          'per_page' => 12,
          'total_items' => 58,
        ]
      ];

      return wp_send_json($response);
    });
    Ajax::listen('blog-empty-state', function () {
      $response = [
        'data' => [],
        'pagination' => [
          'page' => 1,
          'next_page' => 1,
          'prev_page' => 0,
          'max_pages' => 0,
          'per_page' => 12,
          'total_items' => 0
        ]
      ];

      return wp_send_json($response);
    });
  }
}
