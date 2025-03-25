<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

?>
<div class="mt-page-content-wrapper">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php

			/**
			 * hook - color_magazinex_before_page_loop
			 *
			 * @since 1.0.0
			 */
			do_action( 'color_magazinex_before_page_loop' );

			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.

			/**
			 * hook - color_magazinex_after_page_loop
			 *
			 * @since 1.0.0
			 */
			do_action( 'color_magazinex_after_page_loop' );
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

</div><!-- .mt-page-content-wrapper -->

<?php
get_footer();