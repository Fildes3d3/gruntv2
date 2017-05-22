<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package newsworthy
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses newsworthy_header_style()
 * @uses newsworthy_admin_header_style()
 * @uses newsworthy_admin_header_image()
 *
 * @package newsworthy
 */
function newsworthy_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'newsworthy_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '00aeef',
		'width'                  => 600,
		'height'                 => 120,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'newsworthy_header_style',
		'admin-head-callback'    => 'newsworthy_admin_header_style',
		'admin-preview-callback' => 'newsworthy_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'newsworthy_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package newsworthy
 * @since newsworthy 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'newsworthy_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see newsworthy_custom_header_setup().
 *
 * @since newsworthy 1.0
 */
function newsworthy_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // newsworthy_header_style

if ( ! function_exists( 'newsworthy_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see newsworthy_custom_header_setup().
 *
 * @since newsworthy 1.0
 */
function newsworthy_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background: #f2f2f2;
		border: 1px solid #dfdfdf;
		font-family: 'Oswald', Tahoma, Geneva, sans-serif;
		padding: 5px;
		text-align: left;
		max-width: 610px;
	}
	#headimg h1,
	#description {
	}
	#headimg h1 {
		padding: 0;
		margin-bottom: 5px;
		font-family: 'Oswald', Tahoma, Geneva, sans-serif;
		font-size: 44px;
		font-weight: 700;
		line-height: 50px;
		text-shadow: 1px 1px #fff;
		text-transform: uppercase;
	}
	#headimg h1 a {
		color: #00aeef;
		text-decoration: none;
	}
	#description {
		font-family: 'Oswald', Tahoma, Geneva, sans-serif;
		font-weight: 400;
		color: #000;
		text-transform: uppercase;
		font-size: 14px;
	}
	#headimg img {
		width: auto;
		max-height: 120px;
		overflow: hidden;
	}
	</style>
<?php
}
endif; // newsworthy_admin_header_style

if ( ! function_exists( 'newsworthy_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see newsworthy_custom_header_setup().
 *
 * @since newsworthy 1.0
 */
function newsworthy_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() ) {
			$style = ' style="display:none;"';
			$desc_style = ' style="display:none;"';
		} else {
			$style = ' style="color:#' . get_header_textcolor() . ';"';
			$desc_style = '';
		}
		?>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) { ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php } ?>
			<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div class="displaying-header-text" id="description"<?php echo $desc_style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; // newsworthy_admin_header_image