<?php
/**
 * Partial template to display the post meta
 *
 * @package Color MagazineX
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( 'post' !== get_post_type() ) {
    return;
}
?>

<div class="entry-meta"> 
    <?php 
        color_magazinex_posted_on();
        color_magazinex_posted_by();
    ?> 
</div>