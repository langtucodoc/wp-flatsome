<?php
/**
 * Asset enqueueing — scripts & styles.
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue child theme stylesheet (inherits parent Flatsome styles automatically
 * because WordPress loads child style.css after parent via the theme loader).
 *
 * Also enqueue project-specific CSS and JS.
 */
add_action( 'wp_enqueue_scripts', 'flatsome_child_enqueue_assets' );

function flatsome_child_enqueue_assets() {

    // 1. Parent theme stylesheet — Flatsome handles this itself, but we
    //    explicitly enqueue child style with parent as dependency.
    wp_enqueue_style(
        'flatsome-child-style',
        get_stylesheet_uri(),
        [ 'flatsome-style' ],
        CHILD_THEME_VERSION
    );

    // 2. Landing page styles (only on the landing page template)
    if ( is_page_template( 'page-landing.php' ) || is_front_page() ) {
        wp_enqueue_style(
            'flatsome-child-landing',
            CHILD_THEME_URI . '/assets/css/landing.css',
            [ 'flatsome-child-style' ],
            CHILD_THEME_VERSION
        );

        wp_enqueue_style(
            'flatsome-child-woocommerce-landing',
            CHILD_THEME_URI . '/assets/css/woocommerce.css',
            [ 'flatsome-child-landing' ],
            CHILD_THEME_VERSION
        );
    }

    // 3. WooCommerce custom styles on all shop/product/cart/checkout pages
    if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
        wp_enqueue_style(
            'flatsome-child-woocommerce',
            CHILD_THEME_URI . '/assets/css/woocommerce.css',
            [ 'flatsome-child-style' ],
            CHILD_THEME_VERSION
        );
    }

    // 4. Landing page JS
    if ( is_page_template( 'page-landing.php' ) || is_front_page() ) {
        wp_enqueue_script(
            'flatsome-child-countdown',
            CHILD_THEME_URI . '/assets/js/countdown.js',
            [],
            CHILD_THEME_VERSION,
            true  // load in footer
        );

        wp_enqueue_script(
            'flatsome-child-landing',
            CHILD_THEME_URI . '/assets/js/landing.js',
            [ 'jquery', 'flatsome-child-countdown' ],
            CHILD_THEME_VERSION,
            true
        );

        // Pass PHP data to JS
        wp_localize_script(
            'flatsome-child-landing',
            'flatsomeChildConfig',
            [
                'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
                'nonce'      => wp_create_nonce( 'flatsome_child_nonce' ),
                'currency'   => get_woocommerce_currency_symbol(),
                'siteUrl'    => get_site_url(),
                'checkoutUrl'=> wc_get_checkout_url(),
                'cartUrl'    => wc_get_cart_url(),
                'productId'  => flatsome_child_get_main_product_id(),
            ]
        );
    }

    // 5. Google Fonts — Be Vietnam Pro (Vietnamese-optimised)
    wp_enqueue_style(
        'flatsome-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap',
        [],
        null
    );
}

/**
 * Enqueue admin styles for custom WooCommerce order admin tweaks.
 */
add_action( 'admin_enqueue_scripts', 'flatsome_child_admin_assets' );

function flatsome_child_admin_assets( $hook ) {
    if ( in_array( $hook, [ 'post.php', 'post-new.php', 'edit.php' ] ) ) {
        wp_enqueue_style(
            'flatsome-child-admin',
            CHILD_THEME_URI . '/assets/css/admin.css',
            [],
            CHILD_THEME_VERSION
        );
    }
}
