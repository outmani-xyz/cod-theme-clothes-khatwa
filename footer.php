<footer id="colophon" class="site-footer bg-light py-5">
    <div class="container container-narrow">
        <div class="row mb-5">
            <!-- 1. Logo and Description -->
            <div class="col-12 col-md-6">
                <div class="footer-branding text-start">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h2 class="site-logo m-0"><?php bloginfo('name'); ?></h2>
                    <?php endif; ?>
                    <p class="mt-3 text-muted"><?php echo get_theme_mod('blogdescription', __('Exceptional Moroccan Craftsmanship', 'khutwa')); ?></p>
                </div>
                <div class="social-links-wrapper">
                    <div class="social-links d-flex gap-3 justify-content-start">
                        <?php
                        $socials = array(
                            'facebook'  => get_theme_mod('social_facebook'),
                            'instagram' => get_theme_mod('social_instagram'),
                            'tiktok'    => get_theme_mod('social_tiktok'),
                        );
                        foreach ($socials as $slug => $url) : if ($url) : ?>
                                <a href="<?php echo esc_url($url); ?>" class="social-icon" target="_blank" rel="noopener">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/<?php echo ($slug === 'facebook' ? 'fb' : $slug); ?>-icon.svg" alt="<?php echo esc_attr($slug); ?>" width="24" height="24">
                                </a>
                        <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- 2. Footer Menu -->
            <div class="col-12 col-md-6">
                <div class="footer-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'secondary',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                            'depth'          => 1,
                        )
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="row border-top pt-4">
            <div class="col-12 text-start text-muted">
                <div class="site-info">
                    <span dir="ltr" class="d-inline-block">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></span>. <?php _e('All rights reserved.', 'khutwa'); ?> | <?php _e('build by:', 'khutwa'); ?> <a href="https://outmani.me" target="_blank" rel="noopener">outmani.me</a>
                </div><!-- .site-info -->
            </div>
        </div>
    </div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>