<?php

/**
 * Price Atom
 *
 * @package khutwa
 */

$product = $args['product'] ?? null;
$price = $args['price'] ?? '';

if ($product && is_a($product, 'WC_Product') && empty($price)) {
    $price_html = $product->get_price_html();
} else {
    $currency = $args['currency'] ?? 'DH';
    $price_html = '<span class="price-value">' . esc_html($price) . '</span> <span class="price-currency">' . esc_html($currency) . '</span>';
}
?>

<div class="price-atom">
    <?php echo $price_html; ?>
</div>