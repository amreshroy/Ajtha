<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*----------------------------------------- Custom body classes ----------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazinex_body_classes' ) ) :

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		function color_magazinex_body_classes( $classes ) {
			global $post;

			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			// Adds a class of no-sidebar when there is no sidebar present.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'no-sidebar';
			}

			$color_magazinex_site_layout = get_theme_mod( 'color_magazinex_site_layout', 'site-layout--wide' );
			$classes[] = esc_attr( $color_magazinex_site_layout );

			/**
			 * Add classes about style and sidebar layout for archive, post and page
			 */
			if ( is_archive() || is_home() || is_search()) {
				$archive_sidebar_layout = get_theme_mod( 'color_magazinex_archive_sidebar_layout', 'no-sidebar' );
				$archive_style          = get_theme_mod( 'color_magazinex_archive_style', 'mt-archive--masonry-style' );
				$classes[] = esc_attr( $archive_sidebar_layout );
				$classes[] = esc_attr( $archive_style );
			} elseif ( is_single() ) {
				$single_post_sidebar_layout = get_post_meta( $post->ID, 'color_magazinex_post_sidebar_layout', true );
				if ( 'layout--default-sidebar' !== $single_post_sidebar_layout && !empty( $single_post_sidebar_layout ) ) {
					$classes[] = esc_attr( $single_post_sidebar_layout );
				} else {
					$posts_sidebar_layout = get_theme_mod( 'color_magazinex_posts_sidebar_layout', 'right-sidebar' );
					$classes[] = esc_attr( $posts_sidebar_layout );
				}
			} elseif ( is_page() ) {
				$single_page_sidebar_layout = get_post_meta( $post->ID, 'color_magazinex_post_sidebar_layout', true );
				if ( 'layout--default-sidebar' !== $single_page_sidebar_layout && !empty( $single_page_sidebar_layout ) ) {
					$classes[] = esc_attr( $single_page_sidebar_layout );
				} else {
					$pages_sidebar_layout = get_theme_mod( 'color_magazinex_pages_sidebar_layout', 'right-sidebar' );
					$classes[] = esc_attr( $pages_sidebar_layout );
				}
			}

			/**
			 * site mode toggle
			 */ 
			$color_magazinex_enable_dark_mode = get_theme_mod( 'color_magazinex_enable_dark_mode', false );
			if ( false !== $color_magazinex_enable_dark_mode ) {
				$classes[] = 'mt-site-dark-mode';
			}

			return $classes;
		}

	endif;

	add_filter( 'body_class', 'color_magazinex_body_classes' );

/*----------------------------------------- Header ping back -------------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazinex_pingback_header' ) ) :

		/**
		 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
		 */
		function color_magazinex_pingback_header() {

			if ( is_singular() && pings_open() ) {
				echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
			}

		}

	endif;

	add_action( 'wp_head', 'color_magazinex_pingback_header' );

/*----------------------------------------- Theme font -------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_fonts_url' ) ) :

		/**
		 * Register Google fonts for Color Magazine.
		 *
		 * @return string Google fonts URL for the theme.
		 * @since 1.0.0
		 */
	    function color_magazinex_fonts_url() {
	        $fonts_url = '';
	        $font_families = array();

	        /*
	         * Translators: If there are characters in your language that are not supported
	         * by PT Serif, translate this to 'off'. Do not translate into your own language.
	         */
	        if ( 'off' !== _x( 'on', 'PT Serif font: on or off', 'color-magazinex' ) ) {
	            $font_families[] = 'PT Serif:400,700';
	        }

	        /*
	         * Translators: If there are characters in your language that are not supported
	         * by Work Sans, translate this to 'off'. Do not translate into your own language.
	         */
	        if ( 'off' !== _x( 'on', 'Work Sans font: on or off', 'color-magazinex' ) ) {
	            $font_families[] = 'Work Sans:300,400,400i,500,700';
	        }   

	        if ( $font_families ) {
	            $query_args = array(
	                'family' => urlencode( implode( '|', $font_families ) ),
	                'subset' => urlencode( 'latin,latin-ext' ),
	            );
	            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	        }
	        return $fonts_url;
	    }

	endif;

/*----------------------------------------- Enqueue scripts --------------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazinex_admin_scripts' ) ) :

		/**
		 * Enqueue scripts and styles for only admin
		 *
		 * @since 1.0.0
		 */
		function color_magazinex_admin_scripts( $hook ) {
		    global $color_magazinex_theme_version;

		    if ( 'widgets.php' != $hook && 'customize.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
		        return;
		    }
		    wp_enqueue_script( 'jquery-ui-button' );
		    wp_enqueue_script( 'color-magazinex--admin-script', get_template_directory_uri() .'/assets/js/mt-admin-scripts.js', array( 'jquery' ), esc_attr( $color_magazinex_theme_version ), true );
		    wp_enqueue_style( 'color-magazinex--admin-style', get_template_directory_uri() . '/assets/css/mt-admin-styles.css', array(), esc_attr( $color_magazinex_theme_version ) );
		}

	endif;

	add_action( 'admin_enqueue_scripts', 'color_magazinex_admin_scripts' );

	if ( ! function_exists( 'color_magazinex_scripts' ) ) :

		/**
		 * Enqueue scripts and styles.
		 */
		function color_magazinex_scripts() {

			global $color_magazinex_theme_version;

			wp_enqueue_style( 'color-magazinex-google-fonts', color_magazinex_google_font_callback(), array(), null );

			wp_enqueue_style( 'color-magazinex-fonts', color_magazinex_fonts_url(), array(), null );

			wp_enqueue_style( 'box-icons', get_template_directory_uri() . '/assets/library/box-icons/css/boxicons.min.css', array(), '2.1.4' );

			wp_enqueue_style( 'lightslider-style', get_template_directory_uri() .'/assets/library/lightslider/css/lightslider.min.css', array(), '' );

			wp_enqueue_style( 'preloader', get_template_directory_uri() .'/assets/css/min/mt-preloader.min.css', array(), esc_attr( $color_magazinex_theme_version ) );

			wp_enqueue_style( 'color-magazinex-style', get_stylesheet_uri(), array(), esc_attr( $color_magazinex_theme_version) );

			wp_enqueue_style( 'color-magazinex-responsive-style', get_template_directory_uri(). '/assets/css/min/mt-responsive.min.css', array(), esc_attr( $color_magazinex_theme_version ) );

			$color_magazinex_dark_mod_option = get_theme_mod( 'color_magazinex_enable_dark_mode', false );
			if ( true === $color_magazinex_dark_mod_option ) {
				wp_enqueue_style( 'color-magazinex-dark-mod', get_template_directory_uri() . '/assets/css/min/mt-dark-styles.min.css', array(), esc_attr( $color_magazinex_theme_version ) );
			}

			wp_enqueue_script( 'color-magazinex-combine-scripts', get_template_directory_uri() .'/assets/js/mt-combine-scripts.js', array('jquery'), esc_attr( $color_magazinex_theme_version ), true );

			wp_enqueue_script( 'color-magazinex-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), esc_attr( $color_magazinex_theme_version ), true );

			wp_enqueue_script( 'color-magazinex-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), esc_attr( $color_magazinex_theme_version ), true );

			wp_enqueue_script( 'color-magazinex-custom-scripts', get_template_directory_uri() .'/assets/js/min/mt-custom-scripts.min.js', array('jquery'), esc_attr( $color_magazinex_theme_version ), true );

			$color_magazinex_enable_sticky_menu = get_theme_mod( 'color_magazinex_enable_sticky_menu', true );
			if ( true === $color_magazinex_enable_sticky_menu ) {
				$sticky_value = 'on';
			} else {
				$sticky_value = 'off';
			}

			wp_localize_script( 'color-magazinex-custom-scripts', 'color_magazineObject', array(
		        'menu_sticky' => $sticky_value,
		    ) );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

	endif;

	add_action( 'wp_enqueue_scripts', 'color_magazinex_scripts' );

/*----------------------------------------- Social icon content ----------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_social_icons_array' ) ) :

	    /**
	     * List of box icons
	     *
	     * @return array();
	     * @since 1.0.0
	     */
	    function color_magazinex_social_icons_array() {
	        return array(
	            "bx bxl-facebook", "bx bxl-twitter", "bx bxl-google", "bx bxl-instagram", "bx bxl-skype", "bx bxl-whatsapp", "bx bxl-tiktok", "bx bxl-linkedin", "bx bxl-pinterest", "bx bxl-tumblr", "bx bxl-slack", "bx bxl-reddit", "bx bxl-messenger", "bx bxl-wordpress", "bx bxl-yahoo", "bx bxl-snapchat", "bx bxl-wix", "bx bxl-meta", "bx bxl-vk", "bx bxl-trip-advisor",
	        );
	    }

	endif;

	if ( ! function_exists( 'color_magazinex_social_media_content' ) ) :

		/**
		 * function to display the social icons
		 */
		function color_magazinex_social_media_content() {
			$defaults_icons = json_encode( array(
					array(
						'social_icon' => 'bx bxl-twitter',
						'social_url'  => '#',
					),
					array(
						'social_icon' => 'bx bxl-pinterest',
						'social_url'  => '#',
					)
				)
			);
			$color_magazinex_social_icons = get_theme_mod( 'color_magazinex_social_icons', $defaults_icons );
			$social_icons = json_decode( $color_magazinex_social_icons );

			if ( ! empty( $social_icons ) ) {
	?>
				<ul class="mt-social-icon-wrap">
					<?php
						foreach ( $social_icons as $social_icon ) {
							if ( ! empty( $social_icon->social_url ) ) {
					?>
								<li class="mt-social-icon">
									<a href="<?php echo esc_url( $social_icon->social_url ); ?>" target="_blank">
										<i class="<?php echo esc_attr( $social_icon->social_icon ); ?>"></i>
									</a>
								</li>
					<?php
							}
						}
					?>
				</ul>
	<?php 
			}
		}

	endif;

/*----------------------------------------- Categories content -----------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_select_categories_list' ) ) :

		/**
		 * function to return category lists
		 *
		 * @return $color_magazinex_categories_list in array
		 */
		function color_magazinex_select_categories_list() {
			$color_magazinex_get_categories = get_categories( array( 'hide_empty' => 0 ) );
			$color_magazinex_categories_list[''] = __( 'Select Category', 'color-magazinex' );
	        foreach ( $color_magazinex_get_categories as $category ) {
	    	    $color_magazinex_categories_list[esc_attr( $category->slug )] = esc_html( $category->cat_name );
	        }
	        return $color_magazinex_categories_list;
		}

	endif;

/*----------------------------------------- Header content ---------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_header_bg_image' ) ) :

	    /**
	     * Background image for page header
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_header_bg_image( $input ) {

	        $image_attr = array();

	        if ( empty( $image_attr ) ) {

	            // Fetch from Custom Header Image.
	            $image = get_header_image();
	            if ( ! empty( $image ) ) {
	                $image_attr['url']    = $image;
	                $image_attr['width']  = get_custom_header()->width;
	                $image_attr['height'] = get_custom_header()->height;
	            }
	        }

	        if ( ! empty( $image_attr ) ) {
	            $input .= 'background-image:url(' . esc_url( $image_attr['url'] ) . ');';
	            $input .= 'background-size:cover; background-position:center center;';
	        }

	      return $input;
	    }

	endif;

	add_filter( 'color_blog_header_bg_style_attribute', 'color_magazinex_header_bg_image' );

	if ( ! function_exists( 'color_magazinex_post_id' ) ) {

		/**
		 * Store current post ID
		 *
		 * @since 1.0.0
		 */
		function color_magazinex_post_id() {

			wp_reset_postdata();

			// Default value.
			$id = '';

			if ( is_singular() ) {
				$id = get_the_ID();
			} elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
				$id = $page_for_posts;
			}

			// Sanitize.
			$id = $id ? $id : '';

			// Return ID.
			return $id;

		}
	}

	if ( ! function_exists( 'color_magazinex_get_the_title' ) ) {

	    /**
	     * function to return page title
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_get_the_title() {

	    	// Default title is null
			$title = null;

	        $post_id = color_magazinex_post_id();

	        if ( is_front_page() && ! is_singular( 'page' ) ) {
	            $title = get_bloginfo( 'description' );
	        } elseif ( is_home() && ! is_singular( 'page' ) ) {
	            $page_for_posts_id = get_option( 'page_for_posts', true );
	            $title = get_the_title( $page_for_posts_id );
	        } elseif ( is_archive() ) {
	        	$title = get_the_archive_title();
	        } else {
	            $title = get_the_title();
	        }

	        $get_the_title = $title ? $title : get_the_title();

	        return $get_the_title;

	    }

	}

/*----------------------------------------- Custom css content -----------------------------------------------------*/

	

	if ( ! function_exists( 'color_magazinex_minify_css' ) ) {

	    /**
	     * Minify CSS
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_minify_css( $css = '' ) {

	        // Return if no CSS
	        if ( ! $css ) return;

	        // Normalize whitespace
	        $css = preg_replace( '/\s+/', ' ', $css );

	        // Remove ; before }
	        $css = preg_replace( '/;(?=\s*})/', '', $css );

	        // Remove space after , : ; { } */ >
	        $css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	        // Remove space before , ; { }
	        $css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

	        // Strips leading 0 on decimal values (converts 0.5px into .5px)
	        $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	        // Strips units if value is 0 (converts 0px to 0)
	        $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	        // Trim
	        $css = trim( $css );

	        // Return minified CSS
	        return $css;
	        
	    }

	}

	if ( ! function_exists( 'color_magazinex_hover_color' ) ) :

	    /**
	     * Generate darker color
	     * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
	     *
	     * @since 1.0.0
	     */
	    function color_magazinex_hover_color( $hex, $steps ) {
	        // Steps should be between -255 and 255. Negative = darker, positive = lighter
	        $steps = max( -255, min( 255, $steps ) );

	        // Normalize into a six character long hex string
	        $hex = str_replace( '#', '', $hex );
	        if ( strlen( $hex ) == 3) {
	            $hex = str_repeat( substr( $hex,0,1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex,2,1 ), 2 );
	        }

	        // Split into three parts: R, G and B
	        $color_parts = str_split( $hex, 2 );
	        $return = '#';

	        foreach ( $color_parts as $color ) {
	            $color   = hexdec( $color ); // Convert to decimal
	            $color   = max( 0, min( 255, $color + $steps ) ); // Adjust color
	            $return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	        }
	        return $return;
	    }

	endif;

/*----------------------------------------- Typography option ------------------------------------------------------*/

	if ( ! function_exists( 'color_magazinex_google_font_callback' ) ) :

		/**
		 * Load google fonts api link
		 *
		 * @since 1.0.0
		 */
		function color_magazinex_google_font_callback() {

			$body_font_family   	= get_theme_mod( 'body_font_family', 'Work Sans' );
			$variants_array 		= get_google_font_variants_value( $body_font_family );
			$body_font_weight   	= implode( ',', $variants_array );
			$body_typo_combo		= $body_font_family.":".$body_font_weight;

			$header_font_family 	= get_theme_mod( 'header_font_family', 'Work Sans' );
			$variants_array 		= get_google_font_variants_value( $header_font_family );
			$header_font_weight   	= implode( ',', $variants_array );
			$header_typo_combo		= $header_font_family.":".$header_font_weight;

			$get_fonts          	= array( $body_typo_combo, $header_typo_combo );
			$final_font_string 		= implode( '|', $get_fonts );

			$google_fonts_url = '';

			if ( $final_font_string ) {
				$query_args = array(
					'family' => urlencode( $final_font_string ),
					'subset' => urlencode( 'latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic,khmer,devanagari,arabic,hebrew,telugu' )
				);

				$google_fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}

			return $google_fonts_url;
		}

	endif;

	if ( ! function_exists( 'get_google_font_variants' ) ) :

		/**
		 * get Google font variants
		 *
		 * @since 1.0.0
		 */

		function get_google_font_variants() {
		    $color_magazinex_font_list = get_option( 'color_magazinex_google_font', '' );
		    
		    $font_family = $_REQUEST['font_family'];
		    
		    $font_array = color_magazinex_search_key( $color_magazinex_font_list, 'family', $font_family );
		    
		    $variants_array = $font_array['0']['variants'] ;
		    $options_array = array();
		    foreach ( $variants_array  as $key=>$variants ) {
		        $options_array .= '<option value="'.$key.'">'.$variants.'</option>';
		    }
		    echo $options_array;
		    die();
		}

	endif;

	add_action( 'wp_ajax_get_google_font_variants', 'get_google_font_variants' );

	if ( ! function_exists( 'get_google_font_variants_value' ) ) :

		/**
		 * get google font variants value
		 * 
		 * @since 1.0.0
		 */
		function get_google_font_variants_value( $font_family ) {

			$color_magazinex_get_font_list 	= get_option( 'color_magazinex_google_font' );
			$font_array 		= color_magazinex_search_key( $color_magazinex_get_font_list, 'family', $font_family );
			$variants_array 	= $font_array['0']['variants'] ;

			$get_variants = array();

			foreach( $variants_array as $key => $value ) {
				$get_variants[] = $key;
			}

			return $get_variants;

		}

	endif;

	if ( ! function_exists( 'color_magazinex_search_key' ) ) :

		function color_magazinex_search_key( $array, $key, $value ) {
		    $results = array();

		    if ( is_array( $array ) ) {
		        if ( isset($array[$key]) && $array[$key] == $value ) {
		            $results[] = $array;
		        }

		        foreach ( $array as $subarray ) {
		            $results = array_merge( $results, color_magazinex_search_key( $subarray, $key, $value ) );
		        }
		    }

		    return $results;
		}

	endif;

	if ( ! function_exists( 'color_magazinex_convert_font_variants' ) ) :

		function color_magazinex_convert_font_variants( $value ) {

		    switch ( $value ) {
		        case '100':
		            return 'Thin';
		            break;

		        case '200':
		            return 'Extra Light';
		            break;

		        case '300':
		            return 'Light';
		            break;

		        case 'regular':
		            return 'Normal';
		            break;

		        case '500':
		            return 'Medium';
		            break;

		        case '600':
		            return 'Semi Bold';
		            break;

		        case '700':
		            return 'Bold';
		            break;

		        case '800':
		            return 'Extra Bold';
		            break;

		        case '900':
		            return 'Ultra Bold';
		            break;

		        case '100italic':
		            return 'Thin Italic';
		            break;

		        case '200italic':
		            return 'Extra Light Italic';
		            break;

		        case '300italic':
		            return 'Light Italic';
		            break;

		        case 'italic':
		            return 'Normal Italic';
		            break;

		        case '500italic':
		            return 'Medium Italic';
		            break;

		        case '600italic':
		            return 'Semi Bold Italic';
		            break;

		        case '700italic':
		            return 'Bold Italic';
		            break;

		        case '800italic':
		            return 'Extra Bold Italic';
		            break;

		        case '900italic':
		            return 'Ultra Bold Italic';
		            break;
		        
		        default:
		            break;
		    }
		}

	endif;