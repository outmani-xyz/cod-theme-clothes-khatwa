<?php

/**
 * Product Grid Organism
 *
 * @package khutwa
 */

$title = $args['title'] ?? '';
$products = $args['products'] ?? array();
?>

<section class="product-grid-section py-5">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="section-title text-center mb-5"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">
            <?php
            if (! empty($products)) :
                foreach ($products as $product) :
            ?>
                    <div class="col-6 col-md-3 d-flex">
                        <?php
                        get_template_part('template-parts/molecules/product-card', '', array(
                            'product' => $product
                        ));
                        ?>
                    </div>
            <?php
                endforeach;
            else :
                echo '<div class="col-12 text-center text-muted"><p>' . __('No products found.', 'khutwa') . '</p></div>';
            endif;
            ?>
        </div>
    </div>
</section>