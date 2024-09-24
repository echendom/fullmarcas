<?php

namespace App\Hooks\PostType;

use Themosis\Hook\Hookable;
use PostType;
use Taxonomy;
class Blog extends Hookable
{
    public function register()
    {
        PostType::make('blog', 'Blogs', 'Blog')->setArguments([
            'has_archive' => false,
            'capability_type' => 'page',
            'hierarchical' => false,
            'menu_icon' => 'dashicons-welcome-widgets-menus',
            //'taxonomies' => ['category'],
            'rewrite' => ['slug' => 'blog'],
            'supports' => ['title', 'excerpt', 'revisions', 'template', 'thumbnail', 'editor', 'tags', 'page-attributes', 'author'],
        ])->set();

        Taxonomy::make('tag_blog', ['blog'], 'Etiquetas', 'Etiqueta')->setArguments([
            'public' => true,
            'rewrite' => false,
            'query_var' => false,
            'hierarchical' => true,
            'rewrite' => ['slug' => 'categoria', 'with_front' => false],
        ])->set();
    }
}
