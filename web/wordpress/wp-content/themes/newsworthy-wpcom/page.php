<?php
/**
 * The template for displaying all pages.
 *
 *
 * @package Newsworthy
 */

get_header(); ?>

    <div id="content" class="clearfix">

        <div id="main" class="column clearfix" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->

<?php get_footer(); ?>