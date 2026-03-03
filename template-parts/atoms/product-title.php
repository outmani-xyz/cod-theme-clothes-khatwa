<?php

/**
 * Product Title Atom
 *
 * @package khutwa
 */

$title = $args['title'] ?? 'Sabot Traditionnel';
$tag = $args['tag'] ?? 'h2';
$url = $args['url'] ?? '';
?>

<<?php echo esc_attr($tag); ?> class="product-title">
    <?php if ($url) : ?>
        <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
    <?php else : ?>
        <?php echo esc_html($title); ?>
    <?php endif; ?>
</<?php echo esc_attr($tag); ?>>