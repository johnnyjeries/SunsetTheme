<?php
/*

@package sunsetTheme

==============================
REMOVE GENERATOR VERSION NUMBER
==============================
wordpress automatically add the a meta tag in header showing the wordpress version, if it still shows it may expose us to security issues the version had or still has
so we delete here as cleanup
*/

// remove version string from js and css
function sunset_remove_wp_version_strings( $src ){
    //$src passed by wp filter and has the js and css source files
    //wp_version has the current version of wp
    global $wp_version;
    parse_str( parse_url($src, PHP_URL_QUERY), $query );
    //parse url checks for url inside the $srcm PHP_URL_QUERY checks for the version inside the url "ver=4.4.4",
    //$query is the new variable where we will store the result
    if ( !empty( $query['ver'] ) && $query['ver'] === $wp_version ){
        //remove the version query from the source
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
// load the filter which calls all the scripts that we are including in the footer, and the name of our function that cleans the scripts
add_filter( 'script_loader_src', 'sunset_remove_wp_version_strings' );
//  same for style files
add_filter( 'style_loader_src', 'sunset_remove_wp_version_strings' );


//remove metatag generator from header
function sunset_remove_meta_version(){
    return '';
}

// the generator has only the version of wp, if we call for the filter generator and add our function, wp will call it and print whatever we have in the function.
add_filter( 'the_generator', 'sunset_remove_meta_version' );