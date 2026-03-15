<?php
/**
 * Landing page helpers.
 *
 * - Sticky CTA bar
 * - Countdown timer support
 * - FAQ schema
 * - Body class additions
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

// ─── Body classes ─────────────────────────────────────────────────────────────

add_filter( 'body_class', 'flatsome_child_landing_body_class' );

function flatsome_child_landing_body_class( $classes ) {
    if ( is_page_template( 'page-landing.php' ) || is_front_page() ) {
        $classes[] = 'landing-page';
        $classes[] = 'single-product-landing';
    }
    return $classes;
}

// ─── Sticky CTA bar (mobile) ──────────────────────────────────────────────────

add_action( 'wp_footer', 'flatsome_child_sticky_cta_bar' );

function flatsome_child_sticky_cta_bar() {
    if ( ! is_page_template( 'page-landing.php' ) && ! is_front_page() ) {
        return;
    }
    ?>
    <div class="sticky-cta-bar js-sticky-cta" role="complementary" aria-label="Đặt hàng nhanh">
        <div class="sticky-cta-bar__inner">
            <div class="sticky-cta-bar__text">
                <span class="sticky-cta-bar__product">Bình Trà Tử Sa Long Phụng</span>
                <span class="sticky-cta-bar__price">Chỉ <strong>299.000₫</strong></span>
            </div>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
               class="sticky-cta-bar__btn btn-cta js-order-cta"
               data-bundle="bundle-1">
                Đặt Hàng Ngay
            </a>
        </div>
    </div>
    <?php
}

// ─── FAQ Schema (JSON-LD) ─────────────────────────────────────────────────────

add_action( 'wp_head', 'flatsome_child_faq_schema' );

function flatsome_child_faq_schema() {
    if ( ! is_page_template( 'page-landing.php' ) && ! is_front_page() ) {
        return;
    }

    $faqs = [
        [
            'q' => 'Bình trà tử sa có thực sự đổi màu khi rót nước sôi không?',
            'a' => 'Có. Bình được làm từ đất tử sa đặc biệt có phản ứng với nhiệt. Khi rót nước nóng trên 45°C, màu sắc của bình sẽ thay đổi rõ rệt theo thiết kế Rồng Phượng. Hiệu ứng này hoàn toàn tự nhiên, an toàn và không ảnh hưởng đến chất lượng nước trà.',
        ],
        [
            'q' => 'Bình có an toàn khi tiếp xúc thực phẩm không?',
            'a' => 'Hoàn toàn an toàn. Bình được làm từ đất tử sa nguyên chất vùng Nghi Hưng, không pha tạp chất, không tráng men, không chứa chì hay kim loại nặng. Đây là vật liệu truyền thống được sử dụng hàng nghìn năm trong văn hóa trà Trung Hoa và Việt Nam.',
        ],
        [
            'q' => 'Dung tích bình là bao nhiêu? Phù hợp với mấy người?',
            'a' => 'Bình có dung tích 280ml, phù hợp để pha trà cho 2-3 người. Bộ bình bao gồm bình và chén theo mô tả trên trang.',
        ],
        [
            'q' => 'Thời gian giao hàng là bao lâu?',
            'a' => 'Nội thành Hà Nội và TP.HCM: 1-2 ngày làm việc. Các tỉnh thành khác: 2-4 ngày làm việc. Miễn phí vận chuyển cho đơn hàng từ 3 bộ.',
        ],
        [
            'q' => 'Tôi có thể đổi trả hàng không?',
            'a' => 'Chúng tôi nhận đổi trả trong vòng 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất hoặc vỡ trong quá trình vận chuyển. Vui lòng chụp ảnh và liên hệ hotline trong vòng 24 giờ sau khi nhận hàng.',
        ],
        [
            'q' => 'Bình trà tử sa phù hợp làm quà tặng không?',
            'a' => 'Rất phù hợp. Bình được đóng hộp quà cao cấp, thiết kế Rồng Phượng mang ý nghĩa tốt lành, phù hợp làm quà biếu dịp Tết, khai trương, sinh nhật, hay tặng người thân, đối tác.',
        ],
    ];

    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map( function( $faq ) {
            return [
                '@type'          => 'Question',
                'name'           => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['a'],
                ],
            ];
        }, $faqs ),
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

// ─── Remove landing page header elements ─────────────────────────────────────

add_action( 'wp', 'flatsome_child_landing_layout_mods' );

function flatsome_child_landing_layout_mods() {
    if ( ! is_page_template( 'page-landing.php' ) && ! is_front_page() ) {
        return;
    }
    // Keep header but simplify it. Flatsome handles this via Customizer.
    // remove_action( 'flatsome_header', 'flatsome_default_header' );
}

// ─── Countdown timer end date ─────────────────────────────────────────────────

add_action( 'wp_head', 'flatsome_child_countdown_meta' );

function flatsome_child_countdown_meta() {
    if ( ! is_page_template( 'page-landing.php' ) && ! is_front_page() ) {
        return;
    }
    // Rolling 3-day countdown — resets each time (creates urgency without expiring)
    $end_timestamp = strtotime( '+3 days' );
    echo '<meta name="flatsome-countdown-end" content="' . esc_attr( $end_timestamp * 1000 ) . '">' . "\n";
}
