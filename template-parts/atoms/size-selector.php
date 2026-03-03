<?php

/**
 * Native Size Selector Atom
 *
 * @package khutwa
 */

global $product;

if (!$product || !$product->is_type('variable')) {
    return;
}

$attribute_name = 'pa_size';
$options = $product->get_variation_attributes()[$attribute_name] ?? array();

if (empty($options)) {
    return;
}
?>

<div class="size-selector">
    <label class="size-label mb-xs d-block">TAILLE</label>
    <div class="size-grid">
        <?php foreach ($options as $option) : ?>
            <label class="size-option">
                <input type="radio" name="attribute_<?php echo esc_attr($attribute_name); ?>" value="<?php echo esc_attr($option); ?>" required>
                <span><?php echo esc_html($option); ?></span>
            </label>
        <?php endforeach; ?>
    </div>
</div>