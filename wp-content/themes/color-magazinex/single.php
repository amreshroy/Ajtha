<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<div class="mt-single-post-page-wrapper">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php

			/**
			 * Hook: color_magazinex_before_single_post_loop
			 *
			 *
			 * @since 1.0.0
			 */
			do_action( 'color_magazinex_before_single_post_loop' );

			while ( have_posts() ) :

				the_post();

				get_template_part( 'template-parts/content', 'single' );

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.

			/**
			 * Hook: color_magazinex_after_single_post_loop
			 *
			 * @hooked - color_magazinex_related_posts_section - 10
			 *
			 * @since 1.0.0
			 */
			do_action( 'color_magazinex_after_single_post_loop' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- .mt-single-post-page-wrapper -->

<?php
get_footer();