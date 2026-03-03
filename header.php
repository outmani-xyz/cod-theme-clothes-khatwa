<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'khutwa'); ?></a>

        <?php if (get_theme_mod('announcement_bar_text', __('FREE DELIVERY EVERYWHERE IN MOROCCO', 'khutwa'))) : ?>
            <div class="announcement-bar text-center">
                <div class="container">
                    <?php echo esc_html(get_theme_mod('announcement_bar_text', __('FREE DELIVERY EVERYWHERE IN MOROCCO', 'khutwa'))); ?>
                </div>
            </div>
        <?php endif; ?>

        <header id="masthead" class="site-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-md-3">
                        <div class="site-branding">
                            <?php
                            if (has_custom_logo()) :
                                the_custom_logo();
                            else :
                            ?>
                                <h1 class="site-title site-logo">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h1>
                            <?php
                            endif;
                            ?>
                        </div><!-- .site-branding -->
                    </div>

                    <div class="col-6 col-md-9 d-flex align-items-center justify-content-end">
                        <nav id="site-navigation" class="main-navigation">
                            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                                <span class="screen-reader-text"><?php esc_html_e('Menu', 'khutwa'); ?></span>
                            </button>

                            <div class="menu-wrapper">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'menu_id'        => 'primary-menu',
                                        'container'      => false,
                                        'menu_class'     => 'nav-menu primary-menu d-flex list-unstyled m-0',
                                        'depth'          => 1,
                                    )
                                );
                                ?>
                            </div>
                        </nav><!-- #site-navigation -->

                        <div class="header-icons ms-4">
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-contents d-flex align-items-center text-decoration-none" title="<?php esc_attr_e('View your shopping cart', 'khutwa'); ?>">
                                <span class="cart-icon me-2">🛒</span>
                                <span class="cart-count badge bg-primary"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toggleButton = document.querySelector('.menu-toggle');
                var navigation = document.querySelector('#site-navigation');

                if (toggleButton && navigation) {
                    toggleButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        navigation.classList.toggle('toggled');
                        var isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                        toggleButton.setAttribute('aria-expanded', !isExpanded);
                    });
                }
            });
        </script>