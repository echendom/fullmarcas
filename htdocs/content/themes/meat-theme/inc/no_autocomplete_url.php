<?php 


    //Para quitar el autocompletado de url
    function remove_redirect_guess_404_permalink( $redirect_url ) {
        if ( is_404() && !isset($_GET['p']) )
            return false;
        return $redirect_url;
    }
    add_filter( 'redirect_canonical', 'remove_redirect_guess_404_permalink' );