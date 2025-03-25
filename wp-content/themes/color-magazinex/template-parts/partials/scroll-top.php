<?php
/**
 * Partial template for scroll top.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$enable_scroll_top = get_theme_mod( 'color_magazinex_enable_scroll_top', true );
if ( false === $enable_scroll_top ) {
    return;
}

$color_magazinex_scroll_top_label = get_theme_mod( 'color_magazinex_scroll_top_label', __( 'Back To Top', 'color-magazinex' ) );

/**
 * color_magazinex_before_scroll_top hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_before_scroll_top' );

?>

<div id="mt-scrollup" class="animated arrow-hide">
    <span><?php echo esc_html( $color_magazinex_scroll_top_label ); ?></span>
</div><!-- #mt-scrollup -->

<?php
/**
 * color_magazinex_before_scroll_top hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_before_scroll_top' );