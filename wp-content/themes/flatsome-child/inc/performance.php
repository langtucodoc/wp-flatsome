<?php
/**
 * Performance & security optimisations.
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

// ─── Remove WordPress bloat from head ────────────────────────────────────────

remove_action( 'wp_head', 'wp_generator' );             // WordPress version
remove_action( 'wp_head', 'wlwmanifest_link' );         // Windows Live Writer
remove_action( 'wp_head', 'rsd_link' );                 // Really Simple Discovery
remove_action( 'wp_head', 'wp_shortlink_wp_head' );     // Short link tag

// Remove REST API links (not needed on front-end)
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// ─── Disable emojis (saves 2 HTTP requests) ──────────────────────────────────

remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );
remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );

// ─── Security headers ─────────────────────────────────────────────────────────

add_action( 'send_headers', 'flatsome_child_security_headers' );

function flatsome_child_security_headers() {
    if ( ! is_admin() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
        header( 'Permissions-Policy: geolocation=(), microphone=(), camera=()' );
    }
}

// ─── Spam protection for WooCommerce checkout ────────────────────────────────

/**
 * Simple honeypot field added to checkout to catch bots.
 * Bots typically fill in all fields; humans leave honeypot blank.
 */
add_action( 'woocommerce_after_checkout_billing_form', 'flatsome_child_checkout_honeypot_field' );

function flatsome_child_checkout_honeypot_field() {
    echo '<div style="display:none !important;" aria-hidden="true">';
    woocommerce_form_field(
        'hp_website',
        [
            'type'  => 'text',
            'label' => 'Website',
            'class' => ['hp-field'],
        ]
    );
    echo '</div>';
}

add_action( 'woocommerce_checkout_process', 'flatsome_child_checkout_honeypot_check' );

function flatsome_child_checkout_honeypot_check() {
    if ( ! empty( $_POST['hp_website'] ) ) {
        wc_add_notice( 'Đặt hàng không thành công. Vui lòng thử lại.', 'error' );
    }
}

// ─── Limit login attempts (basic) ────────────────────────────────────────────

// NOTE: For production, use the "Limit Login Attempts Reloaded" plugin instead.
// This is just a basic transient-based limiter as a fallback.

add_filter( 'authenticate', 'flatsome_child_limit_login', 30, 3 );

function flatsome_child_limit_login( $user, $username, $password ) {
    if ( empty( $username ) ) {
        return $user;
    }

    $ip_key  = 'login_fail_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' );
    $fails   = (int) get_transient( $ip_key );
    $max     = 5;

    if ( $fails >= $max ) {
        return new WP_Error(
            'too_many_attempts',
            '<strong>Lỗi:</strong> Quá nhiều lần đăng nhập thất bại. Vui lòng thử lại sau 15 phút.'
        );
    }

    return $user;
}

add_action( 'wp_login_failed', 'flatsome_child_track_login_fail' );

function flatsome_child_track_login_fail( $username ) {
    $ip_key = 'login_fail_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' );
    $fails  = (int) get_transient( $ip_key );
    set_transient( $ip_key, $fails + 1, 15 * MINUTE_IN_SECONDS );
}

// ─── Disable XML-RPC (commonly exploited, not needed on landing page) ─────────

add_filter( 'xmlrpc_enabled', '__return_false' );

// ─── Cache buster for assets in development ───────────────────────────────────

if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    add_filter( 'script_loader_src', 'flatsome_child_dev_cache_bust' );
    add_filter( 'style_loader_src',  'flatsome_child_dev_cache_bust' );

    function flatsome_child_dev_cache_bust( $src ) {
        if ( str_contains( $src, CHILD_THEME_URI ) ) {
            $src = add_query_arg( 'dev', time(), $src );
        }
        return $src;
    }
}
