<?php

/**
 * Quick Order Handler
 *
 * @package khutwa
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle the quick order form submission.
 */
function khutwa_handle_quick_order()
{
    if (isset($_POST['khutwa_quick_order_nonce']) && wp_verify_nonce($_POST['khutwa_quick_order_nonce'], 'khutwa_quick_order_action')) {

        $product_id   = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
        $phone        = isset($_POST['billing_phone']) ? sanitize_text_field($_POST['billing_phone']) : '';
        $first_name   = isset($_POST['billing_first_name']) ? sanitize_text_field($_POST['billing_first_name']) : 'Quick Order';

        if (!$product_id || empty($phone)) {
            wc_add_notice(__('Please fill in all required fields.', 'khutwa'), 'error');
            return;
        }

        try {
            // 1. Create Order
            $order = wc_create_order();
            
            // 2. Add Product/Variation
            if ($variation_id > 0) {
                $variation = wc_get_product($variation_id);
                $order->add_product($variation, 1);
            } else {
                $order->add_product(wc_get_product($product_id), 1);
            }

            // 3. Set Address Info
            $address = array(
                'first_name' => $first_name,
                'last_name'  => '',
                'company'    => '',
                'email'      => 'customer@quickorder.local', // Placeholder
                'phone'      => $phone,
                'address_1'  => 'COD Order',
                'address_2'  => '',
                'city'       => 'Morocco', // Default since field was removed
                'state'      => '',
                'postcode'   => '',
                'country'    => 'MA', // Default to Morocco
            );
            $order->set_address($address, 'billing');
            $order->set_address($address, 'shipping');

            // 4. Set Payment Method (COD)
            $order->set_payment_method('cod');
            $order->set_payment_method_title('Cash on Delivery');

            // 5. Calculate totals and save
            $order->calculate_totals();
            $order->update_status('processing', __('Quick Order created via product page.', 'khutwa'));

            // 6. Redirect to Thank You page
            $redirect_url = $order->get_checkout_order_received_url();
            wp_redirect($redirect_url);
            exit;
        } catch (Exception $e) {
            wc_add_notice($e->getMessage(), 'error');
        }
    }
}
add_action('init', 'khutwa_handle_quick_order');

/**
 * Inject Quick Order fields into the variation form.
 */
function khutwa_inject_variable_quick_order_fields() {
    global $product;
    if (!$product || !$product->is_type('variable')) {
        return;
    }
    
    // We reuse the same logic but without the form wrapper since WC provides it
    ?>
    <div class="quick-order-variable-fields mt-4 p-3 border rounded bg-white" dir="rtl">
        <div class="mb-3 text-end">
            <label for="billing_first_name" class="form-label d-block"><?php _e('الاسم الكامل', 'khutwa'); ?></label>
            <input type="text" name="billing_first_name" id="billing_first_name" class="form-control" placeholder="<?php _e('أدخل اسمك الكامل', 'khutwa'); ?>" required>
        </div>

        <div class="mb-3 text-end">
            <label for="billing_phone" class="form-label d-block"><?php _e('رقم الهاتف', 'khutwa'); ?></label>
            <input type="tel" name="billing_phone" id="billing_phone" class="form-control" placeholder="<?php _e('أدخل رقم هاتفك', 'khutwa'); ?>" required>
        </div>

        <?php wp_nonce_field('khutwa_quick_order_action', 'khutwa_quick_order_nonce'); ?>

        <button type="submit" class="btn btn-primary w-100 py-3 btn-lg fw-bold buy-now-btn">
            <span class="d-block main-btn-text"><?php _e('اشتري الآن - اضغط هنا', 'khutwa'); ?></span>
            <span class="d-block small opacity-75 fw-normal mt-1"><?php _e('الدفع عند الاستلام', 'khutwa'); ?></span>
        </button>

        <div class="quick-order-trust mt-3 text-center small text-muted d-flex justify-content-center gap-3">
            <span>🚚 <?php _e('توصيل مجاني', 'khutwa'); ?></span>
            <span>✅ <?php _e('جودة مضمونة', 'khutwa'); ?></span>
        </div>
    </div>
    <?php
}
add_action('woocommerce_after_add_to_cart_button', 'khutwa_inject_variable_quick_order_fields');

