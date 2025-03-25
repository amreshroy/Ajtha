<?php
/**
 * Managed the custom functions and hooks for entire theme.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*------------------------------------- Preloader -----------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_preloader' ) ) :

	    /**
	     * preloader function
	     * 
	     * @since 1.0.0
	     */
	    function color_magazinex_preloader() {
	        $color_magazinex_enable_preloader = get_theme_mod( 'color_magazinex_enable_preloader', true );
	        if ( false === $color_magazinex_enable_preloader ) {
	            return;
	        }

	        $color_magazinex_preloader_style = get_theme_mod( 'color_magazinex_preloader_style', 'wave' );
	?>
	        <div id="preloader-background">
	            <div class="preloader-wrapper">
	            	<?php
	                    switch ( $color_magazinex_preloader_style ) {

	                        case 'three_bounce':
	                        ?>
	                            <div class="mt-three-bounce">
	                                <div class="mt-child mt-bounce1"></div>
	                                <div class="mt-child mt-bounce2"></div>
	                                <div class="mt-child mt-bounce3"></div>
	                            </div>
	                            <?php  
	                            break;

	                        case 'folding_cube':
	                        ?>
	                            <div class="mt-folding-cube">
	                                <div class="mt-cube1 mt-cube"></div>
	                                <div class="mt-cube2 mt-cube"></div>
	                                <div class="mt-cube4 mt-cube"></div>
	                                <div class="mt-cube3 mt-cube"></div>
	                            </div>
	                            <?php  
	                            break;
	                        
	                        default:
	                        ?>
	                            <div class="mt-wave">
	                                <div class="mt-rect mt-rect1"></div>
	                                <div class="mt-rect mt-rect2"></div>
	                                <div class="mt-rect mt-rect3"></div>
	                                <div class="mt-rect mt-rect4"></div>
	                                <div class="mt-rect mt-rect5"></div>
	                            </div>
	                            <?php
	                            break;
	                    }
	                ?>
	            </div><!-- .preloader-wrapper -->
	        </div><!-- #preloader-background -->
	<?php
	    }

	endif;

	add_action( 'color_magazinex_before_page', 'color_magazinex_preloader', 5 );

/*------------------------------------- Header Section ------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_top_header' ) ) :

		/**
	     * Function to display top header
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_top_header() {

	        get_template_part( 'template-parts/partials/header/top', 'header' );
	    }

	endif;

	if ( ! function_exists( 'color_magazinex_main_header' ) ) :

		/**
	     * Function to display main header
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_main_header() {

	        get_template_part( 'template-parts/partials/header/main', 'header' );
	    }

	endif;

	if ( ! function_exists ( 'color_magazinex_innerpage_page_title' ) ) :

		/**
		 *  Function to display innerpage page title
		 */
		function color_magazinex_innerpage_page_title() {
			//innerpage page title
			get_template_part( '/template-parts/partials/header/page', 'title' );
		}

	endif;

	/**
	 * manage the functions at color_magazinex_header_section hook
	 */
	add_action( 'color_magazinex_header_section', 'color_magazinex_top_header', 10 );
	add_action( 'color_magazinex_header_section', 'color_magazinex_main_header', 20 );
	add_action( 'color_magazinex_header_section', 'color_magazinex_innerpage_page_title', 40 );

	if ( ! function_exists( 'color_magazinex_breadcrumb_content' ) ) :
		
		/**
		 * function to manage the breadcrumbs content
		 */
		function color_magazinex_breadcrumb_content() {
			$color_magazinex_breadcrumb_option = get_theme_mod( 'color_magazinex_enable_breadcrumb_option', true );
			if ( false === $color_magazinex_breadcrumb_option ) {
				return;
			}
	?>
			<nav id="breadcrumb" class="mt-breadcrumb">
				<?php
				breadcrumb_trail( array(
					'container'   => 'div',
					'before'      => '<div class="mt-container">',
					'after'       => '</div>',
					'show_browse' => false,
				) );
				?>
			</nav>
	<?php
		}

	endif;

	add_action( 'color_magazinex_inside_page_title', 'color_magazinex_breadcrumb_content', 10 );

/*------------------------------------- Frontpage slider section----------------------------------*/

	if ( ! function_exists( 'color_magazinex_front_page_slider_section' ) ) :

		/**
		 * Function displaying front slider section
		 * 
		 */
		function color_magazinex_front_page_slider_section() {
			$color_magazinex_section_slider_option = get_theme_mod( 'color_magazinex_section_slider_option', false );
			if ( false == $color_magazinex_section_slider_option ) {
				return;
			}

			$color_magazinex_section_top_block_posts_option = get_theme_mod( 'color_magazinex_section_top_block_posts_option', false );
			$color_magazinex_section_top_featured_posts_option = get_theme_mod( 'color_magazinex_section_top_featured_posts_option', false );
			
			if ( true === $color_magazinex_section_top_featured_posts_option && true == $color_magazinex_section_top_block_posts_option ) {
				$slider_class = 'has-block-slider has-featured-slider default-width--slider';
			} elseif ( true === $color_magazinex_section_top_featured_posts_option ) {
				$slider_class = 'has-featured-slider default-width--slider';
			} elseif ( true === $color_magazinex_section_top_block_posts_option ) {
				$slider_class = 'has-block-slider default-width--slider';
			} else {
				$slider_class = 'no-featured-slider full-width--slider';
			}
	?>
			<div class="front-slider-wrapper <?php echo esc_attr( $slider_class ); ?>">
				<div class="mt-container">
										<div class="front-slider-block">
						<div class="front-slider cS-hidden">
						<?php
							$slider_cat_slug = get_theme_mod( 'color_magazinex_section_slider_cat', '' );
							$slide_post_count = apply_filters( 'color_magazinex_slider_post_count', 3 );
							$slider_args = array(
								'category_name'    	=> esc_attr( $slider_cat_slug ), 
								'meta_key'     		=> '_thumbnail_id',
								'posts_per_page' 	=> absint( $slide_post_count )
							);
							$slider_post_query = new WP_Query( $slider_args );
							if ( $slider_post_query->have_posts() ) :
								while ( $slider_post_query-> have_posts() ) : 
									$slider_post_query -> the_post();
									$slider_post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						?>
									<div class="slider-post-wrap">
										<figure class="post-thumbnail">
											<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $slider_post_thumbnail ); ?>" /></a>
										</figure>
										<div class="post-info-wrap">
											<div class="post-cat"><?php color_magazinex_article_categories_list(); ?></div>
											<?php
												// post meta
												get_template_part( 'template-parts/partials/post/meta' );

												the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
											?>
										</div><!--.post-info-wrap -->
									</div><!-- .slider-post-wrap -->
							<?php
								endwhile;
							endif;
						?>
						</div><!-- .front-slider -->
					</div> <!-- .front-slider-block -->
					
					<?php
						if ( true == $color_magazinex_section_top_block_posts_option ) {
					?>
							<div class="top-block-post-main-wrapper">
								<?php
									$block_posts_per_page = apply_filters( 'color_magazinex_block_post_count', 3 );
									$top_block_post_args = array(
										'posts_per_page' 	=> absint( $block_posts_per_page ),
									);
									$top_block_post_query = new WP_Query( $top_block_post_args );
									if ( $top_block_post_query->have_posts() ) {
										while ( $top_block_post_query->have_posts() ) {
											$top_block_post_query->the_post();
											$block_post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'color-magazinex-post' );
								?>
										<div  id="post-<?php the_ID(); ?>" class="mt-single-post-wrap mt-clearfix">
											<figure class="post-thumbnail">
										    	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $block_post_thumbnail ); ?>" /></a>
											</figure>
											<div class="mt-post-content">
												<?php
													// post meta
													get_template_part( 'template-parts/partials/post/meta' );
												?>
												<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
											</div>
										</div><!-- #post-<?php the_ID(); ?> -->
								<?php
										}
									}
								?>
							</div><!-- .top-block-post-main-wrapper -->
					<?php
						}
					?>

			<?php
					if ( true == $color_magazinex_section_top_featured_posts_option ) {
						$color_magazinex_top_featured_posts_title = get_theme_mod( 'color_magazinex_top_featured_posts_title', __( 'Featured News', 'color-magazinex' ) );
						echo '<div class="top-featured-post-main-wrapper">';
							if ( ! empty( $color_magazinex_top_featured_posts_title ) ) {
								echo '<div class="features-post-title">'.esc_html( $color_magazinex_top_featured_posts_title ).'</div><!-- .features-post-title -->';
							}
								
							$color_magazinex_top_featured_post_order = get_theme_mod( 'color_magazinex_top_featured_post_order', 'default' );
							$featured_posts_per_page = apply_filters( 'color_magazinex_featured_post_count', 5 );
							$top_featured_post_args = array( 
								'post_type' 		=> 'post',
								'posts_per_page' 	=> absint( $featured_posts_per_page ),
							);
							if ( 'random' == $color_magazinex_top_featured_post_order ) {
								$top_featured_post_args['orderby'] = 'rand';
							}
							$top_featured_post_query = new WP_Query( $top_featured_post_args );
							if ( $top_featured_post_query -> have_posts() ) :
								echo '<div class="top-featured-post-wrap">';
									$featured_post_count = 1;
									while ( $top_featured_post_query -> have_posts() ) :
										$top_featured_post_query -> the_post();
										$featured_post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
						?>
										<div  id="post-<?php the_ID(); ?>" class="mt-single-post-wrap mt-clearfix">
											<div class="post-thumbnail">
												<span class="post-number"><?php echo absint( $featured_post_count ); ?></span>	
											    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $featured_post_thumbnail ); ?>" /></a>
											</div>
											<div class="mt-post-content">
												<?php
													// post meta
													get_template_part( 'template-parts/partials/post/meta' );
												?>
												<header class="entry-header">
													<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
												</header><!-- .entry-header -->
											</div>
										</div><!-- #post-<?php the_ID(); ?> -->
						<?php
									$featured_post_count ++;
								endwhile;
							echo '</div><!-- .top-featured-post-wrap -->';
							endif;
						echo '</div><!-- .top-featured-post-main-wrapper -->';
					}
				?>
				</div>
			</div><!-- .front-slider-wrapper -->
	<?php
		}

	endif;

	/**
	 * manage the function at color_magazinex_after_header hook
	 */
	add_action( 'color_magazinex_after_header', 'color_magazinex_front_page_slider_section', 10 );

/*------------------------------------- Single Post ---------------------------------------------*/

	if ( ! function_exists ( 'color_magazinex_related_posts_section' ) ) :

		/**
		 * function to manage related posts in single post page
		 */
		function color_magazinex_related_posts_section() {
			// related posts
			get_template_part( 'template-parts/partials/post/related', 'posts' );
		}

	endif;

	add_action( 'color_magazinex_after_single_post_loop', 'color_magazinex_related_posts_section', 10 );

/*------------------------------------- Footer Section ------------------------------------------*/
	
	if ( ! function_exists( 'color_magazinex_footer_start' ) ) :

		/**
		 * function to start footer wrapper
		 */
		function color_magazinex_footer_start() {
			echo '<footer id="colophon" class="site-footer">';
		}

	endif;

	if ( ! function_exists( 'color_magazinex_footer_sidebar' ) ) :

		/**
		 * function to display footer widget area
		 */
		function color_magazinex_footer_sidebar() {
			$color_magazinex_footer_widget_option = get_theme_mod( 'color_magazinex_enable_footer_widget_area', true );
			if ( true === $color_magazinex_footer_widget_option ) {
				get_sidebar( 'footer' );
			}
		}

	endif;

	if ( ! function_exists( 'color_magazinex_bottom_footer' ) ) :

		/**
		 * function to display bottom footer section
		 */
		function color_magazinex_bottom_footer() {
	?>
			<div id="bottom-footer">
	            <div class="mt-container">
	        		<?php
	        			$color_magazinex_enable_footer_menu = get_theme_mod( 'color_magazinex_enable_footer_menu', true );
	        			if ( true === $color_magazinex_enable_footer_menu ) {
	        		?>
	        				<nav id="footer-navigation" class="footer-navigation">
	    						<?php
	    							wp_nav_menu( array(
	    								'theme_location' => 'footer_menu',
	    								'menu_id'        => 'footer-menu',
	    								'fallback_cb' 	 => false,
	    								'depth'			 => 1
	    							) );
	    						?>
	        				</nav><!-- #footer-navigation -->
	        		<?php
	        			}
	        		?>

	        		<div class="site-info">
	        			<span class="mt-copyright-text">
	        				<?php 
	        					$color_magazinex_footer_copyright = get_theme_mod( 'color_magazinex_footer_copyright', __( 'Color Magazine', 'color-magazinex' ) );
	        					echo esc_html( $color_magazinex_footer_copyright );
	        				?>
	        			</span>
	        			<span class="sep"> | </span>
	        				<?php
		        				/* translators: 1: Theme name, 2: Theme author. */
		        				printf( esc_html__( 'Theme: %1$s by %2$s.', 'color-magazinex' ), 'Color Magazine', '<a href="https://mysterythemes.com">Mystery Themes</a>' );
	        				?>
	        		</div><!-- .site-info -->
	            </div><!-- .mt-container -->
	        </div><!-- #bottom-footer -->
	<?php
		}

	endif;

	if ( ! function_exists( 'color_magazinex_footer_end' ) ) :

		/**
		 * function to end footer wrapper
		 */
		function color_magazinex_footer_end() {
			echo '</footer><!-- #colophon -->';
		}

	endif;

	if ( ! function_exists( 'color_magazinex_scroll_top' ) ) :

		/**
	     * Function to display main header
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_scroll_top() {
	    	// scroll top
        	get_template_part( 'template-parts/partials/scroll', 'top' );
	    }

	endif;

	/**
	 * manage the function at color_magazinex_footer hook
	 */
	add_action( 'color_magazinex_footer', 'color_magazinex_footer_start', 5 );
	add_action( 'color_magazinex_footer', 'color_magazinex_footer_sidebar', 10 );
	add_action( 'color_magazinex_footer', 'color_magazinex_bottom_footer', 15 );
	add_action( 'color_magazinex_footer', 'color_magazinex_footer_end', 20 );
	add_action( 'color_magazinex_footer', 'color_magazinex_scroll_top', 30 );