<?php
/**
 * Color Magazine manage the Customizer panels
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_panels_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazinex_customize_panels_register( $wp_customize ) {
	/**
	 * General Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_general_panel',
		array(
			'priority'          => 5,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'General Settings', 'color-magazinex' ),
		)
	);

	/**
	 * Header Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_header_panel',
		array(
			'priority'          => 10,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Header Settings', 'color-magazinex' ),
		)
	);

	/**
	 * Front Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_front_section_panel',
		array(
			'priority'          => 15,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Frontpage Slider Sections', 'color-magazinex' ),
		)
	);

	/**
	 * Design Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_blog_panel',
		array(
			'priority'          => 20,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Blog Settings', 'color-magazinex' ),
		)
	);

	/**
	 * Typography Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_typography_panel',
		array(
			'priority'          => 25,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Typography Settings', 'color-magazinex' ),
		)
	);

	/**
	 * Footer Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazinex_footer_panel',
		array(
			'priority'          => 30,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Footer Settings', 'color-magazinex' ),
		)
	);
}