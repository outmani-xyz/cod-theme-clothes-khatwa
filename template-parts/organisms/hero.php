<?php

/**
 * Hero Organism
 *
 * @package khutwa
 */

$title = $args['title'] ?? __('Modern Elegance in Every Step', 'khutwa');
$subtitle = $args['subtitle'] ?? __('Discover our exclusive collection of luxury Abayas and Jelbabs, handcrafted for the modern woman.', 'khutwa');
$button_text = $args['button_text'] ?? __('View Collection', 'khutwa');
$button_url = $args['button_url'] ?? '/shop';
?>

<section class="hero-section py-5 bg-light text-center" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-abaya.png'); background-size: cover; background-position: center; min-height: 600px; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-white">
                <h1 class="hero-title display-4 fw-bold"><?php echo esc_html($title); ?></h1>
                <p class="hero-subtitle lead mt-3"><?php echo esc_html($subtitle); ?></p>
                <div class="hero-actions mt-4">
                    <?php
                    get_template_part('template-parts/atoms/button', '', array(
                        'text' => $button_text,
                        'url' => $button_url,
                        'class' => 'btn btn-primary btn-lg px-5'
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>