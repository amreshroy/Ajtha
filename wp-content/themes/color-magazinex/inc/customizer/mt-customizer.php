<?php
/**
 * Color Magazine Theme Customizer
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function color_magazinex_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_section( 'title_tagline' )->panel        = 'color_magazinex_general_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '5';

    $wp_customize->get_section( 'header_image' )->panel        = 'color_magazinex_header_panel';
    $wp_customize->get_section( 'header_image' )->priority     = '5';

    $wp_customize->get_section( 'colors' )->panel        = 'color_magazinex_general_panel';
    $wp_customize->get_section( 'colors' )->priority     = '55';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'color_magazinex_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'color_magazinex_customize_partial_blogdescription',
		) );
	}

	/**
	 * Load customizer custom classes.
	 */
	$wp_customize->register_control_type( 'Color_Magazinex_Control_Toggle' );
    $wp_customize->register_control_type( 'Color_Magazinex_Control_Range' );
	$wp_customize->register_control_type( 'Color_Magazinex_Control_Radio_Image' );
    $wp_customize->register_control_type( 'Color_Magazinex_Control_Typography' );
    $wp_customize->register_control_type( 'Color_Magazinex_Control_Upgrade' );

    /**
     * Register custom section types.
     *
     * @since 1.0.0
     */
    $wp_customize->register_section_type( 'color_magazinex_Section_Upsell' );

    /**
     * Register theme upsell sections.
     *
     * @since 1.0.0
     */
    $wp_customize->add_section( new Color_Magazinex_Section_Upsell(
        $wp_customize,
            'theme_upsell',
            array(
                'title'     => __( 'Color Magazine Pro', 'color-magazinex' ),
                'pro_text'  => __( 'Buy Now', 'color-magazinex' ),
                'pro_url'   => 'https://mysterythemes.com/wp-themes/color-magazine-pro/',
                'priority'  => 1,
            )
        )
    );

}
add_action( 'customize_register', 'color_magazinex_customize_register' );

/*------------------------------------- selective refresh --------------------------------------------------------*/

    /**
     * Render the site title for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_blogname() {
    	bloginfo( 'name' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_blogdescription() {
    	bloginfo( 'description' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_ticker_label() {
        return get_theme_mod( 'color_magazinex_ticker_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_trending_label() {
        return get_theme_mod( 'color_magazinex_trending_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_scroll_top_label() {
        return get_theme_mod( 'color_magazinex_scroll_top_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_featured_posts_title() {
        return get_theme_mod( 'color_magazinex_top_featured_posts_title' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazinex_customize_partial_archive_read_more() {
        return get_theme_mod( 'color_magazinex_archive_read_more' );
    }

/*------------------------------------- enqueue customizer scripts ------------------------------------------------*/
    
    if ( ! function_exists( 'color_magazinex_customize_backend_scripts' ) ) :

        /**
         * Enqueue required scripts/styles for customizer panel
         *
         * @since 1.0.0
         */
        function color_magazinex_customize_backend_scripts() {
            global $color_magazinex_theme_version;

            wp_enqueue_style( 'color-magazinex--admin-customizer-style', get_template_directory_uri() . '/assets/css/min/mt-customizer-styles.min.css', array(), esc_attr( esc_attr( $color_magazinex_theme_version ) ) );
            wp_enqueue_style( 'jquery-ui', esc_url( get_template_directory_uri() . '/assets/css/jquery-ui.css' ) );
            wp_enqueue_style( 'box-icons', get_template_directory_uri() . '/assets/library/box-icons/css/boxicons.min.css', array(), '2.1.4' );
            wp_enqueue_script( 'ajax_script_function', get_template_directory_uri(). '/assets/js/typo-ajax.js', array('jquery'), '1.0.0', true );
            wp_localize_script( 'ajax_script_function', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
            wp_enqueue_script( 'color-magazinex--admin-customizer-script', get_template_directory_uri() . '/assets/js/min/mt-customizer-controls.min.js', array( 'jquery', 'customize-controls' ), esc_attr( $color_magazinex_theme_version ), true );
        }

    endif;

    add_action( 'customize_controls_enqueue_scripts', 'color_magazinex_customize_backend_scripts', 10 );

    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    function color_magazinex_customize_preview_js() {
        wp_enqueue_script( 'color-magazinex-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
    }
    add_action( 'customize_preview_init', 'color_magazinex_customize_preview_js' );

/**
 * Add Kirki required file for custom fields
 */
require get_template_directory() . '/inc/customizer/mt-customizer-custom-classes.php';
require get_template_directory() . '/inc/customizer/mt-customizer-panels.php';
require get_template_directory() . '/inc/customizer/mt-sanitize.php';
require get_template_directory() . '/inc/customizer/mt-callback.php';

require get_template_directory() . '/inc/customizer/mt-customizer-general-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-header-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-front-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-blog-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-typography-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-footer-panel-options.php';