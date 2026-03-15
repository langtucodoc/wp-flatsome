<?php
/**
 * WooCommerce customisations for landing page flow.
 *
 * Strategy: single variable product with 3 bundle variations.
 * The landing page drives add-to-cart → streamlined checkout.
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

// ─── Theme support ────────────────────────────────────────────────────────────

add_action( 'after_setup_theme', 'flatsome_child_woocommerce_setup' );

function flatsome_child_woocommerce_setup() {
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 900,
        'product_grid'          => [
            'default_rows'    => 1,
            'min_rows'        => 1,
            'max_rows'        => 1,
            'default_columns' => 1,
            'min_columns'     => 1,
            'max_columns'     => 1,
        ],
    ] );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

// ─── Remove unnecessary WooCommerce elements from landing page ────────────────

// Remove breadcrumbs on landing page template
add_action( 'template_redirect', 'flatsome_child_landing_wc_mods' );

function flatsome_child_landing_wc_mods() {
    if ( is_page_template( 'page-landing.php' ) ) {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    }
}

// ─── Streamlined checkout: remove unnecessary fields ─────────────────────────

/**
 * For Vietnamese direct sales, only Name + Phone + Address are truly required.
 * We keep email optional but present.
 */
add_filter( 'woocommerce_checkout_fields', 'flatsome_child_simplify_checkout_fields' );

function flatsome_child_simplify_checkout_fields( $fields ) {
    // Make company optional (hidden by default in Flatsome checkout settings)
    if ( isset( $fields['billing']['billing_company'] ) ) {
        $fields['billing']['billing_company']['required'] = false;
        $fields['billing']['billing_company']['class'][]  = 'hidden';
    }

    // Reorder fields for Vietnamese UX: Name → Phone → Address
    if ( isset( $fields['billing']['billing_last_name'] ) ) {
        $fields['billing']['billing_last_name']['priority'] = 10;
    }
    if ( isset( $fields['billing']['billing_first_name'] ) ) {
        $fields['billing']['billing_first_name']['priority'] = 11;
        $fields['billing']['billing_first_name']['label']    = 'Họ và Tên';
        $fields['billing']['billing_first_name']['placeholder'] = 'Nhập họ và tên đầy đủ';
    }
    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['priority']    = 12;
        $fields['billing']['billing_phone']['label']       = 'Số Điện Thoại';
        $fields['billing']['billing_phone']['placeholder'] = '0xxxxxxxxx';
    }
    if ( isset( $fields['billing']['billing_email'] ) ) {
        $fields['billing']['billing_email']['required']    = false;
        $fields['billing']['billing_email']['priority']    = 20;
        $fields['billing']['billing_email']['label']       = 'Email (không bắt buộc)';
    }

    // Vietnam-specific address customisations
    if ( isset( $fields['billing']['billing_address_1'] ) ) {
        $fields['billing']['billing_address_1']['label']       = 'Địa Chỉ';
        $fields['billing']['billing_address_1']['placeholder'] = 'Số nhà, tên đường, phường/xã';
        $fields['billing']['billing_address_1']['priority']    = 30;
    }
    if ( isset( $fields['billing']['billing_city'] ) ) {
        $fields['billing']['billing_city']['label']       = 'Quận / Huyện';
        $fields['billing']['billing_city']['priority']    = 40;
    }
    if ( isset( $fields['billing']['billing_state'] ) ) {
        $fields['billing']['billing_state']['label']      = 'Tỉnh / Thành Phố';
        $fields['billing']['billing_state']['priority']   = 50;
    }

    // Remove postcode (not commonly used in Vietnam)
    unset( $fields['billing']['billing_postcode'] );

    return $fields;
}

// ─── Order thank-you page — custom redirect ───────────────────────────────────

/**
 * After a successful order, redirect to custom thank-you page if set.
 */
add_action( 'woocommerce_thankyou', 'flatsome_child_custom_thankyou_redirect', 1 );

function flatsome_child_custom_thankyou_redirect( $order_id ) {
    $page_id = get_option( 'flatsome_child_thankyou_page_id' );
    if ( $page_id ) {
        wp_safe_redirect( add_query_arg( 'order_id', $order_id, get_permalink( $page_id ) ) );
        exit;
    }
}

// ─── Mini cart quantity update ────────────────────────────────────────────────

// Enable AJAX add-to-cart on product list
add_filter( 'woocommerce_loop_add_to_cart_link', 'flatsome_child_quantity_input_loop', 10, 2 );

// ─── Remove default WooCommerce product tabs (we use custom sections) ─────────

add_filter( 'woocommerce_product_tabs', 'flatsome_child_remove_product_tabs', 98 );

function flatsome_child_remove_product_tabs( $tabs ) {
    // On landing page template, we manage product details manually in UX Builder
    if ( is_page_template( 'page-landing.php' ) ) {
        unset( $tabs['description'] );
        unset( $tabs['additional_information'] );
        unset( $tabs['reviews'] );
    }
    return $tabs;
}

// ─── WooCommerce currency settings for VND ───────────────────────────────────

// Note: these are set via wp-admin > WooCommerce > Settings > General.
// These filters are a fallback in case options aren't set.
add_filter( 'woocommerce_currency',          fn() => 'VND' );
add_filter( 'woocommerce_currency_symbol',   fn( $s, $c ) => ( 'VND' === $c ) ? '₫' : $s, 10, 2 );
add_filter( 'woocommerce_price_format',      fn() => '%2$s %1$s' ); // "299,000 ₫"
add_filter( 'woocommerce_price_num_decimals', fn() => 0 );
add_filter( 'woocommerce_price_thousand_sep', fn() => ',' );
add_filter( 'woocommerce_price_decimal_sep',  fn() => '' );

// ─── Add custom order notes / confirmation message ────────────────────────────

add_filter( 'woocommerce_thankyou_order_received_text', 'flatsome_child_thankyou_text' );

function flatsome_child_thankyou_text( $text ) {
    return 'Cảm ơn bạn đã đặt hàng! Chúng tôi sẽ liên hệ xác nhận đơn hàng trong vòng 30 phút. 🎉';
}

// ─── Custom add-to-cart handler for bundle selection via landing page ─────────

add_action( 'wp_ajax_flatsome_add_bundle',        'flatsome_child_ajax_add_bundle' );
add_action( 'wp_ajax_nopriv_flatsome_add_bundle', 'flatsome_child_ajax_add_bundle' );

function flatsome_child_ajax_add_bundle() {
    check_ajax_referer( 'flatsome_child_nonce', 'nonce' );

    $product_id   = intval( $_POST['product_id']   ?? 0 );
    $variation_id = intval( $_POST['variation_id'] ?? 0 );
    $quantity     = intval( $_POST['quantity']      ?? 1 );

    if ( ! $product_id ) {
        wp_send_json_error( [ 'message' => 'ID sản phẩm không hợp lệ.' ] );
    }

    // Clear existing cart for single-product landing page flow
    WC()->cart->empty_cart();

    $added = WC()->cart->add_to_cart(
        $product_id,
        $quantity,
        $variation_id > 0 ? $variation_id : 0
    );

    if ( $added ) {
        wp_send_json_success( [
            'message'     => 'Thêm vào giỏ hàng thành công!',
            'cart_url'    => wc_get_cart_url(),
            'checkout_url'=> wc_get_checkout_url(),
            'redirect_url'=> wc_get_checkout_url(), // Go straight to checkout
        ] );
    } else {
        wp_send_json_error( [ 'message' => 'Không thể thêm sản phẩm. Vui lòng thử lại.' ] );
    }
}

// ─── Helper: get main product ID by slug ─────────────────────────────────────

function flatsome_child_get_main_product_id() {
    $product = get_page_by_path( 'binh-tra-tu-sa-long-phung', OBJECT, 'product' );
    return $product ? $product->ID : 0;
}

// ─── Schema.org Product markup (for SEO) ─────────────────────────────────────

add_action( 'wp_head', 'flatsome_child_product_schema' );

function flatsome_child_product_schema() {
    if ( ! is_page_template( 'page-landing.php' ) && ! is_front_page() ) {
        return;
    }

    $product_id = flatsome_child_get_main_product_id();
    if ( ! $product_id ) {
        return;
    }

    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        return;
    }

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $product->get_name(),
        'description' => wp_strip_all_tags( $product->get_description() ),
        'sku'         => $product->get_sku() ?: 'BTTS-001',
        'brand'       => [
            '@type' => 'Brand',
            'name'  => 'Bình Trà Tử Sa',
        ],
        'offers'      => [
            '@type'         => 'Offer',
            'priceCurrency' => 'VND',
            'price'         => $product->get_price(),
            'availability'  => $product->is_in_stock()
                                ? 'https://schema.org/InStock'
                                : 'https://schema.org/OutOfStock',
            'url'           => get_permalink( $product_id ),
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
