<?php
/**
 * Display the main header
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * color_magazinex_before_main_header hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_before_main_header' );
$header_bg_attribute = '';
$header_bg_attribute = apply_filters( 'color_blog_header_bg_style_attribute', $header_bg_attribute );
$header_bg_style = '';
$header_class = '';
if ( ! empty( $header_bg_attribute ) ) {
    $header_bg_style    = 'style="' . wp_kses_post( $header_bg_attribute ) . '" ';
    $header_class       = 'has-bg-img';
}
?>
<header id="masthead" class="site-header <?php echo esc_attr( $header_class ); ?>" <?php echo $header_bg_style; ?>>
    <div class="mt-logo-row-wrapper mt-clearfix">
        <div class="logo-ads-wrap">
            <div class="mt-logo-social-search-wrapper">
                <div class="mt-container mt-flex">
                    <div class="mt-social-icons-wrapper">
                        <?php
                            // social icons
                            get_template_part( 'template-parts/partials/header/social', 'icons' );
                        ?>
                    </div><!-- .mt-social-wrapper -->
                    <div class="site-branding">
                        <?php
                            the_custom_logo();
                            if ( is_front_page() || is_home() ) :
                        ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php else : ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                        <?php
                            endif;
                            $color_magazinex_description = get_bloginfo( 'description', 'display' );
                            if ( $color_magazinex_description || is_customize_preview() ) :
                        ?>
                                <p class="site-description"><?php echo $color_magazinex_description; /* WPCS: xss ok. */ ?></p>
                        <?php endif; ?>
                    </div><!-- .site-branding -->
                    <div class="mt-search-wrapper">
                        <?php
                            // search
                            get_template_part( 'template-parts/partials/header/search' );

                            $color_magazinex_enable_site_mode_icon = get_theme_mod( 'color_magazinex_enable_site_mode_icon', false );
                            if ( false !== $color_magazinex_enable_site_mode_icon ) {
                        ?>
                                <div class="mt-site-mode-wrap">
                                    <input type="checkbox" class="mt-mode-toggle">
                                </div><!-- .mt-site-mode-wrap -->
                        <?php
                            }
                        ?>
                    </div> <!-- mt-search-wrapper -->
                </div> <!-- mt-container -->
            </div> <!-- mt-logo-social-search-wrapper -->

             <div class="header-widget-wrapper">
                <div class="mt-container">
                <?php 
                    if ( is_active_sidebar( 'header-ads-section' ) ) {
                        dynamic_sidebar( 'header-ads-section' );
                    }
                ?>
                </div><!-- .mt-container -->
            </div> <!-- header-widget-wrapper -->
        </div><!-- .logo-ads-wrap -->
    </div><!--.mt-logo-row-wrapper -->

    <div class="mt-menu-wrapper">
        <div class="mt-container">
            <div class="mt-main-menu-wrapper">
                <?php
                    $color_magazinex_menu_toggle_text = apply_filters( 'color_magazinex_menu_toggle_text', __( 'Menu', 'color-magazinex' ) );
                ?>
                <div class="menu-toggle"><a href="javascript:void(0)"><i class="bx bx-menu"></i><?php echo esc_html( $color_magazinex_menu_toggle_text ); ?></a></div>
                <nav itemscope id="site-navigation" class="main-navigation">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary_menu',
                            'menu_id'        => 'primary-menu',
                        ) );
                    ?>
                </nav><!-- #site-navigation -->
            </div><!-- .mt-main-menu-wrapper -->

        </div><!-- .mt-container -->
        
    </div><!--.mt-social-menu-wrapper -->

    <?php
        // header ticker
        get_template_part( 'template-parts/partials/header/ticker' );
    ?>
    
</header><!-- #masthead -->
<?php
/**
 * color_magazinex_after_main_header hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazinex_after_main_header' );