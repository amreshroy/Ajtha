<?php
/**
 * Dynamic styles
 *
 * @package Color MagazineX
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'color_magazinex_custom_css' ) ) :

    /**
     * function to handle color_magazinex_head_css filter where all the css relation functions are hooked.
     *
     * @since 1.0.0
     */
    function color_magazinex_custom_css( $output_css = NULL ) {

        // Add filter color_magazine_head_css for adding custom css via other functions.
        $output_css = apply_filters( 'color_magazinex_head_css', $output_css );

        if ( ! empty( $output_css ) ) {
            $output_css = wp_strip_all_tags( color_magazinex_minify_css( $output_css ) );
            echo "<!--Color Magazinex CSS -->\n<style type=\"text/css\">\n". $output_css ."\n</style>";
        }
    }

endif;

add_action( 'wp_head', 'color_magazinex_custom_css', 9999 );

if ( ! function_exists( 'color_magazinex_general_css' ) ) :
    
    function color_magazinex_general_css( $output_css ) {

        $color_magazinex_primary_color = get_theme_mod( 'color_magazinex_primary_color', '#EC3535' );
        $get_categories = get_categories( array( 'hide_empty' => 1 ) );

        $main_container_width   = get_theme_mod( 'color_magazinex_main_container_width', 1300 );
        $boxed_container_width  = get_theme_mod( 'color_magazinex_boxed_container_width', 1200 );
        $main_content_width     = get_theme_mod( 'color_magazinex_main_content_width', 70 );
        $sidebar_width          = get_theme_mod( 'color_magazinex_sidebar_width', 27 );

        //define variable for custom css
        $custom_css = '';
    
        foreach ( $get_categories as $category ) {

            $cat_color = get_theme_mod( 'color_magazinex_category_color_'.$category->slug, '#3b2d1b' );
            $cat_hover_color = color_magazinex_hover_color( $cat_color, '-50' );
            $cat_id = $category->term_id;
            
            if ( !empty( $cat_color ) ) {
                $custom_css .= ".category-button.cb-cat-". esc_attr( $cat_id ) ." a { background: ". esc_attr( $cat_color ) ."}\n";
                $custom_css .= ".category-button.cb-cat-". esc_attr( $cat_id ) ." a:hover { background: ". esc_attr( $cat_hover_color ) ."}\n";
                $custom_css .= "#site-navigation ul li.cb-cat-". esc_attr( $cat_id ) ." .menu-item-description { background: ". esc_attr( $cat_color ) ."}\n";
               $custom_css .= "#site-navigation ul li.cb-cat-". esc_attr( $cat_id ) ." .menu-item-description:after { border-top-color: ". esc_attr( $cat_color ) ."}\n";
            }
        }
        
        $custom_css .= "a,a:hover,a:focus,a:active,.entry-cat .cat-links a:hover,.entry-cat a:hover,.byline a:hover,.posted-on a:hover,.entry-footer a:hover,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,.mt-social-icon-wrap li a:hover,.mt-search-icon:hover,.mt-form-close a:hover,.menu-toggle:hover,#site-navigation ul li:hover>a,#site-navigation ul li.current-menu-item>a,#site-navigation ul li.current_page_ancestor>a,#site-navigation ul li.current-menu-ancestor>a,#site-navigation ul li.current_page_item>a,#site-navigation ul li.focus>a,.entry-title a:hover,.cat-links a:hover,.entry-meta a:hover,.entry-footer .mt-readmore-btn:hover,.btn-wrapper a:hover,.mt-readmore-btn:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.breadcrumbs a:hover,#footer-menu li a:hover,#top-footer a:hover,.color_magazinex_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-mode-wrap .mt-mode-toggle:checked:hover,.has-thumbnail .post-info-wrap .entry-title a:hover,.front-slider-block .post-info-wrap .entry-title a:hover{ color: ". esc_attr( $color_magazinex_primary_color ) ."}\n";

        $custom_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.error-404.not-found,.color-magazinex_social_media a:hover{ border-color: ". esc_attr( $color_magazinex_primary_color ) ."}\n";

        $custom_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,#top-header,.mt-menu-search .mt-form-wrap .search-form .search-submit,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,#site-navigation .menu-item-description,.mt-ticker-label,.post-cats-list a,.front-slider-block .lSAction>a:hover,.top-featured-post-wrap .post-thumbnail .post-number,article.sticky::before,#secondary .widget .widget-title::before,.mt-related-post-title:before,#colophon .widget .widget-title:before,.features-post-title:before,.cvmm-block-title.layout--default:before,.color-magazinex_social_media a:hover { background: ". esc_attr( $color_magazinex_primary_color ) ."}\n";

         $custom_css .= ".mt-site-dark-mode .widget_archive a:hover,.mt-site-dark-mode .widget_categories a:hover,.mt-site-dark-mode .widget_recent_entries a:hover,.mt-site-dark-mode .widget_meta a,.mt-site-dark-mode .widget_recent_comments li:hover,.mt-site-dark-mode .widget_rss li,.mt-site-dark-mode .widget_pages li a:hover,.mt-site-dark-mode .widget_nav_menu li a:hover,.mt-site-dark-mode .wp-block-latest-posts li a:hover,.mt-site-dark-mode .wp-block-archives li a:hover,.mt-site-dark-mode .wp-block-categories li a:hover,.mt-site-dark-mode .wp-block-page-list li a:hover,.mt-site-dark-mode .wp-block-latest-comments li:hover,.mt-site-dark-mode #site-navigation ul li a:hover,.mt-site-dark-mode .site-title a:hover,.mt-site-dark-mode .entry-title a:hover,.mt-site-dark-mode .cvmm-post-title a:hover,.mt-site-dark-mode .mt-social-icon-wrap li a:hover,.mt-site-dark-mode .mt-search-icon a:hover,.mt-site-dark-mode .ticker-post-title a:hover,.single.mt-site-dark-mode .mt-author-box .mt-author-info .mt-author-name a:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:checked:hover,.mt-site-dark-mode .cvmm-cats-wrapper .cvmm-cat-title a:hover{ color: ". esc_attr( $color_magazinex_primary_color ) ." !important}\n";
        

        $custom_css .= "#site-navigation .menu-item-description::after,.mt-custom-page-header{ border-top-color: ". esc_attr( $color_magazinex_primary_color ) ."}\n";

        // container width (in px)
        if ( ! empty( $main_container_width ) ) {
            $custom_css .= '.mt-container{width:'. absint( $main_container_width ) .'px}';
        }

        // boxed container width (in px)
        if ( ! empty( $boxed_container_width ) ) {
            $custom_css .= '.site-layout--boxed #page{width:'. absint( $boxed_container_width ) .'px}';
        }
        
        // main content width (in %)
        if ( ! empty( $main_content_width ) ) {
            $custom_css .= '#primary,.home.blog #primary{width:'. absint( $main_content_width ) .'%}';
        }

        // sidebar content width (in %)
        if ( ! empty( $sidebar_width ) ) {
            $custom_css .= '#secondary,.home.blog #secondary{width:'. absint( $sidebar_width ) .'%}';
        }

        if ( ! empty( $custom_css ) ) {
            $output_css .= $custom_css;
        }

        return $output_css;
    }
    
endif;

add_filter( 'color_magazinex_head_css', 'color_magazinex_general_css' );

if ( ! function_exists( 'color_magazinex_typography_css' ) ) :

    /**
     * function to handle the typography css.
     *
     * @since 1.0.0
     */
    function color_magazinex_typography_css( $output_css ) {

        $custom_css = '';

        /**
         * Body typography
         */
        $body_font_family = get_theme_mod( 'body_font_family', 'Work Sans' );
        $body_font_style = get_theme_mod( 'body_font_style', '400' );
        $body_text_decoration = get_theme_mod( 'body_text_decoration', 'none' );
        $body_text_transform = get_theme_mod( 'body_text_transform', 'none' );

        if ( !empty( $body_font_style ) ) {
            $body_font_style_weight = preg_split( '/(?<=[0-9])(?=[a-z]+)/i', $body_font_style );
            if ( isset( $body_font_style_weight[1] ) ) {
                $body_font_style = $body_font_style_weight[1];
            } else {
                $body_font_style = 'normal';
            }

            if ( isset( $body_font_style_weight[0] ) ) {
                $body_font_weight = $body_font_style_weight[0];
            } else {
                $body_font_weight = 400;
            }
        }
        $custom_css .= "body {
            font-family: $body_font_family;
            font-style: $body_font_style;
            font-weight: $body_font_weight;
            text-decoration: $body_text_decoration;
            text-transform: $body_text_transform;
        }\n";

        /**
         * Header typography
         */
        $header_font_family     = get_theme_mod( 'header_font_family', 'PT Serif' );
        $header_font_style      = get_theme_mod( 'header_font_style', '700' );
        $header_text_decoration = get_theme_mod( 'header_text_decoration', 'none' );
        $header_text_transform  = get_theme_mod( 'header_text_transform', 'none' );

        if ( !empty( $header_font_style ) ) {
            $header_font_style_weight = preg_split( '/(?<=[0-9])(?=[a-z]+)/i', $header_font_style );
            if ( isset( $header_font_style_weight[1] ) ) {
                $header_font_style = $header_font_style_weight[1];
            } else {
                $header_font_style = 'normal';
            }

            if ( isset( $header_font_style_weight[0] ) ) {
                $header_font_weight = $header_font_style_weight[0];
            } else {
                $header_font_weight = 700;
            }
        }
        $custom_css .= "h1,h2,h3,h4,h5,h6, .single .entry-title,.site-title{
            font-family: $header_font_family;
            font-style: $header_font_style;
            font-weight: $header_font_weight;
            text-decoration: $header_text_decoration;
            text-transform: $header_text_transform;
        }\n";

        if ( ! empty( $custom_css ) ) {
            $output_css .= '/*/ Typography CSS /*/'. $custom_css;
        }

        return $output_css;

    }

endif;

add_filter( 'color_magazinex_head_css', 'color_magazinex_typography_css' );