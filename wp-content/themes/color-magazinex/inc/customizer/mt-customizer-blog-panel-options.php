<?php
/**
 * Color Magazine manage the Customizer options of design settings panel.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_design_panels_sections_register' );

/**
 * Add Additional panels in the theme customizer
 * 
 */
function color_magazinex_customize_design_panels_sections_register( $wp_customize ) {

/*--------------------------------------- Blog: Archive Pages --------------------------------------------------*/
	/**
	 * Archive Pages
	 */
	$wp_customize->add_section( 'color_magazinex_section_archive_settings',
		array(
			'title'				=> __( 'Archive Pages', 'color-magazinex' ),
			'panel'          	=> 'color_magazinex_blog_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 5,
		)
	);

	/**
	 * Radio Image field for arvhive/blog style.
	 */
	$wp_customize->add_setting( 'color_magazinex_archive_style',
		array(
			'default'           => 'mt-archive--masonry-style',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Radio_Image(
		$wp_customize, 'color_magazinex_archive_style',
			array(
				'label'    		=> __( 'Archive/Blog Style', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_archive_settings',
				'settings'      => 'color_magazinex_archive_style',
				'priority'      => 10,
				'choices'  		=> array(
					'mt-archive--block-grid-style' => get_template_directory_uri() . '/assets/images/archive-block-grid.png',
					'mt-archive--masonry-style'    => get_template_directory_uri() . '/assets/images/archive-masonry.png',
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

	/**
	 * Text field for archive read more button.
	 */
	$wp_customize->add_setting( 'color_magazinex_archive_read_more',
		array(
			'capability'        => 'edit_theme_options',
			'default'  			=> __( 'Discover', 'color-magazinex' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_archive_read_more', 
		array(
			'type'			=> 'text',
			'label'    		=> __( 'Read More Button', 'color-magazinex' ),
			'section'       => 'color_magazinex_section_archive_settings',
			'settings'		=> 'color_magazinex_archive_read_more',
			'priority'      => 15,
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazinex_archive_read_more',
        array(
            'selector'        => 'a.mt-readmore-btn',
            'render_callback' => 'color_magazinex_customize_partial_archive_read_more',
        )
    );

    /**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_archive_page',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_archive_page',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for extra features about archive pages.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_archive_settings',
				'settings'      => 'color_magazinex_upgrade_archive_page',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*--------------------------------------- Blog: Single Post Page -----------------------------------------------*/
	/**
	 * Single Post Page
	 */
	$wp_customize->add_section( 'color_magazinex_section_post_settings',
		array(
			'title'    			=> __( 'Single Post Page', 'color-magazinex' ),
			'panel'          	=> 'color_magazinex_blog_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 10,
		)
	);

	/**
	 * Toggle field Enable/Disable author box.
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_author_box',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_author_box',
			array(
				'label'         => __( 'Enable Author Box', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_post_settings',
				'settings'      => 'color_magazinex_enable_author_box',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable related posts.
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_related_posts',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_related_posts',
			array(
				'label'    		=> __( 'Enable Related Posts', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_post_settings',
				'settings'      => 'color_magazinex_enable_related_posts',
				'priority'      => 15,
			)
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_single_post',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_single_post',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for extra features about single post page.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_post_settings',
				'settings'      => 'color_magazinex_upgrade_single_post',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*--------------------------------------- Blog: 404 Page --------------------------------------------------------*/
	/**
	 * 404 Page
	 */
	$wp_customize->add_section( 'color_magazinex_section_pnf_settings',
		array(
			'priority'       => 20,
			'panel'          => 'color_magazinex_blog_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( '404 Page', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for Enable/Disable latest posts section at 404 page
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_pnf_latest_posts',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_pnf_latest_posts',
			array(
				'label'         => __( 'Enable Latest Posts', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_pnf_settings',
				'settings'      => 'color_magazinex_enable_pnf_latest_posts',
				'priority'      => 40,
			)
		)
	);

	/**
	 * Text field for latest posts section title
	 */
	$wp_customize->add_setting( 'color_magazinex_pnf_latest_title',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'You May Like', 'color-magazinex' ),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_pnf_latest_title',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Section Title', 'color-magazinex' ),
			'section'       	=> 'color_magazinex_section_pnf_settings',
			'settings'			=> 'color_magazinex_pnf_latest_title',
			'priority'      	=> 45,
			'active_callback' 	=> 'color_magazinex_enable_pnf_latest_posts_active_callback',
		)
	);

	/**
	 * Text field for latest posts count
	 */
	$wp_customize->add_setting( 'color_magazinex_pnf_latest_post_count',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> 3,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'color_magazinex_pnf_latest_post_count',
		array(
			'type'     			=> 'number',
			'label'    			=> __( 'Post count', 'color-magazinex' ),
			'section'  			=> 'color_magazinex_section_pnf_settings',
			'settings'			=> 'color_magazinex_pnf_latest_post_count',
			'priority' 			=> 50,
			'active_callback' 	=> 'color_magazinex_enable_pnf_latest_posts_active_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_pnf',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_pnf',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for extra features about 404 page.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_pnf_settings',
				'settings'      => 'color_magazinex_upgrade_pnf',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

}