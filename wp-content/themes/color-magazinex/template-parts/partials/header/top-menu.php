<?php
/**
 * Top header menu
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<nav id="top-navigation" class="top-header-nav mt-clearfix">
    <?php
        wp_nav_menu( array(
            'theme_location'    => 'top_header_menu',
            'menu_id'           => 'top-header-menu',
            'depth'             => 1,
            'fallback_cb'       => false
        ) );
    ?>
</nav><!-- #top-navigation -->