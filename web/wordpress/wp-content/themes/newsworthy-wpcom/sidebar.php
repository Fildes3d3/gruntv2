<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Newsworthy
 */

$services = get_theme_support( 'social-links' );
?>
		<div id="sidebar" class="widget-area sidebar-column" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>

			<?php if ( newsworthy_has_social_links() ) : ?>
			<div class="social-links">
				<h2><?php _e( 'Connect', 'newsworthy' ); ?></h2>
				<ul class="clearfix">
					<?php
						foreach ( $services[0] as $service ) :
							$$service = get_theme_mod( "jetpack-$service" );
							if ( $$service ) :
					?>
					<li class="<?php echo esc_attr( $service ); ?>-link">
						<a href="<?php echo esc_url( $service ); ?>" title="<?php echo esc_attr( ucfirst( $service ) ); ?>" target="_blank">
							<?php echo ucfirst( $service ); ?>
						</a>
					</li>
					<?php
							endif;
						endforeach;
					?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

				<aside id="archives" class="widget">
					<h2 class="widget-title"><?php _e( 'Archives', 'newsworthy' ); ?></h2>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

				<aside id="meta" class="widget">
					<h1 class="widget-title"><?php _e( 'Meta', 'newsworthy' ); ?></h1>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</aside>

			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
