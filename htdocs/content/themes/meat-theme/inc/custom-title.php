<?php

use Illuminate\Support\Facades\Request;

add_filter( 'pre_get_document_title', 'custom_wp_title', 10, 2);
add_filter( 'wpseo_title', 'custom_wp_title');

function custom_wp_title($title) 
{
    if ( !is_page() ) {
        if ( !empty(Request::segment(1)) && (str_contains(Request::segment(1), 'registra-tu-marca') == true || str_contains(Request::segment(1), 'registro-gracias') == true || str_contains(Request::segment(1), 'pay_confirmation') == true) ) {
            $title = get_option( 'blogname' );
        }
    }
    return $title;
}