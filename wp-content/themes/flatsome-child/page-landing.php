<?php
/**
 * Template Name: Landing Page — Bình Trà Tử Sa
 * Template Post Type: page
 *
 * Custom full-width landing page for single product sales.
 * Bypasses Flatsome's standard page layout to deliver a
 * conversion-focused, distraction-free sales experience.
 *
 * STRUCTURE:
 *  1. Urgency bar (countdown)
 *  2. Hero section
 *  3. Trust badges
 *  4. USP (unique selling points)
 *  5. Product features
 *  6. Product specs table
 *  7. Video demo
 *  8. Bundle pricing
 *  9. Testimonials
 * 10. FAQ
 * 11. Contact / footer CTA
 *
 * @package FlatSomeChild
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- ============================================================
     1. URGENCY BAR
     ============================================================ -->
<div class="urgency-bar" role="alert" aria-live="polite">
    <strong>⚡ KHUYẾN MÃI ĐẶC BIỆT!</strong>
    Ưu đãi kết thúc sau:
    <span class="countdown-timer js-countdown" aria-label="Đếm ngược khuyến mãi">
        <span class="countdown-unit" data-countdown="days">00</span>
        <span class="countdown-sep">ngày</span>
        <span class="countdown-unit" data-countdown="hours">00</span>
        <span class="countdown-sep">:</span>
        <span class="countdown-unit" data-countdown="minutes">00</span>
        <span class="countdown-sep">:</span>
        <span class="countdown-unit" data-countdown="seconds">00</span>
    </span>
    &nbsp;— Tiết kiệm đến <strong>34%</strong> so với giá gốc!
</div>

<!-- ============================================================
     2. HERO SECTION
     ============================================================ -->
<section class="hero-section" id="hero" aria-label="Giới thiệu sản phẩm">
    <div class="container">
        <div class="row align-items-center">
            <!-- Hero copy -->
            <div class="col large-6 medium-6 small-12">
                <p class="hero-tagline">🏺 Đặc sản Tử Sa · Nghi Hưng Truyền Thống</p>
                <h1>
                    <em>Bình Trà Tử Sa Long Phụng</em><br>
                    Đổi Màu Kỳ Diệu Khi Rót Nước Sôi
                </h1>
                <p class="hero-subtitle">
                    Làm từ đất tử sa nguyên chất vùng Nghi Hưng — bình thay đổi màu sắc khi tiếp xúc nhiệt,
                    mang lại trải nghiệm pha trà độc đáo và sang trọng. Phù hợp dùng hàng ngày, làm quà tặng
                    cao cấp, và trưng bày phong thủy.
                </p>

                <div class="hero-price-wrapper" aria-label="Giá sản phẩm">
                    <span class="hero-price">299.000₫</span>
                    <span class="hero-price-old">450.000₫</span>
                    <span class="hero-badge">–34%</span>
                </div>

                <div class="hero-cta-group">
                    <a href="#bundle-pricing"
                       class="btn-cta btn-cta--pulse js-order-cta"
                       aria-label="Đặt hàng ngay">
                        🛒 Đặt Hàng Ngay
                    </a>
                    <a href="#video-demo"
                       class="button white outline js-order-cta"
                       aria-label="Xem video trình diễn">
                        ▶ Xem Video
                    </a>
                </div>

                <div class="hero-trust-row" role="list" aria-label="Cam kết">
                    <span role="listitem">
                        <span class="dashicons dashicons-shield-alt" aria-hidden="true"></span>
                        Hàng chính hãng
                    </span>
                    <span role="listitem">
                        <span class="dashicons dashicons-update" aria-hidden="true"></span>
                        Đổi trả 7 ngày
                    </span>
                    <span role="listitem">
                        <span class="dashicons dashicons-location" aria-hidden="true"></span>
                        Ship toàn quốc
                    </span>
                    <span role="listitem">
                        <span class="dashicons dashicons-phone" aria-hidden="true"></span>
                        CSKH 24/7
                    </span>
                </div>
            </div>

            <!-- Hero product image -->
            <div class="col large-6 medium-6 small-12">
                <div class="hero-image-wrap">
                    <?php
                    $product_id  = flatsome_child_get_main_product_id();
                    $thumbnail   = $product_id ? get_the_post_thumbnail_url( $product_id, 'large' ) : '';
                    $fallback    = CHILD_THEME_URI . '/assets/images/product-hero.png';
                    $img_src     = $thumbnail ?: $fallback;
                    ?>
                    <img src="<?php echo esc_url( $img_src ); ?>"
                         alt="Bình Trà Tử Sa Long Phụng — sản phẩm chính"
                         width="520"
                         height="520"
                         loading="eager"
                         fetchpriority="high"
                    />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     3. TRUST BADGES
     ============================================================ -->
<section class="trust-badges-section" aria-label="Cam kết chất lượng">
    <div class="container">
        <ul class="trust-badges-grid" role="list">
            <li class="trust-badge-item" role="listitem">
                <div class="trust-icon" aria-hidden="true">✓</div>
                <span>Đất tử sa chính hãng Nghi Hưng</span>
            </li>
            <li class="trust-badge-item" role="listitem">
                <div class="trust-icon" aria-hidden="true">🔥</div>
                <span>Đổi màu khi rót nước sôi</span>
            </li>
            <li class="trust-badge-item" role="listitem">
                <div class="trust-icon" aria-hidden="true">🎁</div>
                <span>Hộp quà cao cấp</span>
            </li>
            <li class="trust-badge-item" role="listitem">
                <div class="trust-icon" aria-hidden="true">🚚</div>
                <span>Miễn phí ship đơn 3 bộ</span>
            </li>
            <li class="trust-badge-item" role="listitem">
                <div class="trust-icon" aria-hidden="true">🔄</div>
                <span>Đổi trả 7 ngày không hỏi</span>
            </li>
        </ul>
    </div>
</section>

<!-- ============================================================
     4. UNIQUE SELLING POINTS
     ============================================================ -->
<section class="usp-section" id="features" aria-labelledby="usp-title">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Tại Sao Chọn Chúng Tôi</span>
            <h2 class="section-title" id="usp-title">Khác Biệt Tạo Nên Đẳng Cấp</h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <div class="usp-grid" role="list">
            <div class="usp-card fade-in-up" role="listitem">
                <div class="usp-card__icon" aria-hidden="true">🏺</div>
                <h3 class="usp-card__title">Đất Tử Sa Nguyên Chất</h3>
                <p class="usp-card__desc">
                    Khai thác trực tiếp từ mỏ đất tử sa vùng Nghi Hưng — Trung Quốc.
                    Không pha tạp chất, không tráng men, giữ nguyên giá trị tự nhiên.
                </p>
            </div>
            <div class="usp-card fade-in-up" role="listitem">
                <div class="usp-card__icon" aria-hidden="true">🌡️</div>
                <h3 class="usp-card__title">Đổi Màu Kỳ Diệu</h3>
                <p class="usp-card__desc">
                    Bình chuyển đổi màu sắc rõ rệt khi tiếp xúc với nước nóng trên 45°C.
                    Hiệu ứng độc đáo, ấn tượng với mọi khách mời.
                </p>
            </div>
            <div class="usp-card fade-in-up" role="listitem">
                <div class="usp-card__icon" aria-hidden="true">🐉</div>
                <h3 class="usp-card__title">Họa Tiết Long Phụng</h3>
                <p class="usp-card__desc">
                    Họa tiết Rồng Phượng thủ công, tượng trưng cho thịnh vượng, hạnh phúc và
                    may mắn trong văn hóa phương Đông.
                </p>
            </div>
            <div class="usp-card fade-in-up" role="listitem">
                <div class="usp-card__icon" aria-hidden="true">🎁</div>
                <h3 class="usp-card__title">Quà Tặng Sang Trọng</h3>
                <p class="usp-card__desc">
                    Đóng hộp quà sang trọng, thích hợp làm quà Tết, khai trương, sinh nhật,
                    hay tặng đối tác, cấp trên.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     5. PRODUCT FEATURES
     ============================================================ -->
<section class="features-section" id="product-detail" aria-labelledby="features-title">
    <div class="container">
        <div class="row align-items-center">
            <div class="col large-5 medium-5 small-12">
                <div class="section-header" style="text-align:left;">
                    <span class="section-tag">Chi Tiết Sản Phẩm</span>
                    <h2 class="section-title" id="features-title">
                        Vì Sao Bình Tử Sa Long Phụng<br>Được Yêu Thích?
                    </h2>
                    <div class="section-divider" style="margin-left:0;" aria-hidden="true"></div>
                </div>

                <?php
                // Use product gallery images if available
                $product_id = flatsome_child_get_main_product_id();
                if ( $product_id ) {
                    $gallery_ids = get_post_meta( $product_id, '_product_image_gallery', true );
                    $gallery_ids = array_filter( explode( ',', $gallery_ids ) );
                    if ( ! empty( $gallery_ids ) ) {
                        $img_url = wp_get_attachment_image_url( $gallery_ids[0], 'medium_large' );
                        if ( $img_url ) {
                            echo '<img src="' . esc_url( $img_url ) . '" alt="Chi tiết bình trà" class="features-detail-img" style="border-radius:16px;width:100%;height:auto;margin-top:32px;" loading="lazy">';
                        }
                    }
                }
                ?>
            </div>
            <div class="col large-7 medium-7 small-12">
                <ul class="features-list" role="list">
                    <li class="feature-item fade-in-up" role="listitem">
                        <div class="feature-item__num" aria-hidden="true">01</div>
                        <div class="feature-item__content">
                            <h3>Chất Liệu Đất Tử Sa Nghi Hưng</h3>
                            <p>
                                Đất tử sa Nghi Hưng nổi tiếng với khả năng lưu giữ hương vị trà,
                                điều chỉnh nhiệt độ tốt và kháng khuẩn tự nhiên. Bình tử sa càng dùng
                                càng bóng đẹp — hiện tượng "dưỡng bình" trong văn hóa trà Á Đông.
                            </p>
                        </div>
                    </li>
                    <li class="feature-item fade-in-up" role="listitem">
                        <div class="feature-item__num" aria-hidden="true">02</div>
                        <div class="feature-item__content">
                            <h3>Hiệu Ứng Đổi Màu Nhiệt</h3>
                            <p>
                                Khi rót nước nóng trên 45°C vào bình, màu sắc chuyển đổi rõ nét.
                                Hiệu ứng 100% tự nhiên từ thành phần khoáng chất đặc biệt trong đất.
                                Không sơn, không hóa chất, hoàn toàn an toàn cho thực phẩm.
                            </p>
                        </div>
                    </li>
                    <li class="feature-item fade-in-up" role="listitem">
                        <div class="feature-item__num" aria-hidden="true">03</div>
                        <div class="feature-item__content">
                            <h3>Thủ Công Từng Chi Tiết</h3>
                            <p>
                                Mỗi bình được tạo hình thủ công bởi nghệ nhân lành nghề.
                                Họa tiết Rồng Phụng khắc tỉ mỉ, sắc nét — không có hai bình
                                nào hoàn toàn giống nhau, tạo nên tính độc bản.
                            </p>
                        </div>
                    </li>
                    <li class="feature-item fade-in-up" role="listitem">
                        <div class="feature-item__num" aria-hidden="true">04</div>
                        <div class="feature-item__content">
                            <h3>An Toàn Thực Phẩm & Sức Khỏe</h3>
                            <p>
                                Không tráng men, không pha chì, không kim loại nặng.
                                Kiểm định an toàn thực phẩm theo tiêu chuẩn Việt Nam.
                                Phù hợp sử dụng hàng ngày cho cả gia đình.
                            </p>
                        </div>
                    </li>
                    <li class="feature-item fade-in-up" role="listitem">
                        <div class="feature-item__num" aria-hidden="true">05</div>
                        <div class="feature-item__content">
                            <h3>Ý Nghĩa Phong Thủy & Văn Hóa</h3>
                            <p>
                                Long Phụng — Rồng và Phượng hoàng — biểu tượng cho sự hòa hợp,
                                thịnh vượng và hạnh phúc gia đình. Là món quà ý nghĩa mang
                                lại may mắn và tài lộc cho người nhận.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     6. PRODUCT SPECIFICATIONS
     ============================================================ -->
<section class="specs-section" id="specs" aria-labelledby="specs-title">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Thông Số Kỹ Thuật</span>
            <h2 class="section-title" id="specs-title">Thông Số Sản Phẩm</h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <div style="max-width:720px;margin:40px auto 0;">
            <table class="specs-table" role="table" aria-label="Thông số kỹ thuật bình trà">
                <tbody>
                    <tr>
                        <th scope="row">Chất liệu</th>
                        <td>Đất tử sa nguyên chất vùng Nghi Hưng</td>
                    </tr>
                    <tr>
                        <th scope="row">Kích thước bình</th>
                        <td>8.5cm × 11cm</td>
                    </tr>
                    <tr>
                        <th scope="row">Kích thước chén</th>
                        <td>3cm × 5.6cm</td>
                    </tr>
                    <tr>
                        <th scope="row">Dung tích</th>
                        <td>280ml</td>
                    </tr>
                    <tr>
                        <th scope="row">Màu sắc</th>
                        <td>Đổi màu khi nhiệt độ &gt; 45°C</td>
                    </tr>
                    <tr>
                        <th scope="row">Họa tiết</th>
                        <td>Rồng Phụng (Long Phụng) — khắc thủ công</td>
                    </tr>
                    <tr>
                        <th scope="row">Xuất xứ</th>
                        <td>Nghi Hưng, Giang Tô, Trung Quốc</td>
                    </tr>
                    <tr>
                        <th scope="row">An toàn</th>
                        <td>Không tráng men · An toàn thực phẩm · Không chì</td>
                    </tr>
                    <tr>
                        <th scope="row">Đóng gói</th>
                        <td>Hộp quà cao cấp kèm túi giấy</td>
                    </tr>
                    <tr>
                        <th scope="row">Bảo hành</th>
                        <td>Đổi trả 7 ngày nếu lỗi sản xuất</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ============================================================
     7. VIDEO DEMO
     ============================================================ -->
<section class="video-section" id="video-demo" aria-labelledby="video-title">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title" id="video-title" style="color:#D4AF37;">
                Xem Hiệu Ứng Đổi Màu Kỳ Diệu
            </h2>
            <p class="section-subtitle">
                Video thực tế — không chỉnh sửa, không lọc màu. Bạn sẽ thấy sự thay đổi ngay lập tức!
            </p>
        </div>

        <div class="video-embed-wrap" aria-label="Video trình diễn bình trà đổi màu">
            <!--
                YouTube Shorts embed. Replace src with actual video URL.
                Original reference: https://youtube.com/shorts/6mDIR3_3sLQ
            -->
            <iframe
                src="https://www.youtube.com/embed/6mDIR3_3sLQ"
                title="Bình Trà Tử Sa Long Phụng — Hiệu Ứng Đổi Màu"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </div>

        <div style="margin-top:40px;text-align:center;">
            <a href="#bundle-pricing" class="btn-cta js-order-cta btn-cta--pulse">
                🛒 Tôi Muốn Mua Ngay
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     8. BUNDLE PRICING
     ============================================================ -->
<section class="bundle-pricing-section" id="bundle-pricing" aria-labelledby="bundle-title">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Chọn Gói Phù Hợp</span>
            <h2 class="section-title" id="bundle-title">
                Giá Ưu Đãi — Mua Nhiều Tiết Kiệm Hơn
            </h2>
            <p class="section-subtitle">
                Khuyến mãi có thời hạn. Đặt ngay để nhận mức giá tốt nhất hôm nay.
            </p>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <?php flatsome_child_render_bundles(); ?>

        <p style="text-align:center;margin-top:24px;font-size:13px;color:#888;">
            🔒 Thanh toán khi nhận hàng (COD) · 🚚 Giao toàn quốc · ↩ Đổi trả 7 ngày
        </p>
    </div>
</section>

<!-- ============================================================
     9. TESTIMONIALS
     ============================================================ -->
<section class="testimonials-section" id="reviews" aria-labelledby="reviews-title">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Khách Hàng Nói Gì</span>
            <h2 class="section-title" id="reviews-title">Đánh Giá Từ Khách Hàng Thực Tế</h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <div class="testimonials-grid" role="list">
            <article class="testimonial-card fade-in-up" role="listitem">
                <div class="testimonial-card__stars" aria-label="5 sao">★★★★★</div>
                <p class="testimonial-card__text">
                    "Mua về làm quà sinh nhật cho chồng, anh ấy thích lắm! Cái bình rót nước vào
                    đổi màu đẹp lắm. Hộp quà đóng rất sang. Sẽ quay lại mua thêm để tặng sếp nhân
                    dịp cuối năm."
                </p>
                <div class="testimonial-card__author">
                    <div class="testimonial-card__avatar" aria-hidden="true">M</div>
                    <div>
                        <div class="testimonial-card__name">Minh Thư</div>
                        <div class="testimonial-card__location">Hà Nội · Đã mua 2 bộ</div>
                    </div>
                </div>
            </article>

            <article class="testimonial-card fade-in-up" role="listitem">
                <div class="testimonial-card__stars" aria-label="5 sao">★★★★★</div>
                <p class="testimonial-card__text">
                    "Tôi hay uống trà mỗi sáng. Bình này giữ nóng tốt hơn bình thường. Cái hay nhất
                    là hiệu ứng đổi màu — đẹp và độc đáo. Giao hàng nhanh, đóng gói kỹ, không bị vỡ."
                </p>
                <div class="testimonial-card__author">
                    <div class="testimonial-card__avatar" aria-hidden="true">T</div>
                    <div>
                        <div class="testimonial-card__name">Tuấn Anh</div>
                        <div class="testimonial-card__location">TP. Hồ Chí Minh · Đã mua 1 bộ</div>
                    </div>
                </div>
            </article>

            <article class="testimonial-card fade-in-up" role="listitem">
                <div class="testimonial-card__stars" aria-label="5 sao">★★★★★</div>
                <p class="testimonial-card__text">
                    "Mua 3 bộ để tặng đối tác kinh doanh dịp Tết. Được miễn phí vận chuyển, bình
                    đẹp hơn trong hình rất nhiều. Họa tiết Rồng Phượng tinh xảo. Rất hài lòng!"
                </p>
                <div class="testimonial-card__author">
                    <div class="testimonial-card__avatar" aria-hidden="true">H</div>
                    <div>
                        <div class="testimonial-card__name">Hoàng Lan</div>
                        <div class="testimonial-card__location">Đà Nẵng · Đã mua 3 bộ</div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ============================================================
     10. FAQ
     ============================================================ -->
<section class="faq-section" id="faq" aria-labelledby="faq-title">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Câu Hỏi Thường Gặp</span>
            <h2 class="section-title" id="faq-title">Giải Đáp Thắc Mắc</h2>
            <div class="section-divider" aria-hidden="true"></div>
        </div>

        <ul class="faq-list" role="list">
            <?php
            $faqs = [
                [
                    'q' => 'Bình trà tử sa có thực sự đổi màu khi rót nước sôi không?',
                    'a' => 'Có. Bình được làm từ đất tử sa đặc biệt có phản ứng với nhiệt. Khi rót nước nóng trên 45°C, màu sắc của bình sẽ thay đổi rõ rệt theo thiết kế Rồng Phượng. Hiệu ứng này hoàn toàn tự nhiên, an toàn và không ảnh hưởng đến chất lượng nước trà.',
                ],
                [
                    'q' => 'Bình có an toàn khi tiếp xúc thực phẩm không?',
                    'a' => 'Hoàn toàn an toàn. Bình được làm từ đất tử sa nguyên chất, không tráng men, không chứa chì hay kim loại nặng. Đây là vật liệu truyền thống được sử dụng hàng nghìn năm trong văn hóa trà Á Đông và đã được kiểm định an toàn thực phẩm.',
                ],
                [
                    'q' => 'Dung tích bình là bao nhiêu? Phù hợp với mấy người?',
                    'a' => 'Bình có dung tích 280ml, phù hợp để pha trà cho 2-3 người. Mỗi bộ bao gồm bình và chén trà đồng bộ.',
                ],
                [
                    'q' => 'Thời gian giao hàng là bao lâu?',
                    'a' => 'Nội thành Hà Nội và TP.HCM: 1-2 ngày làm việc. Các tỉnh thành khác: 2-4 ngày làm việc. Miễn phí vận chuyển khi đặt từ 3 bộ trở lên.',
                ],
                [
                    'q' => 'Tôi có thể đổi trả hàng không?',
                    'a' => 'Chúng tôi nhận đổi trả trong vòng 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất hoặc vỡ trong quá trình vận chuyển. Vui lòng chụp ảnh sản phẩm và liên hệ hotline trong vòng 24 giờ sau khi nhận hàng để được hỗ trợ nhanh nhất.',
                ],
                [
                    'q' => 'Hình thức thanh toán là gì?',
                    'a' => 'Chúng tôi hỗ trợ thanh toán khi nhận hàng (COD) trên toàn quốc — bạn chỉ trả tiền khi đã nhận và kiểm tra hàng. Ngoài ra còn hỗ trợ chuyển khoản ngân hàng và thanh toán qua VNPay.',
                ],
            ];
            foreach ( $faqs as $i => $faq ) :
                $item_id = 'faq-' . ( $i + 1 );
            ?>
            <li class="faq-item<?php echo $i === 0 ? ' is-open' : ''; ?>" role="listitem">
                <button
                    class="faq-item__question"
                    aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo esc_attr( $item_id ); ?>"
                    id="<?php echo esc_attr( $item_id . '-btn' ); ?>">
                    <?php echo esc_html( $faq['q'] ); ?>
                </button>
                <div
                    class="faq-item__answer"
                    id="<?php echo esc_attr( $item_id ); ?>"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $item_id . '-btn' ); ?>">
                    <p><?php echo esc_html( $faq['a'] ); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ============================================================
     11. CONTACT / FOOTER CTA
     ============================================================ -->
<section class="contact-section" id="contact" aria-labelledby="contact-title">
    <div class="container">
        <h2 id="contact-title">Sẵn Sàng Đặt Hàng?</h2>
        <p class="contact-subtitle">
            Liên hệ ngay nếu bạn cần tư vấn. Đội ngũ CSKH luôn sẵn sàng hỗ trợ.
        </p>

        <div class="contact-info-grid" role="list">
            <div class="contact-info-item" role="listitem">
                <div class="contact-icon" aria-hidden="true">📍</div>
                <span>987 Tam Trinh, Hoàng Mai, Hà Nội</span>
            </div>
            <div class="contact-info-item" role="listitem">
                <div class="contact-icon" aria-hidden="true">📧</div>
                <a href="mailto:info@giadungnhapkhau.com" style="color:rgba(255,255,255,.85);">
                    info@giadungnhapkhau.com
                </a>
            </div>
            <div class="contact-info-item" role="listitem">
                <div class="contact-icon" aria-hidden="true">🌐</div>
                <a href="https://www.giadungnhapkhau.com" style="color:rgba(255,255,255,.85);" target="_blank" rel="noopener">
                    www.giadungnhapkhau.com
                </a>
            </div>
        </div>

        <a href="#bundle-pricing"
           class="btn-cta btn-cta--pulse js-order-cta"
           style="font-size:20px;padding:20px 60px;"
           aria-label="Đặt hàng ngay">
            🛒 Đặt Hàng Ngay — Chỉ 299.000₫
        </a>

        <p style="margin-top:16px;font-size:13px;color:rgba(255,255,255,.5);">
            Thanh toán khi nhận hàng · Giao toàn quốc · Đổi trả 7 ngày
        </p>
    </div>
</section>

<!-- Sticky CTA Bar is injected by landing.php via wp_footer hook -->

<?php get_footer(); ?>
