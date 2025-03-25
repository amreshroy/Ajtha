<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
			if ( have_posts() ) :

				/**
				 * hook - color_magazinex_before_search_posts_loop
				 * 
				 * @since 1.0.0
				 */
				do_action( 'color_magazinex_before_search_posts_loop' );

				echo '<div class="mt-archive-article-wrapper">';

				/* Start the Loop */
				while ( have_posts() ) :

					the_post();
					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				echo '</div><!-- .mt-archive-article-wrapper -->';

				/**
				 * hook - color_magazinex_after_search_posts_loop
				 * 
				 * @since 1.0.0
				 */
				do_action( 'color_magazinex_after_search_posts_loop' );

				the_posts_pagination();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- .mt-page-content-wrapper -->

<?php
get_footer();