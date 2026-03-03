<?php

/**
 * Testimonials Organism
 *
 * @package khutwa
 */

$testimonial_class = get_theme_mod('testimonial_layout_class', 'bg-white shadow-sm border rounded-3 p-4');
?>

<section class="testimonials-section py-5 bg-light border-top border-bottom">
    <div class="container container-narrow">
        <h2 class="section-title text-center mb-5"><?php _e('What Our Customers Say', 'khutwa'); ?></h2>
        <div class="row g-4">
            <?php for ($i = 1; $i <= 3; $i++) :
                $text = get_theme_mod("testimonial_{$i}_text");
                $author = get_theme_mod("testimonial_{$i}_author");
                $location = get_theme_mod("testimonial_{$i}_location");
                if (!$text && !$author) {
                    // Fallback to defaults if customizer is empty
                    $defaults_text = array(
                        1 => __("La qualité du cuir est exceptionnelle. Une babouche qui allie confort et élégance, je recommande vivement !", 'khutwa'),
                        2 => __("Envoi rapide et soigné. On sent que c'est du fait main avec passion. J'adore mes sabots.", 'khutwa'),
                        3 => __("Minimaliste et chic. C'est exactement ce que je cherchais pour mes tenues quotidiennes.", 'khutwa'),
                    );
                    $defaults_author = array(1 => __("Sarah B.", 'khutwa'), 2 => __("Mehdi A.", 'khutwa'), 3 => __("Imane T.", 'khutwa'));
                    $defaults_location = array(1 => __("Casablanca", 'khutwa'), 2 => __("Rabat", 'khutwa'), 3 => __("Marrakech", 'khutwa'));

                    $text = $defaults_text[$i];
                    $author = $defaults_author[$i];
                    $location = $defaults_location[$i];
                }
            ?>
                <div class="col-12 col-md-4 text-center">
                    <div class="testimonial-item h-100 <?php echo esc_attr($testimonial_class); ?>">
                        <p class="testimonial-text fst-italic mb-4 text-muted">"<?php echo esc_html($text); ?>"</p>
                        <hr class="w-25 mx-auto mb-3">
                        <div class="testimonial-meta">
                            <h5 class="testimonial-author mb-1 fw-bold"><?php echo esc_html($author); ?></h5>
                            <small class="testimonial-location text-uppercase text-muted"><?php echo esc_html($location); ?></small>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>