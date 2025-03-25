<?php
/**
 * Partial template to display the post entry title
 *
 * @package Color MagazineX
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<header class="entry-header">
    <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
    ?>
</header><!-- .entry-header -->