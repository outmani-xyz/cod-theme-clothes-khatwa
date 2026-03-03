<?php

/**
 * The template for displaying product content within loops
 *
 * @package khutwa
 */

defined('ABSPATH') || exit;

global $product;

// Check if it's a valid product
if (empty($product) || ! $product->is_visible()) {
    return;
}
?>

<div <?php wc_product_class('col-6 col-md-4 col-lg-3 d-flex', $product); ?>>
    <?php
    get_template_part('template-parts/molecules/product-card', '', array(
        'product' => $product
    ));
    ?>
</div>