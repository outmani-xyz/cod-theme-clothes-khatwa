<?php

/**
 * Input Atom
 *
 * @package khutwa
 */

$type = $args['type'] ?? 'text';
$name = $args['name'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$value = $args['value'] ?? '';
$required = $args['required'] ?? false;
?>

<input
    type="<?php echo esc_attr($type); ?>"
    name="<?php echo esc_attr($name); ?>"
    placeholder="<?php echo esc_attr($placeholder); ?>"
    value="<?php echo esc_attr($value); ?>"
    class="input-atom"
    <?php echo $required ? 'required' : ''; ?>>