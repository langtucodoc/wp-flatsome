<?php
/**
 * WooCommerce Thank You page override.
 *
 * Custom thank-you experience for Vietnamese customers.
 * Shows order details, reassurance, and next steps.
 *
 * @package FlatSomeChild
 * @see     WC_Shortcode_Checkout::output_thankyou()
 */

defined( 'ABSPATH' ) || exit;

$order_id = intval( $_GET['order_id'] ?? 0 );
$order    = $order_id ? wc_get_order( $order_id ) : false;
?>

<div class="woocommerce-thankyou thankyou-page" role="main">
    <div class="container">

        <!-- Success header -->
        <div class="thankyou-header">
            <div class="thankyou-icon" aria-hidden="true">🎉</div>
            <h1 class="thankyou-title">
                Đặt Hàng Thành Công!
            </h1>
            <p class="thankyou-subtitle">
                Cảm ơn bạn đã tin tưởng và đặt hàng.<br>
                Chúng tôi sẽ liên hệ xác nhận đơn hàng trong vòng <strong>30 phút</strong>.
            </p>
        </div>

        <?php if ( $order ) : ?>
        <!-- Order details -->
        <div class="thankyou-order-details">
            <h2>Chi Tiết Đơn Hàng #<?php echo esc_html( $order->get_order_number() ); ?></h2>

            <table class="thankyou-order-table">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php foreach ( $order->get_items() as $item ) : ?>
                <tr>
                    <td><?php echo esc_html( $item->get_name() ); ?></td>
                    <td><?php echo esc_html( $item->get_quantity() ); ?></td>
                    <td><?php echo wp_kses_post( wc_price( $item->get_total() ) ); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="order-total-row">
                    <td colspan="2"><strong>Tổng cộng</strong></td>
                    <td><strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                </tr>
            </table>

            <div class="thankyou-customer-info">
                <div>
                    <strong>Giao đến:</strong><br>
                    <?php echo esc_html( $order->get_formatted_shipping_address() ?: $order->get_formatted_billing_address() ); ?>
                </div>
                <div>
                    <strong>Phương thức thanh toán:</strong><br>
                    <?php echo esc_html( $order->get_payment_method_title() ); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Next steps -->
        <div class="thankyou-next-steps">
            <h3>Bước Tiếp Theo</h3>
            <ul class="thankyou-steps-list" role="list">
                <li role="listitem">
                    <span class="step-icon" aria-hidden="true">📞</span>
                    <div>
                        <strong>Xác nhận đơn hàng</strong>
                        <p>Nhân viên sẽ gọi điện xác nhận trong vòng 30 phút trong giờ hành chính.</p>
                    </div>
                </li>
                <li role="listitem">
                    <span class="step-icon" aria-hidden="true">📦</span>
                    <div>
                        <strong>Đóng gói & Vận chuyển</strong>
                        <p>Đơn hàng được đóng gói cẩn thận và giao cho đơn vị vận chuyển trong 24 giờ.</p>
                    </div>
                </li>
                <li role="listitem">
                    <span class="step-icon" aria-hidden="true">🚚</span>
                    <div>
                        <strong>Nhận hàng & Thanh toán</strong>
                        <p>Bạn nhận hàng, kiểm tra sản phẩm rồi thanh toán cho shipper (COD).</p>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Back to home -->
        <div style="text-align:center;margin-top:40px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-cta">
                ← Quay Về Trang Chủ
            </a>
        </div>

    </div>
</div>

<style>
.thankyou-page { padding: 60px 0; }
.thankyou-header { text-align: center; margin-bottom: 48px; }
.thankyou-icon { font-size: 80px; margin-bottom: 16px; }
.thankyou-title { font-size: 36px; font-weight: 800; color: #27ae60; margin-bottom: 12px; }
.thankyou-subtitle { font-size: 17px; color: #555; line-height: 1.7; }

.thankyou-order-details {
    max-width: 720px; margin: 0 auto 40px;
    background: #FFFBF5; border: 1px solid #E8D5B0;
    border-radius: 16px; padding: 32px;
}
.thankyou-order-details h2 { font-size: 20px; color: #3d1f0a; margin-bottom: 20px; }
.thankyou-order-table { width: 100%; border-collapse: collapse; }
.thankyou-order-table th, .thankyou-order-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #F5EDD8; }
.thankyou-order-table th { background: #5C2D0A; color: #D4AF37; font-weight: 700; }
.order-total-row td { font-size: 18px; color: #C0392B; background: #FDF6EC; }
.thankyou-customer-info { display: flex; gap: 32px; margin-top: 24px; flex-wrap: wrap; font-size: 14px; color: #555; }

.thankyou-next-steps { max-width: 640px; margin: 0 auto 40px; }
.thankyou-next-steps h3 { font-size: 22px; font-weight: 700; color: #3d1f0a; margin-bottom: 24px; text-align: center; }
.thankyou-steps-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px; }
.thankyou-steps-list li { display: flex; gap: 16px; align-items: flex-start; background: #fff; border: 1px solid #E8D5B0; border-radius: 12px; padding: 20px; }
.step-icon { font-size: 32px; flex-shrink: 0; }
.thankyou-steps-list strong { font-size: 15px; color: #3d1f0a; display: block; margin-bottom: 4px; }
.thankyou-steps-list p { font-size: 13px; color: #666; margin: 0; line-height: 1.6; }
</style>
