<?php
/**
 * Color Magazine manage the Customizer options of header panel.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_header_panels_sections_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazinex_customize_header_panels_sections_register( $wp_customize ) {

/*---------------------------------------- Header: Top Header ----------------------------------------*/
	/**
	 * Top Header
	 */
	$wp_customize->add_section( 'color_magazinex_section_top_header',
		array(
			'priority'       => 5,
			'panel'          => 'color_magazinex_header_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Top Header', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for Enable/Disable top header section
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_top_header',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_top_header',
			array(
				'label'         => __( 'Enable Top Header', 'color-magazinex' ),
				'description' 	=> __( 'Show/Hide top header section.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_top_header',
				'settings'      => 'color_magazinex_enable_top_header',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_top_header',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_top_header',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for top header advanced settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_top_header',
				'settings'      => 'color_magazinex_upgrade_top_header',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*---------------------------------------- Header: Trending ------------------------------------------*/
	/**
	 * Trending Section
	 */
	$wp_customize->add_section( 'color_magazinex_section_trending',
		array(
			'priority'       	=> 10,
			'panel'          	=> 'color_magazinex_header_panel',
			'capability'     	=> 'edit_theme_options',
			'title'          	=> __( 'Trending', 'color-magazinex' ),
			'active_callback' 	=> 'color_magazinex_enable_top_header_active_callback',
		)
	);

	/**
	 * Toggle field for Enable/Disable trending section.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_trending',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_trending',
			array(
				'label'    			=> __( 'Enable Trending Section', 'color-magazinex' ),
				'description' 		=> __( 'Trending section shows the popular tags.', 'color-magazinex' ),
				'section'       	=> 'color_magazinex_section_trending',
				'settings'      	=> 'color_magazinex_enable_trending',
				'priority'      	=> 10,
			)
		)
	);
	
	/**
	 * Text field for trending label.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_trending_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'Trending Now', 'color-magazinex' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_trending_label',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Trending Label', 'color-magazinex' ),
			'section'       	=> 'color_magazinex_section_trending',
			'settings'			=> 'color_magazinex_trending_label',
			'priority'      	=> 25,
			'active_callback' 	=> 'color_magazinex_enable_top_header_trending_active_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazinex_trending_label',
        array(
            'selector'        => '.trending-wrapper .wrap-label',
            'render_callback' => 'color_magazinex_customize_partial_trending_label',
        )
    );

    /**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_trending',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_trending',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for trending section advanced settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_trending',
				'settings'      => 'color_magazinex_upgrade_trending',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*---------------------------------------- Header: Ticker --------------------------------------------*/
	/**
	 * Ticker Section
	 */
	$wp_customize->add_section( 'color_magazinex_section_header_ticker',
		array(
			'priority'       => 15,
			'panel'          => 'color_magazinex_header_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Ticker', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for Enable/Disable ticker section. 
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_ticker',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_ticker',
			array(
				'label'    		=> __( 'Enable Ticker Section', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_ticker',
				'settings'      => 'color_magazinex_enable_ticker',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable ticker label. 
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_ticker_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_ticker_label',
			array(
				'label'    		=> __( 'Enable Ticker Label', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_ticker',
				'settings'      => 'color_magazinex_enable_ticker_label',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Text field for ticker label.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_ticker_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'Headline', 'color-magazinex' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_ticker_label',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Ticker Label', 'color-magazinex' ),
			'section'       	=> 'color_magazinex_section_header_ticker',
			'settings'      	=> 'color_magazinex_ticker_label',
			'priority'      	=> 10,
			'active_callback' 	=> 'color_magazinex_enable_ticker_active_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazinex_ticker_label',
        array(
            'selector'        => 'div.mt-ticker-label',
            'render_callback' => 'color_magazinex_customize_partial_ticker_label',
        )
    );

    /**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_ticker',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_ticker',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for ticker section advanced settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_ticker',
				'settings'      => 'color_magazinex_upgrade_ticker',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*---------------------------------------- Header: Extra Options -------------------------------------*/
	/**
	 * Header Extra Options
	 */
	$wp_customize->add_section( 'color_magazinex_section_header_extra',
		array(
			'priority'       => 20,
			'panel'          => 'color_magazinex_header_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Extra Options', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for Enable/Disable sticky menu.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_sticky_menu',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_sticky_menu',
			array(
				'label'    		=> __( 'Enable Sticky Menu', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_extra',
				'settings'      => 'color_magazinex_enable_sticky_menu',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable social icons.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_header_social_icons',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_header_social_icons',
			array(
				'label'    		=> __( 'Enable Social Icons', 'color-magazinex' ),
				'description'	=> sprintf( __( 'Enable/disable social icon content in the top header. And you can set the options from %1$s Social Icons. %2$s', 'color-magazinex' ), '<a href="'. esc_url( admin_url( 'customize.php' ).'?autofocus[section]=color_magazinex_section_social_icons' ).'">', '</a>' ),
				'section'       => 'color_magazinex_section_header_extra',
				'settings'      => 'color_magazinex_enable_header_social_icons',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable search icon. 
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_search_icon',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_search_icon',
			array(
				'label'    		=> __( 'Enable Search Icon', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_extra',
				'settings'      => 'color_magazinex_enable_search_icon',
				'priority'      => 15,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable site mode icon. 
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_site_mode_icon',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_site_mode_icon',
			array(
				'label'    		=> __( 'Enable Site Mode Icon', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_extra',
				'settings'      => 'color_magazinex_enable_site_mode_icon',
				'priority'      => 25,
			)
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_exra_option',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_exra_option',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for header extra option advanced settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_extra',
				'settings'      => 'color_magazinex_upgrade_exra_option',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*---------------------------------------- Header: Page Title ----------------------------------------*/
	/**
	 * Header Extra Options
	 */
	$wp_customize->add_section( 'color_magazinex_section_header_page_title',
		array(
			'priority'       => 25,
			'panel'          => 'color_magazinex_header_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Page Title', 'color-magazinex' )
		)
	);

	/**
	 * Toggle field for Enable/Disable inner page title.
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_header_page_title',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_header_page_title',
			array(
				'label'    			=> __( 'Enable Header Page Title', 'color-magazinex' ),
				'section'       	=> 'color_magazinex_section_header_page_title',
				'settings'      	=> 'color_magazinex_enable_header_page_title',
				'priority'      	=> 5
			)
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_header_page_title',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_header_page_title',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for more features about header page title.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_header_page_title',
				'settings'      => 'color_magazinex_upgrade_header_page_title',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*---------------------------------------- Header: Breadcrumbs  --------------------------------------*/
	/**
	 * Breadcrumbs
	 */
	$wp_customize->add_section( 'color_magazinex_section_breadcrumbs',
		array(
			'title'    			=> __( 'Breadcrumbs', 'color-magazinex' ),
			'panel'          	=> 'color_magazinex_header_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 30,
		)
	);

	/** 
	 * Toggle field for Enable/Disable breadcrumbs.
	 * 
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_breadcrumb_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_breadcrumb_option',
			array(
				'label'         => __( 'Enable Breadcrumbs', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_breadcrumbs',
				'settings'      => 'color_magazinex_enable_breadcrumb_option',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazinex_upgrade_breadcrumb',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Upgrade(
		$wp_customize, 'color_magazinex_upgrade_breadcrumb',
			array(
				'label'         => __( 'More Features', 'color-magazinex' ),
				'description'   => __( 'Upgrade to pro for breadcrumb advanced settings.', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_breadcrumbs',
				'settings'      => 'color_magazinex_upgrade_breadcrumb',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

}