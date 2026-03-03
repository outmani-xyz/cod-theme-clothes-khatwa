<?php

/**
 * Mini Cart Organism (Minimalist)
 *
 * @package khutwa
 */
?>

<div id="mini-cart-panel" class="mini-cart-panel">
    <div class="mini-cart-header">
        <h3><?php _e('YOUR CART', 'khutwa'); ?></h3>
        <button class="close-cart">&times;</button>
    </div>

    <div class="mini-cart-content">
        <?php woocommerce_mini_cart(); ?>
    </div>
</div>