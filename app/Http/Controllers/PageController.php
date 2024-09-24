<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Traits\Formatter;
use Carbon\Carbon;

class PageController extends Controller
{
  use Formatter;

    public function detail($post)
    {
        $fields = [];

       
        $fields = get_field('layout_modules', $post) ?? [];
        $fields['layout_modules'] = $this->formatModules(isset($fields) ? $fields : [], $post);
        return view('pages.modules', compact('fields'));
    }

    // public function page404($post = null){
    //   $fields = get_field('error_404_page', 'option');
    //   return view('pages.error-404', compact('fields'));
    // }
  
    // public function thankyou($post = null){
    //   $fields = get_field('ty_page', 'option');
    //   $fields['buttons'] = isset($fields['buttons']) ? (new Post())->getButtonsPrimary($fields['buttons']) : [];
    //   return view('pages.thank-you', compact('fields'));
    // }
}
