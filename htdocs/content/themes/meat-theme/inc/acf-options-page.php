<?php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Opciones generales',
        'menu_title' => 'Opciones generales',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts', //edit_posts
        'redirect' => true
    ));
    
    acf_add_options_sub_page(array(
        'page_title' => 'Links Compartir',
        'menu_title' => 'Links Compartir',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Registro de marca',
        'menu_title' => 'Registro de marca',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Error 404',
        'menu_title' => 'Error 404',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Error TBK',
        'menu_title' => 'Error TBK',
        'parent_slug' => 'theme-general-settings',
    ));


    acf_add_options_sub_page(array(
        'page_title' => 'Header',
        'menu_title' => 'Header',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Emails Form',
        'menu_title' => 'Emails Form',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'HubSpot',
        'menu_title' => 'HubSpot',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'TYP Registro',
        'menu_title' => 'TYP Registro',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Info general mail',
        'menu_title' => 'Info general mail',
        'parent_slug' => 'theme-general-settings',
    ));


}