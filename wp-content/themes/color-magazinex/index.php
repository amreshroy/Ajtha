<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
			if ( have_posts() ) :

				/**
				 * hook - color_magazinex_before_front_posts_loop
				 *
				 * @since 1.0.0
				 */
				do_action( 'color_magazinex_before_front_posts_loop' );

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
				 * hook - color_magazinex_after_front_posts_loop
				 *
				 * @since 1.0.0
				 */
				do_action( 'color_magazinex_after_front_posts_loop' );

				the_posts_pagination();
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif;
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- .mt-page-content-wrapper -->
<?php
get_footer();