<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Newsworthy
 */

if ( ! function_exists( 'newsworthy_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since newsworthy 1.0
 */
function newsworthy_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'newsworthy' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'newsworthy' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'newsworthy' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'newsworthy' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'newsworthy' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // newsworthy_content_nav

/**
 * Template for comments and pingbacks.
 */
function newsworthy_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'newsworthy' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'newsworthy' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <footer class="clearfix comment-head">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 40 ); ?>

            </div><!-- .comment-author .vcard -->
            <?php printf( __( '%s', 'newsworthy' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em><?php _e( 'Your comment is awaiting moderation.', 'newsworthy' ); ?></em>
                <br />
            <?php endif; ?>

            <div class="comment-meta commentmetadata">
                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
                <?php
                    /* translators: 1: date, 2: time */
                    printf( __( '%1$s <br /> %2$s', 'newsworthy' ), get_comment_date(), get_comment_time() ); ?>
                </time></a>
                <?php edit_comment_link( __( 'Edit', 'newsworthy' ), ' ' );
                ?>
            </div><!-- .comment-meta .commentmetadata -->
        </footer>
		<article id="comment-<?php comment_ID(); ?>" class="comment">


			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->

		</article><!-- #comment-## -->
        <div class="clearfix"></div>

	<?php
			break;
	endswitch;
}

if ( ! function_exists( 'newsworthy_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since newsworthy 1.0
 */
function newsworthy_posted_on() {
	printf( __( '<span class="post-format-link"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span> </span>', 'newsworthy' ),
		esc_url( get_post_format_link( get_post_format() ) ),
		esc_attr( sprintf( __( 'Permalink to %s', 'newsworthy' ), get_post_format() ) ),
		get_post_format_string( get_post_format() ),
		esc_url( get_permalink() )
	);
}
endif;