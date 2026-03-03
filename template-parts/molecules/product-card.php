<?php

/**
 * Product Card Molecule
 *
 * @package khutwa
 */

$product = $args['product'] ?? null;

if (! $product) return;

$product_id = $product->get_id();
$image_url = get_the_post_thumbnail_url($product_id, 'medium');
$title = $product->get_name();
$price_html = $product->get_price_html();
$url = get_permalink($product_id);
?>

<div class="product-card h-100 bg-white border border-light overflow-hidden transition-all hover-shadow">
    <a href="<?php echo esc_url($url); ?>" class="product-image-link text-decoration-none">
        <div class="product-image-wrapper ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
            <?php if ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="img-fluid object-fit-cover w-100 h-100">
            <?php else : ?>
                <div class="placeholder-img text-muted">No Image</div>
            <?php endif; ?>
        </div>
    </a>

    <div class="product-info p-3 text-center d-flex flex-column h-100">
        <a href="<?php echo esc_url($url); ?>" class="text-decoration-none text-dark">
            <h5 class="product-title mb-2 fw-semibold fs-6"><?php echo esc_html($title); ?></h5>
        </a>

        <div class="product-price mt-auto mb-3 fw-bold text-primary">
            <?php echo $price_html; ?>
        </div>

        <div class="product-actions">
            <a href="<?php echo esc_url($url); ?>" class="btn btn-outline btn-sm w-100">
                <?php _e('View Details', 'khutwa'); ?>
            </a>
        </div>
    </div>
</div>