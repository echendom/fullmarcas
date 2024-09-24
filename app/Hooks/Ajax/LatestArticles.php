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

class LatestArticles extends Hookable
{
  public function register()
  {
    Ajax::listen('latest-articles', function () {
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
      ];
      $response = $articles;

      return wp_send_json($response);
    });
  }
}
