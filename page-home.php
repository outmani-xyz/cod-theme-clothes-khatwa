<?php

/**
 * Template Name: Home Page
 *
 * @package khutwa
 */

get_header(); ?>

<main id="primary" class="site-main">

    <?php
    // 1. Hero Section
    get_template_part('template-parts/organisms/hero');

    // 2. Top Popular
    $popular_products = wc_get_products(array(
        'limit' => 4,
        'status' => 'publish',
        'visibility' => 'visible',
    ));

    get_template_part('template-parts/organisms/product-grid', '', array(
        'title' => __('TOP POPULAR', 'khutwa'),
        'products' => $popular_products
    ));

    // 3. Best Sellers
    get_template_part('template-parts/organisms/product-grid', '', array(
        'title' => __('BEST SELLERS', 'khutwa'),
        'products' => $popular_products // Reusing for now
    ));

    // 4. Promotions
    get_template_part('template-parts/organisms/product-grid', '', array(
        'title' => __('PROMOTIONS', 'khutwa'),
        'products' => $popular_products // Reusing for now
    ));
    ?>

    </div>

    <?php get_template_part('template-parts/organisms/testimonials'); ?>

</main>


<?php
// Include mini-cart organism but hidden by default
get_template_part('template-parts/organisms/mini-cart');
get_footer(); ?>