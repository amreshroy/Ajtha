<?php
/**
 * Color Magazine manage the Customizer options of typography panel.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazinex_customize_typography_panels_sections_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazinex_customize_typography_panels_sections_register( $wp_customize ) {

/*---------------------------- Typography: Body Section ---------------------------------------*/
    /**
     * Body section
     */
    $wp_customize->add_section(
        'color_magazinex_body_typo_section',
        array(
            'title'     => __( 'Body Fonts', 'color-magazinex' ),
            'panel'     => 'color_magazinex_typography_panel',
            'priority'  => 5,
        )
    );

    /**
     * Settings for body typography
     */
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'default'           => 'Work Sans',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_setting(
        'body_font_style',
        array(
            'default'           => 'regular',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_setting(
        'body_text_decoration',
        array(
            'default'           => 'none',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_setting(
        'body_text_transform',
        array(
            'default'           => 'none',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    /**
     * Controls for body typography 
     */
    $wp_customize->add_control( new Color_Magazinex_Control_Typography (
        $wp_customize, 'body_typography',
            array(
                'label'       => __( 'Body Typography', 'color-magazinex' ),
                'description' => __( 'Select how you want your body fonts to appear.', 'color-magazinex' ),
                'section'     => 'color_magazinex_body_typo_section',
                'settings'    => array(
                    'family'            => 'body_font_family',
                    'style'             => 'body_font_style',
                    'text_decoration'   => 'body_text_decoration',
                    'text_transform'    => 'body_text_transform',
                ),
                // Pass custom labels. Use the setting key (above) for the specific label.
                'l10n'        => array(),
            )
        )
    );

/*---------------------------- Typography: Header Section ---------------------------------------*/
    /**
     * Header section
     */
    $wp_customize->add_section(
        'color_magazinex_header_typo_section',
        array(
            'title'     => __( 'Header Fonts', 'color-magazinex' ),
            'panel'     => 'color_magazinex_typography_panel',
            'priority'  => 10,
        )
    );

    /**
     * Settings for body typography
     */
    $wp_customize->add_setting(
        'header_font_family',
        array(
            'default'           => 'Work Sans',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_setting(
        'header_font_style',
        array(
            'default'           => 'regular',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_setting(
        'header_text_decoration',
        array(
            'default'           => 'none',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_setting(
        'header_text_transform',
        array(
            'default'           => 'none',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    /**
     * Controls for header typography 
     */
    $wp_customize->add_control( new Color_Magazinex_Control_Typography (
        $wp_customize, 'header_typography',
            array(
                'label'       => __( 'Header Typography', 'color-magazinex' ),
                'description' => __( 'Select how you want your header fonts to appear.', 'color-magazinex' ),
                'section'     => 'color_magazinex_header_typo_section',
                'settings'    => array(
                    'family'            => 'header_font_family',
                    'style'             => 'header_font_style',
                    'text_decoration'   => 'header_text_decoration',
                    'text_transform'    => 'header_text_transform',
                ),
                // Pass custom labels. Use the setting key (above) for the specific label.
                'l10n'        => array(),
            )
        )
    );

}