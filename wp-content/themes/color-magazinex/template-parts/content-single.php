<?php
/**
 * Template part for displaying single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( has_post_thumbnail() ) {
    $post_class = 'has-thumbnail';
} else {
    $post_class = 'no-thumbnail';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<div class="post-thumbnail">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'full' );
			}
		?>
		<div class="post-info-wrap">
			<div class="post-cat"><?php color_magazinex_article_categories_list(); ?></div><!-- .post-cat -->
			<?php
				// post meta
				get_template_part( 'template-parts/partials/post/meta' );

				// post entry title
				get_template_part( 'template-parts/partials/post/entry', 'title' );
			?>
	    </div><!--.post-info-wrap -->
	</div><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php
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
		?>
	</div> <!-- .entry-content -->

	<footer class="entry-footer">
		<?php color_magazinex_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php
		// author box
		get_template_part( 'template-parts/partials/post/author', 'box' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->