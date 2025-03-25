<?php
/**
 * Customizer fields for  front slider section
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_slider_panels_sections_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazinex_customize_slider_panels_sections_register( $wp_customize ) {

/*------------------------------------- Frontpage: Block Posts Content ------------------------------------------------ */
	/**
	 * Block Posts Content
	 */
	$wp_customize->add_section( 'color_magazinex_section_block_posts',
		array(
			'priority'       => 5,
			'panel'          => 'color_magazinex_front_section_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Block Posts Content', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for block posts option
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_section_top_block_posts_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_section_top_block_posts_option',
			array(
				'label'         => __( 'Enable Block Posts Section', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_block_posts',
				'settings'      => 'color_magazinex_section_top_block_posts_option',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Select field for block posts select
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_section_top_block_posts',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> '',
			'sanitize_callback' => 'color_magazinex_sanitize_select',
		)
	);
	$wp_customize->add_control( 'color_magazinex_section_top_block_posts',
		array(
			'type'     			=> 'select',
			'label'    			=> __( 'Block Posts category', 'color-magazinex' ),
			'description' 		=> __( 'Choose default post category', 'color-magazinex' ),
			'section'  			=> 'color_magazinex_section_block_posts',
			'settings'			=> 'color_magazinex_section_top_block_posts',
			'priority' 			=> 10,
			'choices'  			=> color_magazinex_select_categories_list(),
			'active_callback' 	=> 'color_magazinex_has_enable_top_block_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_top_block_content',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_top_block_content',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for extra features about block posts content.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_block_posts',
				'settings'      => 'color_magazinex_upgrade_top_block_content',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*------------------------------------- Frontpage: Slider Content ------------------------------------------------ */

	/**
	 * Slider Content
	 */
	$wp_customize->add_section( 'color_magazinex_section_slider',
		array(
			'priority'       => 10,
			'panel'          => 'color_magazinex_front_section_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Slider Content', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for slider option
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_section_slider_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_section_slider_option',
			array(
				'label'         => __( 'Enable Slider Section', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_slider',
				'settings'      => 'color_magazinex_section_slider_option',
				'priority'      => 15,
			)
		)
	);

	/**
	 * Select field for slider cat select
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_section_slider_cat',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> '',
			'sanitize_callback' => 'color_magazinex_sanitize_select',
		)
	);
	$wp_customize->add_control( 'color_magazinex_section_slider_cat',
		array(
			'type'     			=> 'select',
			'label'    			=> __( 'Slider category', 'color-magazinex' ),
			'description' 		=> __( 'Choose default post category', 'color-magazinex' ),
			'section'  			=> 'color_magazinex_section_slider',
			'settings'			=> 'color_magazinex_section_slider_cat',
			'priority' 			=> 30,
			'choices'  			=> color_magazinex_select_categories_list(),
			'active_callback' 	=> 'color_magazinex_has_enable_slider_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_slider_content',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_slider_content',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for extra features about slider content.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_slider',
				'settings'      => 'color_magazinex_upgrade_slider_content',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*------------------------------------- Frontpage: Featured Posts Content ---------------------------------------- */
	/**
	 * Featured Posts
	 */
	$wp_customize->add_section( 'color_magazinex_section_top_featured_post',
		array(
			'priority'       	=> 20,
			'panel'          	=> 'color_magazinex_front_section_panel',
			'capability'     	=> 'edit_theme_options',
			'title'    			=> __( 'Featured Posts Content', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for featured posts option
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_section_top_featured_posts_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_section_top_featured_posts_option',
			array(
				'label'    		=> __( 'Enable Featured Posts Section', 'color-magazinex' ),
				'description' 	=> 'This section is displayed after the slider content at the right side minimizing the slider width.',
				'section'       => 'color_magazinex_section_top_featured_post',
				'settings'      => 'color_magazinex_section_top_featured_posts_option',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Text field for Featured Posts Title 
	 */
	$wp_customize->add_setting( 'color_magazinex_top_featured_posts_title',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'Featured News', 'color-magazinex' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_top_featured_posts_title',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Featured News', 'color-magazinex' ),
			'section'       	=> 'color_magazinex_section_top_featured_post',
			'settings'			=> 'color_magazinex_top_featured_posts_title',
			'priority'      	=> 10,
			'active_callback' 	=> 'color_magazinex_section_top_featured_posts_option_active_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazinex_top_featured_posts_title',
        array(
            'selector'        => 'div.features-post-title',
            'render_callback' => 'color_magazinex_customize_partial_featured_posts_title',
        )
    );

	/**
	 * Select field for featured posts type.
	 */
	$wp_customize->add_setting( 'color_magazinex_top_featured_post_order',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> 'default',
			'sanitize_callback' => 'color_magazinex_sanitize_select',
		)
	);
	$wp_customize->add_control( 'color_magazinex_top_featured_post_order',
		array(
			'type'     			=> 'select',
			'label'    			=> __( 'Featured Post Order', 'color-magazinex' ),
			'section'  			=> 'color_magazinex_section_top_featured_post',
			'settings'			=> 'color_magazinex_top_featured_post_order',
			'priority' 			=> 15,
			'choices'  			=> array(
				'default'   => __( 'Latest Posts', 'color-magazinex' ),
	            'random'    => __( 'Random Posts', 'color-magazinex' ),
			),
			'active_callback' 	=> 'color_magazinex_section_top_featured_posts_option_active_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_featured_posts_content',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_featured_posts_content',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for featured posts content advance settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_top_featured_post',
				'settings'      => 'color_magazinex_upgrade_featured_posts_content',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

}