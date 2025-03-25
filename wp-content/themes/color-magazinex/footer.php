<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
	    </div> <!-- mt-container -->
	</div><!-- #content -->

    <?php
        /**
         * hook - color_magazinex_before_footer
         * 
         * @since 1.0.0
         */
        do_action( 'color_magazinex_before_footer' );

        /**
         * hook - color_magazinex_footer
         * 
         * @hooked - color_magazinex_footer_start - 5
         * @hooked - color_magazinex_footer_sidebar - 10
         * @hooked - color_magazinex_bottom_footer - 15
         * @hooked - color_magazinex_footer_end - 20
         * @hooked - color_magazinex_scroll_top - 30
         *
         * @since 1.0.0
         */
        do_action( 'color_magazinex_footer' );
	?>
	
</div><!-- #page -->

<?php
	/**
     * hook - color_magazinex_after_page
     *
     * @since 1.0.0
     */
    do_action( 'color_magazinex_after_page' );

    wp_footer();
?>
</body>
</html>
