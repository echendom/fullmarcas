<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Services\UsefulService;
use App\Traits\Wordpress;
use Ramsey\Collection\Map\AssociativeArrayMap;

class Post extends Model
{
    use Wordpress;
    private $useful = '';

    public function __construct($postType = '')
    {
        $this->postType = $postType;
        // $this->useful = (new UsefulService());
    }


    public function getButton($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = [
            'label' => $fields['title'],
            'url' => $fields['url'],
        ];

        return $section;
    }

    public function getButtonsPrimary($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            return [
                'label' => $item['button']['text'],
                'href' => $item['button']['url'],
                'primary' => isset($fields['primary']) && !empty($fields['primary']) ? $fields['primary'] : false,
            ];
        }, $fields);

        return $section;
    }

    public function getSpaces($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            return [
                "title" => isset($item['title']) && !empty($item['title']) ? $item['title'] : '',
                "address" => isset($item['address']) && !empty($item['address']) ? $item['address'] : [],
                "schedules" => isset($item['schedules']) && !empty($item['schedules']) ? $item['schedules'] : [],
                "email" => isset($item['email']) && !empty($item['email']) ? $item['email'] : '',
                "phone" => isset($item['phone']) && !empty($item['phone']) ? $item['phone'] : '',
                "button" => isset($item['button']) && !empty($item['button']) ? $this->getButtonExt($item['button']) : [],
                "map" =>  isset($item['map']) && !empty($item['map']) ? '<iframe src="' . $item['map'] . '" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' : ''
            ];
        }, $fields);

        return $section;
    }

    public function get_breadcrumb($url)
    {
        // Eliminamos los parámetros de la URL
        $url = parse_url($url, PHP_URL_PATH);
        $url = substr($url, 0, -1);
        // Dividimos la URL en partes
        $parts = explode('/', $url);
        $parts = array_reverse($parts);
        // Inicializamos el array de breadcrumb
        $breadcrumb = [
            'parents' => [],
        ];
        // Recorremos las partes de la URL
        foreach ($parts as $key => $part) {
            // Si la parte es vacía, terminamos el breadcrumb
            $post = get_page_by_path($part);
            if ($key == 1) {
            }
            if ($key == 0) {
                $post = get_page_by_path($url);
                $breadcrumb['section_name'] = !empty($post) ? $post->post_title : ucfirst(str_replace('-', ' ', $part));
                continue;
            }
            if ($part == '') {
                $post = get_page_by_path('Inicio');
            }
            // Obtenemos el nombre de la página
            // Si la página existe, la agregamos al breadcrumb
            if ($post) {
                array_unshift($breadcrumb['parents'], [
                    'name' => $post->post_title,
                    'url' => get_permalink($post->ID),
                ]);
            } else {
                $posicion = strpos($url, $part);
                $substring = substr($url, 0, $posicion + strlen($part) + 1);
                array_unshift($breadcrumb['parents'], [
                    'name' => ucfirst(str_replace('-',' ', $part)),
                    'url' => $substring,
                ]);
            }
        }


        // Devolvemos el array de breadcrumb
        return $breadcrumb;
    }

    public function getSpacesFormat($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            return [
                "title" => $item->post_title,
                "address" => isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : [],
                "schedules" => isset($item_fields['schedules']) && !empty($item_fields['schedules']) ? $item_fields['schedules'] : [],
                "email" => isset($item_fields['email']) && !empty($item_fields['email']) ? $item_fields['email'] : '',
                "phone" => isset($item_fields['phone']) && !empty($item_fields['phone']) ? $item_fields['phone'] : '',
                "button" => isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ],
                "buttons" => isset($item_fields['buttons']) && !empty($item_fields['buttons']) ? $item_fields['buttons'] : [],
                "map" =>  isset($item_fields['iframe']) && !empty($item_fields['iframe']) ? '<iframe src="' . $item_fields['iframe'] . '" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' : ''
            ];
        }, $fields);

        return $section;
    }

    public function getSpace($item)
    {
        $section = [];

        if (empty($item) || !is_object($item)) {
            return $section;
        }
        $item_fields = get_fields($item->ID);
            return [
                "title" => $item->post_title,
                "address" => isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : [],
                "schedules" => isset($item_fields['schedules']) && !empty($item_fields['schedules']) ? $item_fields['schedules'] : [],
                "email" => isset($item_fields['email']) && !empty($item_fields['email']) ? $item_fields['email'] : '',
                "phone" => isset($item_fields['phone']) && !empty($item_fields['phone']) ? $item_fields['phone'] : '',
                "button" => isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ],
                "buttons" => isset($item_fields['buttons']) && !empty($item_fields['buttons']) ? $item_fields['buttons'] : [],
                "map" =>  isset($item_fields['iframe']) && !empty($item_fields['iframe']) ? '<iframe src="' . $item_fields['iframe'] . '" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' : ''
            ];
    }

    public function getSpaceCultureCenter($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);

            return [
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $item_fields['image']['url'] : '',
                'title' => $item->post_title,
                'button' => isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : ['text' => isset($item_fields['route']) && $item_fields['route'] == true ? __('Ver ruta', 'cclb') : __('Ver más', 'cclb'), 'url' => get_permalink($item->ID), 'external' => false],
            ];
        }, $fields);

        return $section;
    }


    public function getCardsHelpCenter($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);

            return [
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'title' => $item->post_title,
                'phone' =>  isset($item_fields['phone']) && !empty($item_fields['phone']) ? $item_fields['phone'] : '',
                'email' =>  isset($item_fields['email']) && !empty($item_fields['email']) ? $item_fields['email'] : '',
                'address' =>  isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : [],
            ];
        }, $fields);

        return $section;
    }

    public function getCardsTestimonies($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {

            return [
                'image' => isset($item['image']) && !empty($item['image']) ? $this->getImgArray($item['image']) : [],
                'description' => isset($item['description']) && !empty($item['description']) ? $item['description'] : '',
                'author' => isset($item['author']) && !empty($item['author']) ? $item['author'] : '',
                'occupation' => isset($item['occupation']) && !empty($item['occupation']) ? $item['occupation'] : '',
                'video' => isset($item['video']) && !empty($item['video']) ? $item['video'] : '',
            ];
        }, $fields);

        return $section;
    }

    public function getButtonsLR($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section['left'] = $this->getButtonExt($fields['left']);
        $section['right'] = $this->getButtonExt($fields['right']);

        return $section;
    }

    public function getSlidesHomeHero($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item['post'][0]->ID);
            $categories = [];
            $cat = wp_get_post_terms($item['post'][0]->ID, 'category_' . $item['post'][0]->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item['post'][0]->post_type . '_' . $cat[0]->term_id, $item['post'][0]);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }

            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item['post'][0]->ID),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item['post'][0]->ID),
                    'external' => false,
                ];
            }

            return [
                'image' => $item['image'],
                'video' => $item['video'],
                'show_video' => $item['show_video'],
                'tags' => $categories,
                'title' => $item['post'][0]->post_title,
                'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                'button' => $button
            ];
        }, $fields);
        return $section;
    }

    public function getEventsFeat($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item['post'][0]->ID);
            $categories = [];
            $cat = wp_get_post_terms($item['post'][0]->ID, 'category_' . $item['post'][0]->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item['post'][0]->post_type . '_' . $cat[0]->term_id, $item['post'][0]);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }
            $free = false;
            $cat = wp_get_post_terms($item['post'][0]->ID, 'cost_' . $item['post'][0]->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $free = $cat[0]->slug == 'gratuito' || $cat[0]->slug == 'gratis';
            }

            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            }
            $address = [];
            if (isset($item['address']) && !empty($item['address'])) {
                $address = ['text' => $item['address']->post_title, 'url' => get_permalink($item['address']->ID)];
            }

            return [
                'image_desktop' => $item['image_desktop'],
                'image_mobile' => $item['image_mobile'],
                'free' => $free, //isset($item_fields['free']) ? $item_fields['free'] : false,
                'tags' => $categories,
                'title' => $item['post'][0]->post_title,
                'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? $item_fields['date'] : '',
                'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                'address' => $address,
                'button' => $button,
            ];
        }, $fields);

        return $section;
    }

    public function getNewsHome($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $categories = [];
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }

            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            }
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->post_date, 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM YYYY');
            return [
                'image' => [
                    'src' => themosis_assets() . '/images/c741.png',
                    'alt' => '',
                ],
                'tags' => $categories,
                'date' => $date,
                'title' => $item->post_title,
                'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                'button' => $button,
            ];
        }, $fields);

        return $section;
    }

    public function getNewsFormat($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $categories = [];
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }

            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            }
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->post_date, 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM YYYY');
            return [
                'image' => [
                    'src' => themosis_assets() . '/images/c741.png',
                    'alt' => '',
                ],
                'categories' => $categories,
                'date' => $date,
                'title' => $item->post_title,
                'button' => $button,
            ];
        }, $fields);

        return $section;
    }

    public function getGalleryHover($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            return [
                'title' => $item['title'],
                'image_mobile' => $item['image_mobile'],
                'image_desktop' => $item['image_desktop'],
                'image_desktop' => $item['image_desktop'],
                'button' => isset($item['button']) && !empty($item['button']) ? $this->getButtonExt($item['button']) : [],

            ];
        }, $fields);

        return $section;
    }


    public function getFooter($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section['description'] = $fields['description'];
        $section['contact_info'] = $fields['contact_info'];
        $section['copyright_text'] = $fields['copyright_text'];
        $section['logo'] = $fields['logo'];
        $section['links'] = $this->getTextArray($fields['links'], 'link');
        $section['policies_pages'] = $this->getTextArray($fields['policies_pages'], 'link');
        $section['socials'] = array_map(function ($item) {
            $array = $item['link'];
            $array['icon'] = $item['icon'];
            $array['icon_mobile'] = isset($item['icon_mobile']) && !empty($item['icon_mobile']) ? $item['icon_mobile'] : [];
            return 
                $array
            ;
        }, $fields['socials']);
        return $section;
    }

    public function getFooterSec($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section['contact_info'] = $fields['contact_info'];
        $section['copyright_text'] = $fields['copyright_text'];
        $section['policies_pages'] = $this->getTextArray($fields['policies_pages'], 'link');

        return $section;
    }
    public function getHeader($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }


        $section['logo'] = $fields['logo'];
        $section['logo_white'] = $fields['logo_white'];
        $section['cta_button'] = $fields['cta_button'];
        $section['links'] = $this->getTextArray($fields['links'], 'link');
        $section['links'] = array_map(function($item){
            $actual_url = env('APP_URL') . $_SERVER['REQUEST_URI'];
            $array = $item;
            $array['active'] = false;
            if($item['url'] == $actual_url){
                $array['active'] = true;
            } else if(str_contains($actual_url,$item['url']) && (env('APP_URL') . '/') != $item['url']){
                $array['active'] = true;
            }
            return $array;
        }, $section['links']);
        $section['socials'] = $fields['socials'];
        return $section;
    }

    public function getSearchFormatData($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $categories = [];
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }
            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            }

            $button['external'] = false;
            return [
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                'title' => $item->post_title,
                'categories' => $categories,
                'button' => $button,
            ];
        }, $fields);
        return $section;
    }

    public function getSlideCards($fields, $cards_to_show = 3, $link_open = 'inner_single')
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) use ($cards_to_show, $link_open) {
            $button = [];
            $item_fields = get_fields($item->ID);
            if($link_open == 'inner_single'){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else if($link_open == 'ext_single'){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => true,
                ];
            }
            else if($link_open == 'inner_button'){
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : 
                ['text' => __('ver más', 'cclb'), 'url' => get_permalink($item), 'external' => false];
                $button['external'] = false;
            } else {
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : 
                ['text' => __('ver más', 'cclb'), 'url' => get_permalink($item), 'external' => false];
                $button['external'] = true;
            }

            $categories = [];
            if ($cards_to_show == 4) {
                $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
                if (is_array($cat) && !empty($cat)) {
                    $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                    if (!empty($cat_fields)) {
                        $categories[] =  [
                            'text' => $cat[0]->name,
                            'text_color' => $cat_fields['text_color'],
                            'bg_color' => $cat_fields['bg_color'],
                        ];
                    }
                }
            }
            $free = false;
            $cat = wp_get_post_terms($item->ID, 'cost_' . $item->post_type, ['name']);
            if (is_array($cat) && !empty($cat)) {
                $free = $cat[0]->slug == 'gratuito' || $cat[0]->slug == 'gratis';
            }

            if ($item->post_type == 'service') {
                return [
                    'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                    'title' => $item->post_title,
                    'title_variant' => true,
                    'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                    'button' => $button,
                ];
            } else if ($item->post_type == 'participate') {
                $cat = wp_get_post_terms($item->ID, 'type_' . $item->post_type, ['name']);
                $categories = [];
                if (is_array($cat) && !empty($cat)) {
                    if ($cat[0]->slug == 'concursos') {
                        return [
                            'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                            'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                            'title' => $item->post_title,
                            'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                            'title_variant' => true,
                            'button' => $button,
                        ];
                    }
                }
            } else if ($item->post_type == 'news') {
                return [
                    'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                    'title' => $item->post_title,
                    'title_variant' => true,
                    'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                    'button' => $button,
                ];
            } else if ($item->post_type == 'workshop') {
                $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
                if (is_array($cat) && !empty($cat)) {
                    $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                    if (!empty($cat_fields)) {
                        $categories[] =  [
                            'text' => $cat[0]->name,
                            'text_color' => $cat_fields['text_color'],
                            'bg_color' => $cat_fields['bg_color'],
                        ];
                    }
                }
                $free = false;
                $cat = wp_get_post_terms($item->ID, 'cost_' . $item->post_type, ['name']);
                if (is_array($cat) && !empty($cat)) {
                    $free = $cat[0]->slug == 'gratuito' || $cat[0]->slug == 'gratis';
                }
                return [
                    'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                    'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                    'free' => $free, //isset($item_fields['free']) && !empty($item_fields['free']) ? $item_fields['free'] : false    ,
                    'title' => $item->post_title,
                    'type' => 'default', // variant or default
                    'categories' => $categories,
                    'button' => $button,
                ];
            }

            return [
                'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                'free' => $free, //isset($item_fields['free']) && !empty($item_fields['free']) ? $item_fields['free'] : false,
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'title' => $item->post_title,
                'type' => 'default',
                'categories' => $categories,
                'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                'address' => isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : '',
                'button' => $button,
            ];
        }, $fields);

        return $section;
    }

    public function getExhibitionCards($fields, $cards_to_show = 3)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) use ($cards_to_show) {
            $item_fields = get_fields($item->ID);
            return [
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'title' => $item->post_title,
                'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                'button' => isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : ['text' => isset($item_fields['route']) && $item_fields['route'] == true ? __('Ver ruta', 'cclb') : __('Ver exposición', 'cclb'), 'url' => get_permalink($item->ID)],
            ];
        }, $fields);

        return $section;
    }

    public function getResutlWithFiltersCards($cards, $cards_rel, $type_card)
    {
        $section = [];

        if (empty($cards) && !is_array($cards_rel)) {
            return $section;
        }

        if ($type_card == 'event-02') {
            if (!empty($cards)) {
                $section = array_map(function ($item) {
                    return [
                        'image' => isset($item['image']) && !empty($item['image']) ? $this->getImgArray($item['image']) : [],
                        'title' => isset($item['title']) && !empty($item['title']) ? $item['title'] : '',
                        'button' => isset($item['button']) && !empty($item['button']) ? $this->getButtonExt($item['button']) : [],
                    ];
                }, $cards);
            }
        } else if ($type_card == 'event-03') {
            if (!empty($cards_rel)) {
                $section = array_map(function ($item) {
                    $item_fields = get_fields($item->ID);
                    $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
                    $categories = [];
                    if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                        $button = [
                            'text' => __('Ver más', 'cclb'),
                            'url' => get_permalink($item),
                            'external' => false,
                        ];
                    } else{
                        $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                            'text' => __('Ver más', 'cclb'),
                            'url' => get_permalink($item),
                            'external' => false,
                        ];
                    }
                    if (is_array($cat) && !empty($cat)) {
                        $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                        if (!empty($cat_fields)) {
                            $categories[] =  [
                                'text' => $cat[0]->name,
                                'text_color' => $cat_fields['text_color'],
                                'bg_color' => $cat_fields['bg_color'],
                            ];
                        }
                    }
                    return [
                        'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                        'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                        'title' => $item->post_title,
                        'categories' => $categories,
                        'button' => $button,
                    ];
                }, $cards_rel);
            }
        } else if ($type_card == 'news') {
            if (!empty($cards_rel)) {
                $section = array_map(function ($item) {
                    $item_fields = get_fields($item->ID);
                    $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
                    $categories = [];
                    if (is_array($cat) && !empty($cat)) {
                        $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                        if (!empty($cat_fields)) {
                            $categories[] =  [
                                'text' => $cat[0]->name,
                                'text_color' => $cat_fields['text_color'],
                                'bg_color' => $cat_fields['bg_color'],
                            ];
                        }
                    }
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->post_date, 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM YYYY');

                    return [
                        'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : $date,
                        'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                        'title' => $item->post_title,
                        'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                        'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                        'tags' => $categories,
                        'title_variant' => true,
                        'button' => ['text' => __('ver más', 'cclb'), 'url' => get_permalink($item->ID), 'external' => false],
                    ];
                }, $cards_rel);
            }
        } else if ($type_card == 'event-01') {
            if (!empty($cards_rel)) {
                $section = array_map(function ($item) {
                    $item_fields = get_fields($item->ID);
                    $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
                    $categories = [];
                    if (is_array($cat) && !empty($cat)) {
                        $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                        if (!empty($cat_fields)) {
                            $categories[] =  [
                                'text' => $cat[0]->name,
                                'text_color' => $cat_fields['text_color'],
                                'bg_color' => $cat_fields['bg_color'],
                            ];
                        }
                    }
                    return [
                        'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                        'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                        'title' => $item->post_title,
                        'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                        'address' => isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : '',
                        'categories' => $categories,
                        'button' => ['text' => __('ver más', 'cclb'), 'url' => get_permalink($item->ID), 'external' => false],
                    ];
                }, $cards_rel);
            }
        }

        return $section;
    }

    public function getFilters($action)
    {
        $section = [];

        if (empty($action)) {
            return $section;
        }


        if($action == 'noticias'){
            $types = get_terms(array(
                'post_types' => 'news',
                'taxonomy' => 'type_news',
                'hide_empty' => true,
            ),);

            if (is_array($types) && !empty($types)) {
                $types = array_map(function ($item) {
                    return
                        [
                            'label' => $item->name,
                            'value' => $item->slug,
                        ];
                }, $types);
                $array = [];
                $types = array_merge($types, $array);
                $section[] = [
                    'label' => __('Tipo de Noticia', 'cclb'),
                    'value' => 'tipo_de_noticia',
                    'placeholder' => __('Seleccionar Noticia', 'cclb'),
                    'options' => (array)$types
                ];
            }

            $categories = get_terms(array(
                'post_categories' => 'news',
                'taxonomy' => 'category_news',
                'hide_empty' => true,
            ),);
    
            if (is_array($categories) && !empty($categories)) {
                $categories = array_map(function ($item) {
                    return
                        [
                            'label' => $item->name,
                            'value' => $item->slug,
                        ];
                }, $categories);
                $array = [];
                $categories = array_merge($categories, $array);
                $section[] = [
                    'label' => __('Categoría', 'cclb'),
                    'value' => 'categoria',
                    'placeholder' => __('Seleccionar Categoría', 'cclb'),
                    'options' => (array)$categories
                ];
            }
            $spaces = get_terms(array(
                'post_types' => 'news',
                'taxonomy' => 'space_news',
                'hide_empty' => true,
            ),);
    
            if (is_array($spaces) && !empty($spaces)) {
                $spaces = array_map(function ($item) {
                    return
                        [
                            'value' => $item->slug,
                            'label' => $item->name
                        ];
                }, $spaces);
    
                $section[] = [
                    'label' => __('Espacio/Sede', 'cclb'),
                    'value' => 'espacio_sede',
                    'placeholder' => __('Seleccionar Espacio/Sede', 'cclb'),
                    'options' => $spaces
                ];
            }

            return $section;
        }


        $types = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'type_participate',
            'hide_empty' => true,
        ),);

        if (is_array($types) && !empty($types)) {
            $types = array_map(function ($item) {
                return
                    [
                        'label' => $item->name,
                        'value' => $item->slug,
                    ];
            }, $types);
            $array = [];
            $types = array_merge($types, $array);
            $section[] = [
                'label' => __('Tipo de Actividad', 'cclb'),
                'value' => 'tipo_de_actividad',
                'placeholder' => __('Seleccionar Actividad', 'cclb'),
                'options' => (array)$types
            ];
        }

        $categories = get_terms(array(
            'post_categories' => 'participate',
            'taxonomy' => 'category_participate',
            'hide_empty' => true,
        ),);

        if (is_array($categories) && !empty($categories)) {
            $categories = array_map(function ($item) {
                return
                    [
                        'label' => $item->name,
                        'value' => $item->slug,
                    ];
            }, $categories);
            $array = [];
            $categories = array_merge($categories, $array);
            $section[] = [
                'label' => __('Categoría', 'cclb'),
                'value' => 'categoria',
                'placeholder' => __('Seleccionar Categoría', 'cclb'),
                'options' => (array)$categories
            ];
        }
        $spaces = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'space_participate',
            'hide_empty' => true,
        ),);

        if (is_array($spaces) && !empty($spaces)) {
            $spaces = array_map(function ($item) {
                return
                    [
                        'value' => $item->slug,
                        'label' => $item->name
                    ];
            }, $spaces);

            $section[] = [
                'label' => __('Espacio/Sede', 'cclb'),
                'value' => 'espacio_sede',
                'placeholder' => __('Seleccionar Espacio/Sede', 'cclb'),
                'options' => $spaces
            ];
        }

        $costs = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'cost_participate',
            'hide_empty' => true,
        ),);

        if (is_array($costs) && !empty($costs)) {
            $costs = array_map(function ($item) {
                return
                    [
                        'value' => $item->slug,
                        'label' => $item->name
                    ];
            }, $costs);

            $section[] = [
                'label' => __('Costo', 'cclb'),
                'value' => 'costo',
                'placeholder' => __('Seleccionar Costo', 'cclb'),
                'options' => $costs
            ];
        }

        return $section;
    }
    public function getFiltersBadges($action)
    {
        $section = [];

        if (empty($action)) {
            return $section;
        }

        if ($action == 'material') {
            $categories = get_terms(array(
                'post_categories' => 'material',
                'taxonomy' => 'category_material',
                'hide_empty' => true,
            ),);

            if (is_array($categories) && !empty($categories)) {
                $section = array_map(function ($item) {
                    $icons = (get_term_meta($item->term_id));
                    $icon_default = isset($icons['icons_default']) && !empty($icons['icons_default']) ? wp_get_attachment_url($icons['icons_default'][0], "full") : '';
                    $icon_hover = isset($icons['icons_hover']) && !empty($icons['icons_hover']) ? wp_get_attachment_url($icons['icons_hover'][0], "full") : '';
                    $cat_fields = get_field('icons', 'category_' . 'material' . '_' . $item->term_id);
                    return
                        [
                            'label' => $item->name,
                            'value' => $item->slug,
                            'icon' => [
                                'default' => $icon_default,
                                'hover' => $icon_hover,
                            ]
                        ];
                }, $categories);
            }
        }


        return $section;
    }

    public function getScheduleSelectFilter()
    {
        $section = [];

        $types = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'type_participate',
            'hide_empty' => true,
        ),);

        if (is_array($types) && !empty($types)) {
            $types = array_map(function ($item) {
                return
                    [
                        'label' => $item->name,
                        'value' => $item->slug,
                    ];
            }, $types);
            $array = [];
            $types = array_merge($types, $array);
            $section[] = [
                'label' => __('Tipo de Actividad', 'cclb'),
                'value' => 'tipo_de_actividad',
                'placeholder' => __('Seleccionar Actividad', 'cclb'),
                'options' => (array)$types
            ];
        }
        $spaces = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'space_participate',
            'hide_empty' => true,
        ),);

        if (is_array($spaces) && !empty($spaces)) {
            $spaces = array_map(function ($item) {
                return
                    [
                        'value' => $item->slug,
                        'label' => $item->name
                    ];
            }, $spaces);

            $section[] = [
                'label' => __('Espacio/Sede', 'cclb'),
                'value' => 'espacio_sede',
                'placeholder' => __('Seleccionar Espacio/Sede', 'cclb'),
                'options' => $spaces
            ];
        }

        $costs = get_terms(array(
            'post_types' => 'participate',
            'taxonomy' => 'cost_participate',
            'hide_empty' => true,
        ),);

        if (is_array($costs) && !empty($costs)) {
            $costs = array_map(function ($item) {
                return
                    [
                        'value' => $item->slug,
                        'label' => $item->name
                    ];
            }, $costs);

            $section[] = [
                'label' => __('Costo', 'cclb'),
                'value' => 'costo',
                'placeholder' => __('Seleccionar Costo', 'cclb'),
                'options' => $costs
            ];
        }



        return $section;
    }

    public function getSchedulebadgesFilter()
    {
        $section = [];

        $section = [
            [
                'label' => __('Hoy', 'cclb'),
                'value' => 'today',
            ],
            [
                'label' => __('Semana', 'cclb'),
                'value' => 'week',
            ],
            [
                'label' => __('Mes', 'cclb'),
                'value' => 'month',
            ],
            [
                'label' => __('Año', 'cclb'),
                'value' => 'year',
            ],
        ];
        return $section;
    }

    public function getTextArray($fields, $key = 'text')
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) use ($key) {
            return
                $item[$key] ?? '';
        }, $fields);
        return $section;
    }

    public function getButtonExt($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        return [
            'url' => $fields['url'],
            'text' => $fields['title'],
            'external' => $fields['target'] == '_blank',
        ];
    }

    public function getSecondaryLinks($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        return [
            'url' => $fields['url'],
            'label' => $fields['title'],
            'external' => $fields['target'] == '_blank',
        ];
    }

    public function getColumnTopLinks($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        return [
            'url' => $fields['url'],
            'title' => $fields['title'],
            'external' => $fields['target'] == '_blank',
        ];
    }
    public function getImgArray($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        return [
            'src' => $fields['url'],
            'alt' => $fields['alt'],
        ];
    }

    public function getGallery($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            return [
                'image' => $item['image']['url'],
                'alt' => $item['image']['alt']
            ];
        }, $fields);
        return $section;
    }

    public function getShareLink($fields, $post_permalink)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) use($post_permalink) {
            return [
                'icon' => $item['icon'],
                'title' => $item['title'],
                'url' => $item['url'] . $post_permalink,
                'target' => $item['target'],
                'background_color' => $item['background_color'],
                'border_color' => $item['border_color'],
                'text_color' => $item['text_color'],
                'text_color_hover' => $item['text_color_hover'],
            ];
        }, $fields);
        return $section;
    }

    public function getLinkOfInterest($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $section = array_map(function ($item) {
            $link = $item['link'];
            $link['label'] = $item['label'];
            return $link;
        }, $fields);
        return $section;
    }

    public function getBlogItems($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item);
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->post_date, 'America/Santiago')->locale('es')->isoFormat('DD/MM/YYYY');
            $tags = [];
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);

            if (is_array($cat) && !empty($cat)) {
                foreach ($cat as $c) {
                    $cat_fields = get_field('color_tag', 'tag_' . $item->post_type . '_' . $c->term_id, $item);
                    if (!empty($cat_fields)) {
                        $tags[] =  [
                            'text' => $c->name,
                            'color' => $cat_fields,
                        ];
                    }
                }
            }
            return 
                [
                    'thumbnail' => isset($item_fields['thumbnail_ext']) && !empty($item_fields['thumbnail_ext']) ? $item_fields['thumbnail_ext'] : [],
                    'tags' => $tags,
                    'date' => $date,
                    'title' => $item->post_title,
                    'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                    'url' => get_permalink($item),
                ];
        }, $fields);
        return $section;
    }
    public function getScheduleFormatData($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
            $categories = [];
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'text' => $cat[0]->name,
                        'text_color' => $cat_fields['text_color'],
                        'bg_color' => $cat_fields['bg_color'],
                    ];
                }
            }
            if(isset($item_fields['layout_modules']) && !empty($item_fields['layout_modules'])){
                $button = [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            } else{
                $button = isset($item_fields['button']) && !empty($item_fields['button']) ? $this->getButtonExt($item_fields['button']) : [
                    'text' => __('Ver más', 'cclb'),
                    'url' => get_permalink($item),
                    'external' => false,
                ];
            }
            return [
                'categories' => $categories,
                'date' => isset($item_fields['date']) && !empty($item_fields['date']) ? Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('DD [de] MMMM') : '',
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'title' => $item->post_title,
                'hour' => isset($item_fields['hour']) && !empty($item_fields['hour']) ? $item_fields['hour'] : '',
                'address' => isset($item_fields['address']) && !empty($item_fields['address']) ? $item_fields['address'] : '',
                'button' => $button,
            ];
        }, $fields);
        return $section;
    }

    public function getMateialFormatData($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $cat = wp_get_post_terms($item->ID, 'tag_' . $item->post_type, ['name']);
            $categories = [];
            if (is_array($cat) && !empty($cat)) {
                $cat_fields = get_field('color_tag', 'category_' . $item->post_type . '_' . $cat[0]->term_id, $item);
                if (!empty($cat_fields)) {
                    $categories[] =  [
                        'value' => $cat[0]->name,
                    ];
                }
            }

            return [
                'tag' => $categories,
                'image' => isset($item_fields['image']) && !empty($item_fields['image']) ? $this->getImgArray($item_fields['image']) : [],
                'title' => $item->post_title,
                'author' => isset($item_fields['author']) && !empty($item_fields['author']) ? $item_fields['author'] : '',
                'description' => isset($item_fields['description']) && !empty($item_fields['description']) ? $item_fields['description'] : '',
                'button' => [
                    'text' => 'Descargar',
                    'url' => $item_fields['file']
                ],
            ];
        }, $fields);
        return $section;
    }

    public function getScheduleDayListFormatData($fields)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }

        $section = array_map(function ($item) {
            $item_fields = get_fields($item->ID);
            $date = $item_fields['date'];
            $carbon_date = Carbon::createFromFormat('d/m/Y', $item_fields['date'], 'America/Santiago')->locale('es')->isoFormat('dddd DD');
            $date = explode('/', $date);
            return  [
                'label' => ucfirst($carbon_date),
                'day' => $date[0],
                'month' => $date[1],
                'year' => $date[2],
            ];
        }, $fields);

        $section = array_values(array_unique($section, SORT_REGULAR));
        return $section;
    }

    public function getAside($fields, $post = null)
    {
        $section = [];

        if (empty($fields) || !is_array($fields)) {
            return $section;
        }
        $button_download = [];
        if (isset($fields['program']) && !empty($fields['program'])) {

            $button_download = [
                'text' => __('Descargar programa', 'cclb'),
                'url' => $fields['program'],
            ];
        }
        $share = [];
        if (isset($fields['show_links']) && $fields['show_links'] == true) {
            $share_links = get_field('share_links', 'option');
            if (!empty($share_links)) {
                $share['title'] = __('Compartir', 'cclb');
                $share['social_networks'] = [
                    [
                        'name' => 'facebook',
                        'url' => $share_links['facebook'] . get_permalink($post),
                    ],
                    [
                        'name' => 'twitter',
                        'url' => $share_links['twitter'] . get_permalink($post),
                    ],
                    [
                        'name' => 'linkedin',
                        'url' => $share_links['linkedin'] . get_permalink($post),
                    ],
                ];
            }
        }
        $section['title'] = $fields['title'];
        $section['date'] = $fields['date'];
        $section['location'] = $fields['location'];
        $section['category_area'] = $fields['category_area'];
        $section['how_to_get_there'] = $fields['how_to_get_there'];
        $section['contact'] = $fields['contact'];
        $section['ticket'] = $fields['ticket'];
        $section['button'] = $this->getButtonExt($fields['button']);
        $section['image'] = isset($fields['image']) ? $this->getImgArray($fields['image']) : [];
        $section['button_download'] = $button_download;
        $section['share'] = $share;
        return $section;
    }


    public function getSocial($fields)
    {
        $section = [];

        if (empty($fields)) {
            return $section;
        }
        

        $section = array_map(function ($item) {
            $svg_file = file_get_contents('http://localhost:8080/resources/images/icons/white_tiktok.svg');
            dd($svg_file);
            $find_string   = '<svg';
            $position = strpos($svg_file, $find_string);

            $svg_file_new = substr($svg_file, $position);
            dd($svg_file_new);
          
        }, $fields);
        return $section;
    }

    public function getCategoriesBlogFilter($fields)
    {
        $section = [];

        if (empty($fields)) {
            return $section;
        }
        

        $section = array_map(function ($item) {
           return [
            'slug' => $item->slug,
            'label' => $item->name
           ];
          
        }, $fields);
        return $section;
    }

    public function getSVGCode($filePath) {
        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the content of the SVG file
            $svgCode = file_get_contents($filePath);
    
            // Return the SVG code
            return $svgCode;
        } else {
            // File doesn't exist
            return false;
        }
    }
}
