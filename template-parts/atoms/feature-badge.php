<?php
$badge_title    = get_theme_mod('feature_badge_title', '');
$badge_subtitle = get_theme_mod('feature_badge_subtitle', '');

if (empty($badge_title)) {
    return;
}
?>

<div class="feature-badge mt-md">
    <div class="badge-icon">✨</div>
    <div class="badge-content">
        <span class="badge-title"><?php echo esc_html($badge_title); ?></span>
        <?php if (!empty($badge_subtitle)) : ?>
            <span class="badge-subtitle"><?php echo esc_html($badge_subtitle); ?></span>
        <?php endif; ?>
    </div>
</div>