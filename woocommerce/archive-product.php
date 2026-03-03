<?php

/**
 * Custom Archive Product Template
 * 
 * Unifies the design of category and shop pages with a Sidebar.
 *
 * @package khutwa
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<div class="container my-5">
    <div class="row">

        <?php
        /**
         * 1. Sidebar (col-md-4 col-lg-3)
         */
        get_sidebar();
        ?>

        <!-- 2. Main content (col-md-8 col-lg-9) -->
        <main id="primary" class="col-12 col-md-8 col-lg-9 content-area">
            <header class="woocommerce-products-header text-start mb-5">
                <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                    <h1 class="woocommerce-products-header__title page-title display-4 fw-bold"><?php woocommerce_page_title(); ?></h1>
                <?php endif; ?>

                <?php
                /**
                 * Hook: woocommerce_archive_description.
                 */
                do_action('woocommerce_archive_description');
                ?>
            </header>

            <?php
            if (woocommerce_product_loop()) {
            ?>
                <div class="shop-loop-controls d-flex justify-content-between align-items-center mb-4">
                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop.
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>
                </div>
            <?php

                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();
                        do_action('woocommerce_shop_loop');
                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();
                do_action('woocommerce_after_shop_loop');
            } else {
                do_action('woocommerce_no_products_found');
            }
            ?>
        </main>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
