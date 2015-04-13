<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package YuMag
 */

if ( ! function_exists( 'yumag_get_featured_posts' ) ) :
/**
 * Getter function for Jetpack Featured Content module.
 *
 * @since 1.0.0
 * @link http://jetpack.me/support/featured-content/
 *
 * @return array The featured posts.
 */
function yumag_get_featured_posts() {
    return apply_filters( 'yumag_get_featured_posts', array() );
}
endif;

if ( ! function_exists( 'yumag_has_featured_posts' ) ) :
/**
 * Conditional function for Jetpack Featured Content module.
 *
 * @since 1.0.0
 * @link http://jetpack.me/support/featured-content/
 *
 * @param int $minimum Minimum number of featured posts being checked for.
 * @return bool Whether featured posts will be outputted and the minimum number
 *              of featured posts is present.
 */
function yumag_has_featured_posts( $minimum = 1 ) {

	$pp = new PeriodicalPress_Template_Tags();

    if ( ! $pp->is_issue() ) {
        return false;
    }

    $minimum = absint( $minimum );
    $featured_posts = apply_filters( 'yumag_get_featured_posts', array() );

    if ( ! is_array( $featured_posts ) ) {
        return false;
    }

    if ( $minimum > count( $featured_posts ) ) {
        return false;
    }

    return true;
}
endif;