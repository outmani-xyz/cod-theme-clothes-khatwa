<?php

/**
 * khutwa functions and definitions
 *
 * @package khutwa
 */

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', time());
}

function khutwa_setup()
{
    // Load theme textdomain for translations
    load_theme_textdomain('khutwa', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register nav menus
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary', 'khutwa'),
            'secondary' => esc_html__('Secondary', 'khutwa'),
        )
    );

    // Add theme support for HTML5 markup.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // WooCommerce Support
    add_theme_support('woocommerce');

    // Enable Widget Support explicitly 
    add_theme_support('widgets');

    // Add support for Custom Logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 100,
            'width'       => 300,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'khutwa_setup');

/**
 * Load Customizer settings.
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/quick-order.php';

/**
 * Require WooCommerce plugin.
 */
require_once get_template_directory() . '/inc/tgm-config.php';

/**
 * Enqueue scripts and styles.
 */
function khutwa_scripts()
{
    // Cairo font is loaded locally via @font-face in _fonts.scss — no external requests needed

    // Enqueue Compiled SASS
    wp_enqueue_style('khutwa-style', get_template_directory_uri() . '/assets/stylesheets/style.css', array(), _S_VERSION);

    wp_enqueue_script('khutwa-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'khutwa_scripts', 99);

/**
 * Remove standard WooCommerce Billing fields for minimalist checkout
 */
add_filter('woocommerce_checkout_fields', 'khutwa_override_checkout_fields',9999);
function khutwa_override_checkout_fields($fields)
{
    // 1. Relabel First Name to "Full Name"
    $fields['billing']['billing_first_name']['label'] = __('Full Name', 'khutwa');
    $fields['billing']['billing_first_name']['placeholder'] = __('Your full name', 'khutwa');
    $fields['billing']['billing_first_name']['class'] = array('form-row-wide');

    // 2. Unset everything else we DO NOT WANT
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_email']);

    // 3. Ensure Phone and City are wide and required
    $fields['billing']['billing_city']['label'] = __('City', 'khutwa');
    $fields['billing']['billing_city']['placeholder'] = __('Your city', 'khutwa');
    $fields['billing']['billing_city']['class'] = array('form-row-wide');
    $fields['billing']['billing_city']['required'] = true;

    $fields['billing']['billing_phone']['label'] = __('Phone', 'khutwa');
    $fields['billing']['billing_phone']['placeholder'] = __('Your phone number', 'khutwa');
    $fields['billing']['billing_phone']['class'] = array('form-row-wide');
    $fields['billing']['billing_phone']['required'] = true;

    // Unset shipping fields completely
    unset($fields['shipping']);

    // Unset order comments
    unset($fields['order']['order_comments']);

    return $fields;
}

/**
 * Force Cash on Delivery (COD) even if not enabled in settings
 */
add_filter('woocommerce_available_payment_gateways', 'khutwa_force_cod_payment');
function khutwa_force_cod_payment($available_gateways)
{
    if (is_admin()) return $available_gateways;

    // If COD is already there, make it default and remove others if desired
    if (isset($available_gateways['cod'])) {
        $available_gateways['cod']->enabled = 'yes';
    } else {
        // Manually add it if it doesn't exist (this is rare but safer)
        if (class_exists('WC_Gateway_COD')) {
            $cod_gateway = new WC_Gateway_COD();
            $available_gateways['cod'] = $cod_gateway;
        }
    }

    return $available_gateways;
}

/**
 * Update Place Order Button Text
 */
add_filter('woocommerce_order_button_text', 'khutwa_custom_checkout_button_text');
function khutwa_custom_checkout_button_text()
{
    return __('Place my order', 'khutwa');
}

/**
 * Force Cash on Delivery (COD) as the only payment method.
 */
add_filter('woocommerce_available_payment_gateways', 'khutwa_force_cod');
function khutwa_force_cod($available_gateways)
{
    if (isset($available_gateways['cod'])) {
        return array('cod' => $available_gateways['cod']);
    }
    return array();
}

/**
 * Native Product Seeder (Attributes & Variations)
 */
add_action('init', 'khutwa_seed_native_products');
function khutwa_seed_native_products()
{
    if (!isset($_GET['seed_native']) || $_GET['seed_native'] !== '1') {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $sizes = array('39', '40', '41', '42', '43');

    // Create 'Size' attribute if it doesn't exist
    $attribute_name = 'pa_size';
    if (!taxonomy_exists($attribute_name)) {
        // Check if the attribute already exists in WooCommerce attributes
        $attribute_id = wc_attribute_taxonomy_id_by_name('Size');
        if (!$attribute_id) {
            $attribute_id = wc_create_attribute(array(
                'name'         => 'Size',
                'slug'         => 'size',
                'type'         => 'select',
                'order_by'     => 'menu_order',
                'has_archives' => false,
            ));
        }

        foreach ($sizes as $size) {
            if (!term_exists($size, $attribute_name)) {
                wp_insert_term($size, $attribute_name);
            }
        }
    }

    $products_to_seed = array(
        array(
            'name' => 'Traditional Clog - Brown Suede',
            'price' => '349',
            'image' => 'https://khutwa.com/cdn/shop/files/sabot-daim-marron-1.jpg',
            'categories' => array('Clogs', 'Best Sellers'),
            'description' => 'A traditional clog revisited with high-quality suede leather. Handmade by our artisans.'
        ),
        array(
            'name' => 'Elegance Clog - Black Leather',
            'price' => '399',
            'image' => 'https://khutwa.com/cdn/shop/files/sabot-cuir-noir-1.jpg',
            'categories' => array('Clogs', 'New Arrivals'),
            'description' => 'The elegance of black leather combined with the comfort of traditional Moroccan craftsmanship.'
        ),
        array(
            'name' => 'City Babouche - Navy Blue',
            'price' => '299',
            'image' => 'https://khutwa.com/cdn/shop/files/babouche-bleu-1.jpg',
            'categories' => array('Babouches'),
            'description' => 'The modern babouche for everyday use, combining style and tradition.'
        ),
        array(
            'name' => 'Artisan Moccasin - Camel',
            'price' => '449',
            'image' => 'https://khutwa.com/cdn/shop/files/mocassin-camel-1.jpg',
            'categories' => array('Moccasins', 'Promo'),
            'description' => 'A moccasin in flexible natural leather, perfect for a casual chic look.'
        )
    );

    foreach ($products_to_seed as $data) {
        $existing = get_page_by_title($data['name'], OBJECT, 'product');
        if ($existing) {
            // Update existing to Variable if it's Simple
            $product = wc_get_product($existing->ID);
            if ($product->is_type('simple')) {
                wp_set_object_terms($existing->ID, 'variable', 'product_type');
                $product = new WC_Product_Variable($existing->ID);
            }
        } else {
            $product = new WC_Product_Variable();
            $product->set_name($data['name']);
            $product->set_status('publish');
            $product->set_description($data['description']);
            $product->save();
        }

        $product_id = $product->get_id();

        // Image Attachment
        if (!empty($data['image']) && !$product->get_image_id()) {
            $image_id = media_sideload_image($data['image'], $product_id, $data['name'], 'id');
            if (!is_wp_error($image_id)) {
                $product->set_image_id($image_id);
                $product->save();
            }
        }

        // Set Categories
        $cat_ids = array();
        foreach ($data['categories'] as $cat_name) {
            $term = get_term_by('name', $cat_name, 'product_cat');
            if (!$term) {
                $term_data = wp_insert_term($cat_name, 'product_cat');
                if (!is_wp_error($term_data)) $cat_ids[] = (int)$term_data['term_id'];
            } else {
                $cat_ids[] = (int)$term->term_id;
            }
        }
        wp_set_object_terms($product_id, $cat_ids, 'product_cat');

        // Set Attributes
        $attribute_object = new WC_Product_Attribute();
        $attribute_object->set_id(wc_attribute_taxonomy_id_by_name($attribute_name));
        $attribute_object->set_name($attribute_name);
        $attribute_object->set_options($sizes);
        $attribute_object->set_position(0);
        $attribute_object->set_visible(true);
        $attribute_object->set_variation(true);
        $product->set_attributes(array($attribute_object));
        $product->save();

        // Create Variations
        foreach ($sizes as $size) {
            $variation = new WC_Product_Variation();
            $variation->set_parent_id($product_id);
            $variation->set_attributes(array($attribute_name => $size));
            $variation->set_regular_price($data['price']);
            $variation->set_status('publish');
            $variation->set_manage_stock(false);
            $variation->save();
        }
    }

    wp_die('Native Seeding Complete. All products are now Variable with sizes 39-43. Please remove this hook.');
}

/**
 * Remove sidebar from Single Product Page
 */
add_action('wp', 'khutwa_remove_product_sidebar');
function khutwa_remove_product_sidebar()
{
    if (is_product()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}

/**
 * Configure Related Products (Similar Products)
 */
add_filter('woocommerce_output_related_products_args', 'khutwa_related_products_args', 20);
function khutwa_related_products_args($args)
{
    $args['posts_per_page'] = 4; // 4 related products
    $args['columns'] = 4; // arranged in 4 columns
    return $args;
}

/**
 * Force Related Products to show even if categories don't match (for small catalogs)
 */
add_filter('woocommerce_related_products', 'khutwa_force_related_products', 10, 3);
function khutwa_force_related_products($related_posts, $product_id, $args)
{
    if (empty($related_posts)) {
        $related_posts = wc_get_products(array('return' => 'ids', 'limit' => 4, 'exclude' => array($product_id)));
    }
    return $related_posts;
}

// Optional: Make email non-required in backend validation if you really don't want it.
add_filter('woocommerce_billing_fields', 'khutwa_unrequire_wc_fields');
function khutwa_unrequire_wc_fields($fields)
{
    if (isset($fields['billing_email'])) {
        $fields['billing_email']['required'] = false;
    }
    return $fields;
}
/**
 * Standardize Breadcrumb Wrapper
 */
add_filter('woocommerce_breadcrumb_defaults', 'khutwa_breadcrumb_defaults');
function khutwa_breadcrumb_defaults($defaults)
{
    $defaults['wrap_before'] = '<div class="container container-narrow mb-4"><nav class="woocommerce-breadcrumb">';
    $defaults['wrap_after']  = '</nav></div>';
    $defaults['delimiter']   = ' <span class="breadcrumb-separator">/</span> ';
    return $defaults;
}

/**
 * Change currency symbol to DH
 */
add_filter('woocommerce_currency_symbol', 'khutwa_change_currency_symbol', 10, 2);
function khutwa_change_currency_symbol($currency_symbol, $currency)
{
    if ($currency === 'MAD') {
        return 'DH';
    }
    return $currency_symbol;
}
/**
 * Translate and Simplify Checkout Labels
 */
add_filter('gettext', 'khutwa_translate_checkout_labels', 20, 3);
function khutwa_translate_checkout_labels($translated_text, $text, $domain)
{
    $upper_text = strtoupper(trim($text));
    $upper_text = str_replace(array('É', 'È', 'Ê', 'Ë'), 'E', $upper_text);

    switch ($upper_text) {
        case 'BILLING DETAILS':
        case 'INFORMATIONS DE LIVRAISON':
        case 'DELIVERY DETAILS':
            $translated_text = 'Delivery Information';
            break;
        case 'MODE DE PAIEMENT':
        case 'PAYMENT METHOD':
        case 'MODES DE PAIEMENT':
            $translated_text = 'Payment';
            break;
        case 'YOUR ORDER':
        case 'RECAPITULATIF':
        case 'VOTRE COMMANDE':
            $translated_text = 'Order Summary';
            break;
        case 'COMMANDER':
        case 'PLACE ORDER':
            $translated_text = 'Place Order';
            break;
    }
    return $translated_text;
}

/**
 * Register Widget Areas
 */
add_action('widgets_init', 'khutwa_widgets_init');
function khutwa_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'khutwa'),
        'id'            => 'sidebar-shop',
        'description'   => esc_html__('Add widgets here to appear in your shop and category sidebar.', 'khutwa'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}

/**
 * Filter for Fragment Refresh (Cart Count)
 */
add_filter('woocommerce_add_to_cart_fragments', 'khutwa_cart_count_fragments');
function khutwa_cart_count_fragments($fragments)
{
    ob_start();
?>
    <span class="cart-count badge bg-primary"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
<?php
    $fragments['span.cart-count'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_currency_symbol', 'change_my_currency_symbol', 10, 2);
function change_my_currency_symbol( $currency_symbol, $currency ) {
	return 'DH';
}