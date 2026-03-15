<?php
/**
 * Bundle pricing logic for Bình Trà Tử Sa landing page.
 *
 * Bundle structure:
 *   Variation 1 — 1 bộ  → 299,000 VND
 *   Variation 2 — 2 bộ  → 579,000 VND  (save 19,000)
 *   Variation 3 — 3 bộ  → 870,000 VND  (save 27,000 + free ship)
 *
 * Implementation: WooCommerce Variable Product with attribute "Số Lượng".
 * Each variation has a fixed price defined on the variation.
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bundle definitions — single source of truth.
 * UI and AJAX handlers both reference this.
 *
 * @return array[]
 */
function flatsome_child_get_bundles() {
    $product_id = flatsome_child_get_main_product_id();

    return [
        [
            'id'            => 'bundle-1',
            'label'         => '1 Bộ',
            'quantity'      => 1,
            'price'         => 299000,
            'old_price'     => 450000,
            'badge'         => '',
            'note'          => 'Phù hợp cho dùng cá nhân',
            'free_ship'     => false,
            'product_id'    => $product_id,
            'variation_id'  => 0,  // set after import
            'popular'       => false,
        ],
        [
            'id'            => 'bundle-2',
            'label'         => '2 Bộ',
            'quantity'      => 2,
            'price'         => 579000,
            'old_price'     => 900000,
            'badge'         => 'Tiết kiệm',
            'note'          => 'Dùng tặng quà hoặc 2 người',
            'free_ship'     => false,
            'product_id'    => $product_id,
            'variation_id'  => 0,
            'popular'       => true,
        ],
        [
            'id'            => 'bundle-3',
            'label'         => '3 Bộ',
            'quantity'      => 3,
            'price'         => 870000,
            'old_price'     => 1350000,
            'badge'         => 'Miễn phí ship',
            'note'          => 'Mua nhiều hơn — tiết kiệm hơn',
            'free_ship'     => true,
            'product_id'    => $product_id,
            'variation_id'  => 0,
            'popular'       => false,
        ],
    ];
}

/**
 * Render the bundle pricing cards HTML.
 * Called from page-landing.php or shortcode.
 *
 * @param bool $echo Whether to echo or return.
 * @return string
 */
function flatsome_child_render_bundles( $echo = true ) {
    $bundles = flatsome_child_get_bundles();
    $nonce   = wp_create_nonce( 'flatsome_child_nonce' );

    ob_start();
    ?>
    <div class="bundle-pricing-grid" data-nonce="<?php echo esc_attr( $nonce ); ?>">
        <?php foreach ( $bundles as $bundle ) : ?>
        <div class="bundle-card <?php echo $bundle['popular'] ? 'bundle-card--popular' : ''; ?>"
             data-bundle-id="<?php echo esc_attr( $bundle['id'] ); ?>"
             data-product-id="<?php echo esc_attr( $bundle['product_id'] ); ?>"
             data-variation-id="<?php echo esc_attr( $bundle['variation_id'] ); ?>"
             data-quantity="<?php echo esc_attr( $bundle['quantity'] ); ?>">

            <?php if ( $bundle['popular'] ) : ?>
                <div class="bundle-card__popular-label">PHỔ BIẾN NHẤT</div>
            <?php endif; ?>

            <?php if ( $bundle['badge'] ) : ?>
                <div class="bundle-card__badge"><?php echo esc_html( $bundle['badge'] ); ?></div>
            <?php endif; ?>

            <div class="bundle-card__label"><?php echo esc_html( $bundle['label'] ); ?></div>

            <div class="bundle-card__pricing">
                <span class="bundle-card__price">
                    <?php echo number_format( $bundle['price'], 0, '', ',' ); ?>₫
                </span>
                <span class="bundle-card__old-price">
                    <?php echo number_format( $bundle['old_price'], 0, '', ',' ); ?>₫
                </span>
            </div>

            <div class="bundle-card__note"><?php echo esc_html( $bundle['note'] ); ?></div>

            <?php if ( $bundle['free_ship'] ) : ?>
                <div class="bundle-card__freeship">
                    <span class="dashicons dashicons-car"></span> Miễn phí vận chuyển
                </div>
            <?php endif; ?>

            <button class="bundle-card__cta btn-cta js-bundle-select"
                    type="button"
                    data-bundle="<?php echo esc_attr( wp_json_encode( $bundle ) ); ?>">
                Chọn Gói Này
            </button>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
    $html = ob_get_clean();

    if ( $echo ) {
        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    return $html;
}

/**
 * Register [bundle_pricing] shortcode so it can be used inside UX Builder
 * via a "Raw HTML" or "Shortcode" widget.
 */
add_shortcode( 'bundle_pricing', function() {
    return flatsome_child_render_bundles( false );
} );

/**
 * Register [order_cta label="..." bundle="bundle-1"] shortcode.
 */
add_shortcode( 'order_cta', function( $atts ) {
    $atts = shortcode_atts(
        [
            'label'  => 'Đặt Hàng Ngay',
            'bundle' => 'bundle-1',
            'class'  => '',
        ],
        $atts,
        'order_cta'
    );

    $checkout_url = wc_get_checkout_url();

    return sprintf(
        '<a href="%s" class="btn-cta btn-cta--full js-order-cta %s" data-bundle="%s">%s</a>',
        esc_url( $checkout_url ),
        esc_attr( $atts['class'] ),
        esc_attr( $atts['bundle'] ),
        esc_html( $atts['label'] )
    );
} );
