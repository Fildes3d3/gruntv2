<?php
/**
 * The Header for our theme.
 *
 * @package Newsworthy
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php bloginfo('name'); ?><?php wp_title('|',true,''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="nav-wrapper">
<nav id="site-navigation" class="navigation-main" role="navigation">
	<div class="menu-wrapper">
	<h1 class="menu-toggle"><?php _e( 'Menu', 'newsworthy' ); ?></h1>
	<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'newsworthy' ); ?>"><?php _e( 'Skip to content', 'newsworthy' ); ?></a></div>

	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
</div>

<div id="container">
<?php do_action( 'before' ); ?>
	<header id="branding" role="banner">
      <div id="inner-header" class="clearfix">
		<hgroup id="site-heading">
			<?php
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
				</a>
			<?php } ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

        <?php get_search_form(); ?>
      </div>
	</header><!-- #branding -->