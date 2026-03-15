<?php
/**
 * Flatsome Child Theme — functions.php
 *
 * RULES:
 * - All project-specific PHP lives here or in /inc/ includes.
 * - NEVER modify the parent Flatsome theme directly.
 * - Keep each concern in its own include file.
 *
 * @package FlatSomeChild
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ─── Constants ───────────────────────────────────────────────────────────────

define( 'CHILD_THEME_VERSION', '1.0.0' );
define( 'CHILD_THEME_DIR',     get_stylesheet_directory() );
define( 'CHILD_THEME_URI',     get_stylesheet_directory_uri() );

// ─── Load child theme includes ───────────────────────────────────────────────

$includes = [
    '/inc/enqueue.php',
    '/inc/woocommerce.php',
    '/inc/bundles.php',
    '/inc/landing.php',
    '/inc/performance.php',
];

foreach ( $includes as $file ) {
    $path = CHILD_THEME_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
