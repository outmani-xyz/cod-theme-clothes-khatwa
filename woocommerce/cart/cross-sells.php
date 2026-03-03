<?php

/**
 * Cross-sells in Cart
 */
defined('ABSPATH') || exit;

if ($cross_sells) : ?>
    <div class="cross-sells mb-5">
        <?php
        $heading = apply_filters('woocommerce_product_cross_sells_products_heading', __('New in store', 'khutwa'));

        if ($heading) :
        ?>
            <h2 class="text-center mb-4"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($cross_sells as $cross_sell) : ?>
                <div class="col-6 col-md-3 mb-4">
                    <?php
                    $post_object = get_post($cross_sell->get_id());
                    setup_postdata($GLOBALS['post'] = $post_object);

                    get_template_part('template-parts/molecules/product-card', '', array(
                        'product' => wc_get_product($cross_sell->get_id())
                    ));
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
endif;

wp_reset_postdata();
