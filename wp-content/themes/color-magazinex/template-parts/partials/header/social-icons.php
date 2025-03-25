<?php
/**
 * Partial template for social icons.
 *
 * @package Color MagazineX
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazinex_enable_header_social_icons = get_theme_mod( 'color_magazinex_enable_header_social_icons', false );
if ( false === $color_magazinex_enable_header_social_icons ) {
    return;
}

$defaults_icons = json_encode( array(
        array(
            'social_icon' => 'bx bxl-twitter',
            'social_url'  => '#',
        ),
        array(
            'social_icon' => 'bx bxl-pinterest',
            'social_url'  => '#',
        )
    )
);

?>
<div class="mt-social-wrapper mt-flex">
<?php
    $color_magazinex_social_icons = get_theme_mod( 'color_magazinex_social_icons', $defaults_icons );
    $social_icons = json_decode( $color_magazinex_social_icons );

    if ( ! empty( $social_icons ) ) {
?>
        <ul class="mt-social-icon-wrap">
            <?php
                foreach ( $social_icons as $social_icon ) {
                    if ( ! empty( $social_icon->social_url ) ) {
            ?>
                        <li class="mt-social-icon">
                            <a href="<?php echo esc_url( $social_icon->social_url ); ?>" target="_blank">
                                <i class="<?php echo esc_attr( $social_icon->social_icon ); ?>"></i>
                            </a>
                        </li>
            <?php
                    }
                }
            ?>
        </ul>
<?php 
    }
?>
</div>