<?php

/**
 * Quick Order Form Molecule
 *
 * @package khutwa
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (!$product) {
    return;
}
?>

<div class="quick-order-form-container mt-4 p-4 border rounded bg-white" dir="rtl">
    <h3 class="quick-order-title mb-3 text-center"><?php _e('طلب سريع - الدفع عند الاستلام', 'khutwa'); ?></h3>
    <form class="quick-order-form" method="post" action="">
        <?php wp_nonce_field('khutwa_quick_order_action', 'khutwa_quick_order_nonce'); ?>
        <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">

        <div class="mb-3">
            <label for="billing_first_name" class="form-label d-block"><?php _e('الاسم الكامل', 'khutwa'); ?></label>
            <input type="text" name="billing_first_name" id="billing_first_name" class="form-control" placeholder="<?php _e('أدخل اسمك الكامل', 'khutwa'); ?>" required>
        </div>

        <div class="mb-3">
            <label for="billing_phone" class="form-label d-block"><?php _e('رقم الهاتف', 'khutwa'); ?></label>
            <input type="tel" name="billing_phone" id="billing_phone" class="form-control" placeholder="<?php _e('أدخل رقم هاتفك', 'khutwa'); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-3 btn-lg fw-bold buy-now-btn">
            <span class="d-block main-btn-text"><?php _e('اشتري الآن - اضغط هنا', 'khutwa'); ?></span>
            <span class="d-block small opacity-75 fw-normal mt-1"><?php _e('الدفع عند الاستلام', 'khutwa'); ?></span>
        </button>
    </form>

    <div class="quick-order-trust mt-3 text-center small text-muted d-flex justify-content-center gap-3">
        <span>🚚 <?php _e('توصيل مجاني', 'khutwa'); ?></span>
        <span>✅ <?php _e('جودة مضمونة', 'khutwa'); ?></span>
    </div>
</div>