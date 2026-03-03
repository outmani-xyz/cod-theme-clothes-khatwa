<?php

/**
 * Button Atom
 *
 * @package khutwa
 */

$text = $args['text'] ?? 'Commander';
$url  = $args['url'] ?? '#';
$class = $args['class'] ?? '';
$type = $args['type'] ?? 'a'; // 'a' or 'button'
?>

<?php if ('button' === $type) : ?>
    <button class="btn <?php echo esc_attr($class); ?>">
        <?php echo esc_html($text); ?>
    </button>
<?php else : ?>
    <a href="<?php echo esc_url($url); ?>" class="btn <?php echo esc_attr($class); ?>">
        <?php echo esc_html($text); ?>
    </a>
<?php endif; ?>