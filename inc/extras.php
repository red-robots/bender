<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bender
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bender_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$bender_sticky_header = get_theme_mod( 'bender_sticky_header_disable' );
	if ( $bender_sticky_header == '' ) {
		$classes[] = 'sticky-header';
	}

	return $classes;
}
add_filter( 'body_class', 'bender_body_classes' );


if ( ! function_exists( 'bender_custom_excerpt_length' ) ) :
/**
 * Custom excerpt length for the theme
 */
function bender_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'bender_custom_excerpt_length', 999 );
endif;


if ( ! function_exists( 'bender_new_excerpt_more' ) ) :
/**
 * Remove […] string using Filters
 */
function bender_new_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'bender_new_excerpt_more');
endif;
