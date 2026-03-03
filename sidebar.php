<?php

/**
 * The sidebar containing the main widget area
 *
 * @package khutwa
 */
?>

<aside id="secondary" class="widget-area col-12 col-md-4 col-lg-3">
    <?php if (is_active_sidebar('sidebar-shop')) : ?>
        <?php dynamic_sidebar('sidebar-shop'); ?>
    <?php else : ?>
        <div class="widget">
            <h2 class="widget-title text-uppercase" style="font-size: 1rem; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;"><?php esc_html_e('Filters', 'khutwa'); ?></h2>
            <p style="font-size: 0.9rem; color: #666;"><?php esc_html_e('Custom shop filters will appear here.', 'khutwa'); ?></p>
        </div>
    <?php endif; ?>
</aside><!-- #secondary -->