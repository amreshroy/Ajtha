<?php
/**
 * Color Magazine manage the Customizer options of footer settings panel.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_footer_panels_sections_register' );

/**
 * Add Additional panels in the theme customizer
 * 
 */
function color_magazinex_customize_footer_panels_sections_register( $wp_customize ) {

/*---------------------------------- Footer: Widget Area Section --------------------------------------------------*/
	/**
	 * Footer Widget Area
	 */
	$wp_customize->add_section( 'color_magazinex_section_footer_widget_area',
		array(
			'title'    			=> __( 'Footer Widget Area', 'color-magazinex' ),
			'panel'          	=> 'color_magazinex_footer_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 5,
		)
	);

	/**
	 * Toggle field for Enable/Disable footer widget area.
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_footer_widget_area',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_footer_widget_area',
			array(
				'label'    		=> __( 'Enable Footer Widget Area', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_footer_widget_area',
				'settings'      => 'color_magazinex_enable_footer_widget_area',
				'priority'      => 5,
			)
		)
	);

	/** 
	 * Radio Image field for Widget Area layout
	*/
	$wp_customize->add_setting( 'color_magazinex_widget_area_layout',
		array(
			'default'           => 'column-three',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Radio_Image(
		$wp_customize, 'color_magazinex_widget_area_layout',
			array(
				'label'    			=> __( 'Widget Area Layout', 'color-magazinex' ),
				'description'   	=> __( 'Choose widget layout from available layouts', 'color-magazinex' ),
				'section'       	=> 'color_magazinex_section_footer_widget_area',
				'settings'      	=> 'color_magazinex_widget_area_layout',
				'priority'      	=> 15,
				'active_callback'	=> 'color_magazinex_enable_footer_widget_area_active_callback',
				'choices'  			=> array(
					'column-four'		=> get_template_directory_uri() . '/assets/images/footer-4.png',
					'column-three' 	 	=> get_template_directory_uri() . '/assets/images/footer-3.png',
					'column-two'     	=> get_template_directory_uri() . '/assets/images/footer-2.png',
					'column-one'  	 	=> get_template_directory_uri() . '/assets/images/footer-1.png'
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

/*---------------------------------- Footer: Bottom Footer --------------------------------------------------------*/
	/**
	 * Bottom footer
	 */
	$wp_customize->add_section( 'color_magazinex_section_bottom_footer',
		array(
			'title'    			=> __( 'Bottom Footer', 'color-magazinex' ),
			'panel'          	=> 'color_magazinex_footer_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 10,
		)
	);

	/**
	 * Toggle field for Enable/Disable footer menu.
	 */
	$wp_customize->add_setting( 'color_magazinex_enable_footer_menu',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazinex_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazinex_Control_Toggle(
		$wp_customize, 'color_magazinex_enable_footer_menu',
			array(
				'label'    		=> __( 'Enable Footer Menu', 'color-magazinex' ),
				'section'       => 'color_magazinex_section_bottom_footer',
				'settings'      => 'color_magazinex_enable_footer_menu',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Text filed for copyright
	 */
	$wp_customize->add_setting( 'color_magazinex_footer_copyright',
		array(
			'capability'        => 'edit_theme_options',
			'default'  			=> __( 'Color Magazine', 'color-magazinex' ),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazinex_footer_copyright', 
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Copyright Text', 'color-magazinex' ),
			'section'       	=> 'color_magazinex_section_bottom_footer',
			'priority'      	=> 25,
			'active_callback'	=> 'color_magazinex_enable_footer_menu_active_callback',
		)
	);

}