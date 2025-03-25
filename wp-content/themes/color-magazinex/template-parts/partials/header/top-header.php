<?php
/**
 * Partial template for top header.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazinex_enable_top_header = get_theme_mod( 'color_magazinex_enable_top_header', true );

if ( false === $color_magazinex_enable_top_header ) {
    return;
}

/**
 * color_magazinex_before_top_header hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_before_top_header' );

?>

<div id="top-header" class="top-header-wrap mt-clearfix">
    <div class="mt-container">
        <?php
            // trending tags
            get_template_part( 'template-parts/partials/header/trending', 'tags' );

            // top menu
            get_template_part( 'template-parts/partials/header/top', 'menu' );
        ?>
    </div><!-- mt-container -->
</div><!-- #top-header -->
<?php

/**
 * color_magazinex_after_top_header hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_after_top_header' );