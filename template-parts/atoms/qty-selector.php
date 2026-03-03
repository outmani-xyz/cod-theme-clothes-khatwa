<?php

/**
 * Quantity Selector Atom
 *
 * @package khutwa
 */

$value = $args['value'] ?? 1;
$name = $args['name'] ?? 'quantity';
?>

<div class="quantity-selector">
    <button type="button" class="qty-btn" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
    <input type="number" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" min="1" readonly>
    <button type="button" class="qty-btn" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
</div>