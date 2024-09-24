<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Traits\Formatter;
use Carbon\Carbon;

class BlogController extends Controller
{
  use Formatter;

    public function detail($post)
    {
        $fields = [];
       
        $fields = get_fields($post) ?? [];
        $tags = [];
        $url = (get_permalink($post));
        $url = rtrim($url, '/');

        // Obtener substring hasta el último slash
        $lastSlashPos = strrpos($url, '/');
        $url = substr($url, 0, $lastSlashPos);

        $link_back = [
          'url' => $url,
          'title' => __('Volver','meat'),
          'target' => '_self'
        ];
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date, 'America/Santiago')->locale('es')->isoFormat('DD/MM/YYYY');
        $title = $post->post_title;
        $thumbnail = isset($fields['thumbnail']) && !empty($fields['thumbnail']) ? $fields['thumbnail'] : [];
        $author_info = isset($fields['author_info']) && !empty($fields['author_info']) ? $fields['author_info'] : [];

        $cat = wp_get_post_terms($post->ID, 'tag_' . $post->post_type, ['name']);

        if (is_array($cat) && !empty($cat)) {
            foreach ($cat as $c) {
                $cat_fields = get_field('color_tag', 'tag_' . $post->post_type . '_' . $c->term_id, $post);
                if (!empty($cat_fields)) {
                    $tags[] =  [
                        'text' => $c->name,
                        'color' => $cat_fields,
                    ];
                }
            }
        }

        $share_links = get_field('share_links', 'option');
        $share_links = (new Post())->getShareLink($share_links, get_permalink($post));
        $fields['layout_modules'] = $this->formatModules(isset($fields['layout_modules']) ? $fields['layout_modules'] : [], $post);

        $arrow_back = themosis_assets() . '/images/icons/gray_arrow-left.svg';
        $quote_icon = themosis_assets() . '/images/icons/black_quote_icon.svg';
        $arrow_left = themosis_assets() . '/images/icons/white_arrow-left.svg';
        $arrow_right = themosis_assets() . '/images/icons/white_arrow-right.svg';
        $external_icon = themosis_assets() . '/images/icons/white_external-link.svg';
        $white_lock = themosis_assets() . '/images/white_lock.svg';
      
        $copy_icon = themosis_assets() . '/images/icons/black_icon_copy.svg';

        return view('pages.blog-modules', compact('fields', 'white_lock', 'date', 'title', 'thumbnail', 'author_info', 'tags', 'share_links', 'arrow_back', 'quote_icon', 'arrow_left', 'arrow_right', 'external_icon', 'copy_icon', 'link_back'));
    }

}
