<?php

/**
 * Custom Single Product Template
 *
 * @package khutwa
 */

defined('ABSPATH') || exit;

global $product;

if (post_password_required()) {
    echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-single-container', $product); ?>>

    <div class="container container-narrow my-5">
        <div class="row product-main-row">
            <!-- 1. Product Image -->
            <div class="col-12 col-md-6 mb-4 mb-md-0">
                <div class="product-gallery">
                    <?php
                    $post_thumbnail_id = $product->get_image_id();
                    if ($post_thumbnail_id) {
                        echo wp_get_attachment_image($post_thumbnail_id, 'full', false, array('class' => 'img-fluid rounded'));
                    } else {
                        echo '<div class="placeholder-img bg-light ratio ratio-1x1 d-flex align-items-center justify-content-center"><span>' . __('Image not available', 'khutwa') . '</span></div>';
                    }
                    ?>
                </div>
            </div>

            <!-- 2. Product Details -->
            <div class="col-12 col-md-6">
                <div class="product-details-summary h-100 d-flex flex-column justify-content-center text-start">
                    <?php
                    get_template_part('template-parts/atoms/product-title', '', array(
                        'title' => $product->get_name(),
                        'tag'   => 'h1'
                    ));
                    ?>

                    <div class="price-wrapper mt-3">
                        <?php
                        get_template_part('template-parts/atoms/price', '', array(
                            'product' => $product
                        ));
                        ?>
                    </div>

                    <div class="product-short-description mt-4 text-muted">
                        <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
                    </div>

                    <!-- Add to Cart Form -->
                    <div class="product-selection mt-4">
                        <?php
                        if ($product->is_type('variable')) {
                            woocommerce_variable_add_to_cart();
                        } else {
                            get_template_part('template-parts/molecules/quick-order-form');
                        }
                        ?>
                    </div>

                    <div class="mt-4">
                        <?php get_template_part('template-parts/atoms/feature-badge'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    ?>
    <div class="container container-narrow border-top pt-5">
        <?php do_action('woocommerce_after_single_product_summary'); ?>
    </div>

</div>