-- =============================================================
-- WordPress + WooCommerce Database Setup
-- Project: Bình Trà Tử Sa Long Phụng
-- =============================================================
-- INSTRUCTIONS:
-- 1. Create a new MySQL database (utf8mb4_unicode_ci)
-- 2. Run this file via phpMyAdmin → Import, or:
--    mysql -u USER -p DATABASE_NAME < import.sql
-- 3. After import, run the domain replacement queries at bottom.
-- 4. Update wp-config.php with correct DB credentials.
--
-- TABLE PREFIX: wp_  (change if your install uses a different prefix)
-- PLACEHOLDER DOMAIN: https://YOURDOMAIN.COM
-- =============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ─── WordPress options ────────────────────────────────────────────────────────

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
-- Core
(1,  'siteurl',             'https://YOURDOMAIN.COM',                       'yes'),
(2,  'blogname',            'Bình Trà Tử Sa Long Phụng',                    'yes'),
(3,  'blogdescription',     'Bình trà đổi màu cao cấp — Tử Sa Nghi Hưng',  'yes'),
(4,  'admin_email',         'admin@YOURDOMAIN.COM',                         'yes'),
(5,  'blogpublic',          '1',                                             'yes'),
(6,  'default_comment_status', 'closed',                                    'yes'),
(7,  'default_ping_status',   'closed',                                     'yes'),
(8,  'uploads_use_yearmonth_folders', '1',                                  'yes'),
(9,  'permalink_structure', '/%postname%/',                                  'yes'),
(10, 'timezone_string',     'Asia/Ho_Chi_Minh',                              'yes'),
(11, 'date_format',         'd/m/Y',                                         'yes'),
(12, 'time_format',         'H:i',                                           'yes'),
(13, 'start_of_week',       '1',                                             'yes'),
(14, 'WPLANG',              'vi',                                            'yes'),
(15, 'show_on_front',       'page',                                          'yes'),

-- Active theme
(20, 'stylesheet',          'flatsome-child',                                'yes'),
(21, 'template',            'flatsome',                                      'yes'),
(22, 'current_theme',       'Flatsome Child',                                'yes'),

-- Active plugins (adjust to match your actual plugin slugs)
(30, 'active_plugins', 'a:6:{i:0;s:36:"woocommerce/woocommerce.php";i:1;s:48:"woocommerce-cod/woocommerce-cod.php";i:2;s:60:"woocommerce-gateway-vnpay/woocommerce-gateway-vnpay.php";i:3;s:38:"yoast-seo/wp-seo-main.php";i:4;s:58:"contact-form-7/wp-contact-form-7.php";i:5;s:64:"limit-login-attempts-reloaded/limit-login-attempts-reloaded.php";}', 'yes'),

-- WooCommerce core settings
(40, 'woocommerce_store_address',   '987 Tam Trinh',                        'yes'),
(41, 'woocommerce_store_city',      'Hà Nội',                               'yes'),
(42, 'woocommerce_default_country', 'VN',                                   'yes'),
(43, 'woocommerce_store_postcode',  '',                                      'yes'),
(44, 'woocommerce_currency',        'VND',                                   'yes'),
(45, 'woocommerce_currency_pos',    'right_space',                           'yes'),
(46, 'woocommerce_price_thousand_sep', ',',                                  'yes'),
(47, 'woocommerce_price_decimal_sep',  '',                                   'yes'),
(48, 'woocommerce_price_num_decimals', '0',                                  'yes'),
(49, 'woocommerce_weight_unit',     'kg',                                    'yes'),
(50, 'woocommerce_dimension_unit',  'cm',                                    'yes'),

-- WooCommerce checkout settings
(51, 'woocommerce_enable_guest_checkout', 'yes',                             'yes'),
(52, 'woocommerce_enable_checkout_login_reminder', 'no',                    'yes'),
(53, 'woocommerce_enable_signup_and_login_from_checkout', 'no',             'yes'),
(54, 'woocommerce_ship_to_destination', 'billing',                          'yes'),
(55, 'woocommerce_calc_taxes',      'no',                                    'yes'),
(56, 'woocommerce_prices_include_tax', 'yes',                               'yes'),

-- WooCommerce shipping
(57, 'woocommerce_ship_to_countries', 'specific',                           'yes'),
(58, 'woocommerce_specific_ship_to_countries', 'a:1:{i:0;s:2:"VN";}',     'yes'),

-- COD payment enabled
(60, 'woocommerce_cod_settings', 'a:4:{s:7:"enabled";s:3:"yes";s:5:"title";s:30:"Thanh toán khi nhận hàng (COD)";s:11:"description";s:68:"Thanh toán trực tiếp cho shipper khi nhận được hàng tại nhà.";s:12:"instructions";s:68:"Thanh toán trực tiếp cho shipper khi nhận được hàng tại nhà.";}', 'yes'),

-- WooCommerce pages (IDs match wp_posts below)
(70, 'woocommerce_shop_page_id',     '2',  'yes'),
(71, 'woocommerce_cart_page_id',     '3',  'yes'),
(72, 'woocommerce_checkout_page_id', '4',  'yes'),
(73, 'woocommerce_myaccount_page_id','5',  'yes'),
(74, 'page_on_front',                '10', 'yes'),   -- Landing page = front page

-- Flatsome theme options (minimal)
(80, 'flatsome_options', 'a:10:{s:11:"header_logo";s:0:"";s:12:"sticky_logo2";s:3:"yes";s:18:"header_transparent";s:2:"no";s:12:"header_width";s:4:"full";s:15:"header_bg_color";s:7:"#3d1f0a";s:16:"header_font_size";s:2:"14";s:13:"footer_widget";s:2:"no";s:12:"footer_clean";s:3:"yes";s:19:"footer_bottom_color";s:7:"#2C1A0E";s:14:"footer_bg_color";s:7:"#2C1A0E";}', 'yes'),

-- WooCommerce install state
(90, 'woocommerce_db_version',   '8.4.0', 'yes'),
(91, 'woocommerce_version',      '8.4.0', 'yes'),
(92, 'woocommerce_task_list_hidden', 'yes', 'yes'),

-- Page for posts (blog) — disabled for landing page
(100, 'show_on_front', 'page', 'yes');

-- ─── WordPress pages ──────────────────────────────────────────────────────────
-- NOTE: Page content (Flatsome UX Builder layout) is stored in wp_postmeta
-- below as `_flatsome_layout`. Build the visual layout in UX Builder after import.

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_name`, `post_type`, `post_parent`, `menu_order`, `post_modified`, `post_modified_gmt`, `guid`, `to_ping`, `pinged`, `post_content_filtered`) VALUES

-- Home / Landing page
(10, 1, NOW(), NOW(),
 '<!-- Flatsome UX Builder manages this content. Edit via Pages → Landing Page → Edit with UX Builder. -->',
 'Bình Trà Tử Sa Long Phụng — Đổi Màu Kỳ Diệu',
 'Bình trà tử sa đổi màu khi rót nước sôi. Chất liệu Nghi Hưng, họa tiết Rồng Phượng, quà tặng cao cấp.',
 'publish', 'closed', 'closed',
 'binh-tra-tu-sa-long-phung',
 'page', 0, 0,
 NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=10',
 '', '', ''),

-- WooCommerce: Shop page
(2, 1, NOW(), NOW(), '', 'Cửa Hàng', '', 'publish', 'closed', 'closed',
 'cua-hang', 'page', 0, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=2', '', '', ''),

-- WooCommerce: Cart page
(3, 1, NOW(), NOW(), '<!-- wp:woocommerce/cart /-->', 'Giỏ Hàng', '', 'publish', 'closed', 'closed',
 'gio-hang', 'page', 0, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=3', '', '', ''),

-- WooCommerce: Checkout page
(4, 1, NOW(), NOW(), '<!-- wp:woocommerce/checkout /-->', 'Thanh Toán', '', 'publish', 'closed', 'closed',
 'thanh-toan', 'page', 0, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=4', '', '', ''),

-- WooCommerce: My Account page
(5, 1, NOW(), NOW(), '<!-- wp:woocommerce/customer-account /-->', 'Tài Khoản', '', 'publish', 'closed', 'closed',
 'tai-khoan', 'page', 0, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=5', '', '', ''),

-- Privacy Policy page
(6, 1, NOW(), NOW(),
 '<h2>Chính Sách Bảo Mật</h2><p>Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Thông tin thu thập chỉ được sử dụng để xử lý đơn hàng và liên hệ giao hàng.</p>',
 'Chính Sách Bảo Mật', '', 'publish', 'closed', 'closed',
 'chinh-sach-bao-mat', 'page', 0, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?page_id=6', '', '', ''),

-- WooCommerce Product: Bình Trà Tử Sa Long Phụng
(100, 1, NOW(), NOW(),
 '<p>Bình Trà Tử Sa Long Phụng — sản phẩm làm từ đất tử sa nguyên chất vùng Nghi Hưng, có khả năng đổi màu kỳ diệu khi rót nước nóng trên 45°C. Họa tiết Rồng Phụng tinh xảo, thủ công, tượng trưng cho thịnh vượng và hạnh phúc.</p><p>Dung tích: 280ml · Kích thước bình: 8.5 × 11cm · Không tráng men · An toàn thực phẩm.</p>',
 'Bình Trà Tử Sa Long Phụng',
 'Bình trà đổi màu kỳ diệu từ đất tử sa Nghi Hưng. Họa tiết Rồng Phượng thủ công cao cấp.',
 'publish', 'closed', 'closed',
 'binh-tra-tu-sa-long-phung',
 'product', 0, 0,
 NOW(), NOW(),
 'https://YOURDOMAIN.COM/?post_type=product&p=100',
 '', '', ''),

-- Product variation: 1 bộ
(101, 1, NOW(), NOW(), '', '1 bộ', '', 'publish', 'closed', 'closed',
 'binh-tra-1-bo', 'product_variation', 100, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?post_type=product_variation&p=101', '', '', ''),

-- Product variation: 2 bộ
(102, 1, NOW(), NOW(), '', '2 bộ', '', 'publish', 'closed', 'closed',
 'binh-tra-2-bo', 'product_variation', 100, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?post_type=product_variation&p=102', '', '', ''),

-- Product variation: 3 bộ
(103, 1, NOW(), NOW(), '', '3 bộ', '', 'publish', 'closed', 'closed',
 'binh-tra-3-bo', 'product_variation', 100, 0, NOW(), NOW(),
 'https://YOURDOMAIN.COM/?post_type=product_variation&p=103', '', '', '');

-- ─── Page meta: landing page template ────────────────────────────────────────

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 10, '_wp_page_template', 'page-landing.php');

-- ─── Product meta: main variable product ─────────────────────────────────────

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(100, 100, '_product_type',           'variable'),
(101, 100, '_sku',                    'BTTS-DRAGON-001'),
(102, 100, '_regular_price',          '299000'),
(103, 100, '_sale_price',             '299000'),
(104, 100, '_price',                  '299000'),
(105, 100, '_visibility',             'visible'),
(106, 100, '_stock_status',           'instock'),
(107, 100, '_manage_stock',           'no'),
(108, 100, '_backorders',             'no'),
(109, 100, '_weight',                 '0.5'),
(110, 100, '_length',                 '11'),
(111, 100, '_width',                  '8.5'),
(112, 100, '_height',                 '12'),
(113, 100, '_featured',               'no'),
(114, 100, 'total_sales',             '0'),
(115, 100, '_product_attributes', 'a:1:{s:11:"so_luong_bo";a:6:{s:4:"name";s:11:"so_luong_bo";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:0;}}'),

-- Variation: 1 bộ — 299,000 VND
(200, 101, '_regular_price',      '299000'),
(201, 101, '_sale_price',         '299000'),
(202, 101, '_price',              '299000'),
(203, 101, '_sku',                'BTTS-1BO'),
(204, 101, '_stock_status',       'instock'),
(205, 101, 'attribute_so_luong_bo', '1 bộ'),

-- Variation: 2 bộ — 579,000 VND
(210, 102, '_regular_price',      '579000'),
(211, 102, '_sale_price',         '579000'),
(212, 102, '_price',              '579000'),
(213, 102, '_sku',                'BTTS-2BO'),
(214, 102, '_stock_status',       'instock'),
(215, 102, 'attribute_so_luong_bo', '2 bộ'),

-- Variation: 3 bộ — 870,000 VND (free shipping)
(220, 103, '_regular_price',      '870000'),
(221, 103, '_sale_price',         '870000'),
(222, 103, '_price',              '870000'),
(223, 103, '_sku',                'BTTS-3BO'),
(224, 103, '_stock_status',       'instock'),
(225, 103, 'attribute_so_luong_bo', '3 bộ'),

-- Landing page SEO meta (Yoast)
(300, 10, '_yoast_wpseo_title',          'Bình Trà Tử Sa Long Phụng — Đổi Màu Kỳ Diệu | Chính Hãng'),
(301, 10, '_yoast_wpseo_metadesc',       'Bình trà tử sa đổi màu khi rót nước sôi. Chất liệu Nghi Hưng chính hãng. Họa tiết Rồng Phượng thủ công. Giá 299.000₫. Giao hàng toàn quốc.'),
(302, 10, '_yoast_wpseo_canonical',      'https://YOURDOMAIN.COM/'),

-- Product SEO meta
(310, 100, '_yoast_wpseo_title',         'Bình Trà Tử Sa Long Phụng Đổi Màu — Chính Hãng Nghi Hưng'),
(311, 100, '_yoast_wpseo_metadesc',      'Bình trà tử sa Long Phụng đổi màu khi rót nước nóng. Đất Nghi Hưng nguyên chất, an toàn thực phẩm. Giá 299.000₫ — miễn phí ship đơn 3 bộ.');

-- ─── Product taxonomy: category ──────────────────────────────────────────────

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Bình Trà', 'binh-tra', 0),
(2, 'Quà Tặng', 'qua-tang', 0),
(3, 'Phong Thủy', 'phong-thuy', 0);

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'product_cat', 'Bình trà các loại', 0, 1),
(2, 2, 'product_cat', 'Quà tặng cao cấp', 0, 1),
(3, 3, 'product_cat', 'Sản phẩm phong thủy', 0, 1);

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(100, 1, 0),
(100, 2, 0),
(100, 3, 0);

-- ─── Admin user ───────────────────────────────────────────────────────────────
-- IMPORTANT: Change the password hash immediately after import!
-- Default password: admin123 — MUST be changed before going live.
-- Generate a new hash at: https://phppasswordhash.com/

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin',
 '$P$BZlMqUh5xdG3hL2vD6TZP9kqLEFkBp.',   -- hash of: admin123 — CHANGE THIS
 'admin',
 'admin@YOURDOMAIN.COM',
 'https://YOURDOMAIN.COM',
 NOW(),
 '', 0,
 'Administrator');

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
(2, 1, 'wp_user_level',   '10'),
(3, 1, 'locale',          'vi');

-- ─── Navigation menus ─────────────────────────────────────────────────────────

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(10, 'Menu Chính',   'menu-chinh',   0),
(11, 'Menu Footer',  'menu-footer',  0);

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(10, 10, 'nav_menu', '', 0, 0),
(11, 11, 'nav_menu', '', 0, 0);

-- Register the menus in theme locations
INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES
('nav_menu_options', 'a:1:{s:11:"auto_add";a:0:{}}', 'no'),
('theme_mods_flatsome-child', 'a:1:{s:12:"nav_menu_locations";a:2:{s:7:"primary";i:10;s:6:"footer";i:11;}}', 'yes');

-- ─── DOMAIN REPLACEMENT QUERIES ──────────────────────────────────────────────
-- Run these after adjusting YOURDOMAIN.COM to your actual domain.
-- Replace 'https://YOURDOMAIN.COM' with your real URL throughout.
--
-- UPDATE `wp_options`  SET `option_value` = REPLACE(`option_value`, 'https://YOURDOMAIN.COM', 'https://yourrealsite.com') WHERE `option_name` IN ('siteurl', 'home');
-- UPDATE `wp_posts`    SET `guid`          = REPLACE(`guid`,          'https://YOURDOMAIN.COM', 'https://yourrealsite.com');
-- UPDATE `wp_posts`    SET `post_content`  = REPLACE(`post_content`,  'https://YOURDOMAIN.COM', 'https://yourrealsite.com');
-- UPDATE `wp_postmeta` SET `meta_value`    = REPLACE(`meta_value`,    'https://YOURDOMAIN.COM', 'https://yourrealsite.com');
--
-- For serialized data (Flatsome options, WooCommerce settings), use the
-- Search-Replace-DB tool: https://interconnectit.com/search-and-replace-db-script/
-- or WP-CLI: wp search-replace 'https://YOURDOMAIN.COM' 'https://yourrealsite.com' --all-tables
