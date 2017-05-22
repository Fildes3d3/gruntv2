<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Newsworthy
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function newsworthy_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'newsworthy_infinite_scroll_setup' );

if ( function_exists( 'jetpack_is_mobile' ) ) {

    function newsworthy_has_footer_widgets() {
        if ( jetpack_is_mobile( '', true ) && is_active_sidebar( 'sidebar' ) )
            return true;

        return false;
    }
    add_filter( 'infinite_scroll_has_footer_widgets', 'newsworthy_has_footer_widgets' );
}

function newsworthy_has_social_links() {
	return apply_filters( 'jetpack_has_social_links', false );
}