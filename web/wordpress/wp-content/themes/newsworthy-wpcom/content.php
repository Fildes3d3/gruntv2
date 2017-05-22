<?php
/**
 * @package Newsworthy
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="posted-meta">
    	<div class="date-meta">
        	<a href="<?php the_permalink() ?>" rel="bookmark"><?php printf( __('%s', 'newsworthy'), get_the_date( 'm.d.y' ) ); ?></a>
        </div>
        <div class="author-meta">
        	<?php printf( __( 'by <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>', 'newsworthy' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'newsworthy' ), get_the_author() ) ),
				esc_html( get_the_author() )
			);
			?>
        </div>
    </div><!-- end .posted-meta -->
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'newsworthy' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'newsworthy' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php newsworthy_posted_on(); ?>
		<span class="sep"> | </span>
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'newsworthy' ) );
				if ( $categories_list && newsworthy_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'newsworthy' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'newsworthy' ) );
				if ( $tags_list ) :
			?>
			<span class="sep"> | </span>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'newsworthy' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( '0 comments', 'newsworthy' ), __( '1 Comment', 'newsworthy' ), __( '% Comments', 'newsworthy' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'newsworthy' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->