<?php

/**
 * Ultra-Minimalist Single-Page Checkout
 *
 * @package khutwa
 */

if (! defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If lookup is required or user is not logged in and registration is enabled
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout single-page-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <div class="checkout-grid">
        <!-- 1. Form Fields (Billing) -->
        <div class="checkout-column billing-column">
            <h2 class="section-title"><?php esc_html_e('Informations de livraison', 'khutwa'); ?></h2>
            <?php if ($checkout->get_checkout_fields()) : ?>
                <?php do_action('woocommerce_checkout_billing'); ?>
            <?php endif; ?>
        </div>

        <!-- 2. Order Review & Payment -->
        <div class="checkout-column review-column">
            <h2 class="section-title"><?php esc_html_e('Récapitulatif', 'khutwa'); ?></h2>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>

            <div class="payment-force-notice mt-md">
                <p><strong>Mode de paiement :</strong> Paiement à la livraison (Cash on Delivery)</p>
            </div>
        </div>
    </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>