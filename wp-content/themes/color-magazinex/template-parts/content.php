<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_content_type 	= apply_filters( 'color_magazinex_archive_post_content_type', 'excerpt' );

if ( has_post_thumbnail() ) {
    $post_class = 'has-thumbnail';
} else {
    $post_class = 'no-thumbnail';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<div class="thumb-cat-wrap">
		<?php
			color_magazinex_post_thumbnail();
			color_magazinex_article_categories_list();
		?>
	</div><!-- .thumb-cat-wrap -->
	<?php
		// post meta
		get_template_part( 'template-parts/partials/post/meta' );

		// post entry title
		get_template_part( 'template-parts/partials/post/entry', 'title' );
	?>
	<div class="entry-content">
		<?php
			if ( 'excerpt' === $post_content_type ) {
				the_excerpt();
			} elseif ( 'content' === $post_content_type ) {
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'color-magazinex' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
			        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'color-magazinex' ),
			        'after'  => '</div>',
			    ) );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php color_magazinex_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->