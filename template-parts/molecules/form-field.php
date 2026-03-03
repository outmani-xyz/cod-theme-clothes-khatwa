<?php

/**
 * Form Field Molecule
 *
 * @package khutwa
 */

$label = $args['label'] ?? '';
$name = $args['name'] ?? '';
$type = $args['type'] ?? 'text';
$placeholder = $args['placeholder'] ?? '';
$required = $args['required'] ?? false;
?>

<div class="form-field">
    <?php if ($label) : ?>
        <label class="field-label"><?php echo esc_html($label); ?> <?php echo $required ? '*' : ''; ?></label>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/atoms/input', '', array(
        'type' => $type,
        'name' => $name,
        'placeholder' => $placeholder,
        'required' => $required
    ));
    ?>
</div>