<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*--------------------------------------------------------------------------------------------*/
	if ( ! function_exists( 'color_magazinex_posted_on' ) ) :

		/**
		 * Prints HTML with meta information for the current post-date/time.
		 */
		function color_magazinex_posted_on() {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);

			$posted_on = sprintf(
				'%s',
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);

			echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( !function_exists( 'color_magazinex_post_time' ) ) :

		/**
		 * Prints the time in hour and minute
		 */
		function color_magazinex_post_time() {

			$posted 	 = get_the_time( 'U' );
			$posted_time = human_time_diff( $posted, current_time( 'U' ) ). esc_html__( ' ago', 'color-magazinex' );

			echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html( $posted_time ) . '</a></span>';

		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_posted_by' ) ) :

		/**
		 * Prints HTML with meta information for the current author.
		 */
		function color_magazinex_posted_by() {

			echo '<span class="byline"><span class="author vcard"><a class="url fn n" href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'">'. esc_html( get_the_author() ) .'</a></span></span>'; // WPCS: XSS OK.

		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_posted_comments' ) ) :

		/**
		 * Show comment count and leave comment link if no comments are posted
		 */
		function color_magazinex_posted_comments() {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="comments-link">';
				comments_popup_link(
					sprintf(
						wp_kses(
							/* translators: %s: post title */
							__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'color-magazinex' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				echo '</span>';
			}
		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_entry_footer' ) ) :

		/**
		 * Prints HTML with meta information for the categories, tags and comments.
		 */
		function color_magazinex_entry_footer() {
			// Hide tag text for pages.
			if ( 'post' === get_post_type() ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'color-magazinex' ) );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'color-magazinex' ) . '</span>', $tags_list ); // WPCS: XSS OK.
				}
			}

			if ( 'post' === get_post_type() && ! is_single() ) {

				$color_magazinex_archive_read_more = get_theme_mod( 'color_magazinex_archive_read_more', __( 'Discover', 'color-magazinex' ) );
		?>
				<a href="<?php the_permalink(); ?>" class="mt-readmore-btn"><?php echo esc_html( $color_magazinex_archive_read_more ); ?> <i class="bx bx-right-arrow-alt"> </i></a>
		<?php
			}

			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'color-magazinex' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		}

	endif;

/*--------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazinex_widget_entry_footer' ) ) :

		/**
		 * Prints HTML with meta information for the categories, tags and comments.
		 */
		function color_magazinex_widget_entry_footer() {
			// Hide tag text for pages.
			if ( 'post' === get_post_type() ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'color-magazinex' ) );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'color-magazinex' ) . '</span>', $tags_list ); // WPCS: XSS OK.
				}
			}

			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'color-magazinex' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_post_thumbnail' ) ) :

		/**
		 * Displays an optional post thumbnail.
		 *
		 * Wraps the post thumbnail in an anchor element on index views, or a div
		 * element when on single views.
		 */
		function color_magazinex_post_thumbnail( $thumbnail_size = '' ) {

			global $wp_query;
			$current_post = $wp_query->current_post;

			$thumbnail_size  = !empty( $thumbnail_size ) ? $thumbnail_size : 'post-thumbnail';
			$archive_style   = get_theme_mod( 'color_magazinex_archive_style', 'mt-archive--masonry-style' );

			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}

			if ( is_singular() ) :
			?>

				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'color-magazinex-full-width' ); ?>
				</div><!-- .post-thumbnail -->

			<?php
			elseif ( is_archive() ) :
				// define image size in various section
				if ( 'mt-archive--masonry-style' === $archive_style ) {
					$thumbnail_size = 'color-magazinex-post-auto';
				} elseif ( 'mt-archive--block-grid-style' === $archive_style ) {
					$thumbnail_size = 'color-magazinex-full-width';
				}
			?>
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
						the_post_thumbnail( $thumbnail_size, array(
							'alt' => the_title_attribute( array(
								'echo' => false,
							) ),
						) );
					?>
				</a>
			<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail( $thumbnail_size, array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
				?>
			</a>

			<?php
			endif; // End is_singular().
		}

	endif;

/*--------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_article_categories_list' ) ) :

		/**
		 * Display the lists of categories at only articles
		 */
		function color_magazinex_article_categories_list() {
			global $post;
			$post_id = $post->ID;
			$categories_list = get_the_category( $post_id );
			if ( !empty( $categories_list ) ) {
		?>
				<div class="post-cats-list">
					<?php
						foreach ( $categories_list as $cat_data ) {
							$cat_name 	= $cat_data->name;
							$cat_id 	= $cat_data->term_id;
							$cat_link 	= get_category_link( $cat_id );
					?>
							<span class="category-button cb-cat-<?php echo esc_attr( $cat_id ); ?>"><a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a></span>
					<?php
						}
					?>
				</div><!-- .post-cats-list --><?php
			}
		}

	endif;

	/*
	 *
	 * Add cat id in menu class
	 */
	function color_magazinex_category_nav_class( $classes, $item ) {
	    if ( 'category' == $item->object ) {
	        $category 	= get_category( $item->object_id );
	        $classes[] 	= 'cb-cat-' . $category->term_id;
	    }
	    return $classes;
	}
	add_filter( 'nav_menu_css_class', 'color_magazinex_category_nav_class', 10, 2 );