<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _svbk
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _svbk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', '_svbk_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function _svbk_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', '_svbk_pingback_header' );

add_filter( 'get_the_archive_title', '_svbk_archive_title');

function _svbk_archive_title($title) {

    if ( is_category() ) {
        $title = single_cat_title( '', false ) ;
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;
    }

    return $title;
}

function _svbk_post_has_more() {
	global $post;
	
	return boolval( strpos( $post->post_content, '<!--more-->') );
}

function _svbk_the_whole_content() {
	global $more;

	$real_more = $more;
	$more = 1;
	the_content(null, true);
	$more = $real_more;	
}
