<?php
/**
 * Partial template to display related posts.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$related_posts_option = get_theme_mod( 'color_magazinex_enable_related_posts', false );

//var_dump($related_posts_option);

if ( false === $related_posts_option ) {
	return;
}

/**
 * color_magazinex_before_related_posts hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_before_related_posts' );

global $post;
$related_post_id = get_the_id();
$get_categories  = get_the_terms( $related_post_id, 'category' );
$selected_cat 	 = array();

// Get only category slug of current post.
if ( $get_categories && is_array( $get_categories ) ) {
	foreach ( $get_categories as $category ) {
		$selected_cat[] = $category->term_id;
	}
}
$related_posts_count = apply_filters( 'color_magazinex_related_posts_count', 3 );
$related_posts_title = apply_filters( 'color_magazinex_related_posts_section_title', __( 'Related Posts', 'color-magazinex' ) );

$related_posts_args = array(
	'posts_per_page' => absint( $related_posts_count ),
	'post__not_in'   => array( $related_post_id ),
	'category__in'   => $selected_cat,
);

$related_posts_query = new WP_Query( $related_posts_args );
if ( $related_posts_query->have_posts() ) {
?>
	<section class="mt-single-related-posts">
		<h2 class="mt-related-post-title"><?php echo esc_html( $related_posts_title ); ?></h2>

		<div class="mt-related-posts-wrapper">
			<?php
				while ( $related_posts_query->have_posts() ) {
					$related_posts_query->the_post();

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
						?>
						<header class="entry-header">
						    <?php
						    	the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); 
						    ?>
						</header><!-- .entry-header -->
						<footer class="entry-footer">
							<?php color_magazinex_entry_footer(); ?>
						</footer><!-- .entry-footer -->
					</article><!-- #post-<?php the_ID(); ?> -->
			<?php
				}
			?>
		</div><!-- .mt-related-posts-wrapper -->

	</section><!-- .mt-single-related-posts -->
<?php
}

wp_reset_postdata();

/**
 * color_magazinex_after_related_posts hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_after_related_posts' );