<?php
/**
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @package Newsworthy
 */
if ( ! isset( $content_width ) )
	$content_width = 585; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'newsworthy_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function newsworthy_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'newsworthy', get_template_directory() . '/languages' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'newsworthy' ),
	) );

	/**
	 * Visual editor
	 */
	add_editor_style();


	/**
	 * Post formats
	 */
	add_theme_support( 'post-formats',
		array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		)
	);

	/**
	 * Enable support for Social Links
	 */
	add_theme_support( 'social-links', array( 'facebook', 'twitter', 'linkedin', 'tumblr' ) );
}
endif;
add_action( 'after_setup_theme', 'newsworthy_setup' );

/**
 * Custom background
 */
$newsworthy_custom_background = array(
	'default-color' => 'f2f2f2',
);
add_theme_support( 'custom-background', $newsworthy_custom_background );


/**
* Register widgetized area and update sidebar with default widgets
*/
function newsworthy_widgets_init() {
register_sidebar( array(
	'name' => __( 'Sidebar', 'newsworthy' ),
	'id' => 'sidebar',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => "</aside>",
	'before_title' => '<h2 class="widget-title">',
	'after_title' => '</h2>',
) );

}
add_action( 'widgets_init', 'newsworthy_widgets_init' );


/**
 * Adds custom classes to the array of body classes.
 */
function newsworthy_body_classes( $classes ) {
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'newsworthy_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 */
function newsworthy_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so newsworthy_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so newsworthy_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in newsworthy_categorized_blog
 */
function newsworthy_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'newsworthy_category_transient_flusher' );
add_action( 'save_post', 'newsworthy_category_transient_flusher' );

/**
 * Enqueue Google Fonts
 */
function newsworthy_fonts() {

	$protocol = is_ssl() ? 'https' : 'http';

	/*	translators: If there are characters in your language that are not supported
		by Carrois Gothic, translate this to 'off'. Do not translate into your own language. */

	if ( 'off' !== _x( 'on', 'Oswald font: on or off', 'newsworthy' ) ) {
		wp_register_style( 'newsworthy-oswald', "$protocol://fonts.googleapis.com/css?family=Oswald:400,700,300" );
	}
}
add_action( 'init', 'newsworthy_fonts' );

/**
 * Enqueue font styles in custom header admin
 */
function newsworthy_admin_fonts( $hook_suffix ) {

	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'newsworthy-oswald' );

}
add_action( 'admin_enqueue_scripts', 'newsworthy_admin_fonts' );

/**
 * Enqueue scripts and styles
 */
function newsworthy_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'newsworthy-oswald' );

	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20120206', true );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'newsworthy_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

// updater for WordPress.com themes
if ( is_admin() )
	include dirname( __FILE__ ) . '/inc/updater.php';
