<?php

namespace App\Traits;

use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait Formatter
{
    public function formatModules($modules, $post = null) : array
    {
        if (!empty($modules)) {
            foreach ($modules as $key => $layout) {
                
                if ($layout['acf_fc_layout'] == 'blog-content-image-gallery') {
                  $modules[$key]['image_gallery'] = (new Post())->getTextArray($layout['image_gallery'],'image');
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

                if ($layout['acf_fc_layout'] == 'step-by-step') {
                  $modules[$key]['title'] = str_replace(['<p>', '</p>'], '', $layout['title']);
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

                if ($layout['acf_fc_layout'] == 'blog-content-links-of-interest') {
                  $modules[$key]['links_of_interest'] = (new Post())->getLinkOfInterest($layout['links_of_interest']);
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

                if ($layout['acf_fc_layout'] == 'blog-listing-inline') {
                  $modules[$key]['items'] = (new Post())->getBlogItems($layout['items']);
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

                if ($layout['acf_fc_layout'] == 'hero-blog') {
                  $modules[$key]['highlighted_posts'] = (new Post())->getBlogItems($layout['highlighted_posts']);
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

                if ($layout['acf_fc_layout'] == 'blog-listing') {
                  $modules[$key]['categories'] = (new Post())->getCategoriesBlogFilter($layout['categories']);
                  $modules[$key]['action'] = 'blog';
                  // $modules[$key]['description'] = isset($layout['description']) && !empty($layout['description']) ? str_replace(['<p>', '</p>'],'',$layout['description']) : '';
                  // $modules[$key]['button'] = (new Post())->getButtonExt(isset($layout['button']) ? $layout['button'] : []);
                  $modules[$key]['acf_fc_layout'] = $layout['acf_fc_layout']; // don't remove this 
                }

          }
        }
        return is_array($modules) ? $modules : [];
    }
}