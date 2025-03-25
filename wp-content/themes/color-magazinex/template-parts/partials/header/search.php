<?php
/**
 * Partial template for search icons.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazinex_enable_search_icon = get_theme_mod( 'color_magazinex_enable_search_icon', true );
if ( false === $color_magazinex_enable_search_icon ) {
	return;
}
$color_magazinex_menu_search_icon_lable = apply_filters( 'color_magazinex_menu_search_icon_lable', __( 'Search', 'color-magazinex' ) );

?>
<div class="mt-menu-search">
	<div class="mt-search-icon"><a href="javascript:void(0)"><?php echo esc_html( $color_magazinex_menu_search_icon_lable ); ?><i class='bx bx-search'></i></a></div>
	<div class="mt-form-wrap">
		<div class="mt-form-close"><a href="javascript:void(0)"><i class='bx bx-x'></i></a></div>
		<?php get_search_form(); ?>
	</div><!-- .mt-form-wrap -->
</div><!-- .mt-menu-search -->