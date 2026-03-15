# DirectAdmin Deployment Checklist
## Project: Bình Trà Tử Sa Long Phụng

Work through this checklist from top to bottom for a clean, safe deployment.
Mark each step with ✅ when done.

---

## PHASE 1 — Hosting Preparation

- [ ] Log in to DirectAdmin control panel
- [ ] Create a new domain or subdomain (e.g. `yourdomain.com`)
- [ ] Verify domain DNS is pointing to the server (A record)
- [ ] Install SSL certificate via DirectAdmin → SSL Certificates → Let's Encrypt
- [ ] Set PHP version to **8.1** or **8.2** (DirectAdmin → Select PHP Version)
- [ ] Verify PHP extensions are enabled: `mysqli`, `mbstring`, `zip`, `gd`, `curl`, `intl`, `xml`
- [ ] Set PHP memory limit to 256M minimum (DirectAdmin → PHP Configuration)

---

## PHASE 2 — Database Setup

- [ ] Go to DirectAdmin → MySQL Management → Create Database
  - Database name: `username_wpbinh` (use your actual DirectAdmin username)
  - Database user: `username_wpuser`
  - Password: generate a strong random password (save it!)
  - Grant ALL PRIVILEGES to the user on this database
- [ ] Open phpMyAdmin (DirectAdmin → MySQL Management → phpMyAdmin)
- [ ] Select the new database
- [ ] Go to Import tab → choose file `database/import.sql`
- [ ] Click Go to import

### After import — domain replacement:
Run these SQL queries in phpMyAdmin → SQL tab
(replace `https://yourdomain.com` with your actual URL):

```sql
UPDATE wp_options
SET option_value = REPLACE(option_value, 'https://YOURDOMAIN.COM', 'https://yourdomain.com')
WHERE option_name IN ('siteurl', 'home');

UPDATE wp_posts
SET guid = REPLACE(guid, 'https://YOURDOMAIN.COM', 'https://yourdomain.com');

UPDATE wp_posts
SET post_content = REPLACE(post_content, 'https://YOURDOMAIN.COM', 'https://yourdomain.com');

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'https://YOURDOMAIN.COM', 'https://yourdomain.com');

UPDATE wp_options
SET option_value = REPLACE(option_value, 'admin@YOURDOMAIN.COM', 'your@email.com')
WHERE option_name = 'admin_email';
```

---

## PHASE 3 — File Upload

### Method A: File Manager (DirectAdmin)
- [ ] Go to DirectAdmin → File Manager
- [ ] Navigate to `public_html/` (or your domain's document root)
- [ ] Upload and extract WordPress core ZIP (download from wordpress.org)
- [ ] Upload and extract Flatsome parent theme ZIP to `public_html/wp-content/themes/flatsome/`

> **Flatsome theme source:** https://github.com/langtucodoc/wp-flatsome/blob/main/themeforest-9tBQuFhj-flatsome-multipurpose-responsive-woocommerce-theme-wordpress-theme.zip

- [ ] Upload the `wp-content/themes/flatsome-child/` folder from this repository

### Method B: FTP/SFTP (FileZilla or similar)
- [ ] Connect via FTP/SFTP credentials from DirectAdmin → FTP Management
- [ ] Upload WordPress core to server root
- [ ] Upload themes as above
- [ ] Upload the child theme folder

---

## PHASE 4 — wp-config.php Setup

- [ ] Copy `deploy/wp-config.php.example` to WordPress root as `wp-config.php`
- [ ] Fill in DB_NAME, DB_USER, DB_PASSWORD (from Phase 2)
- [ ] Go to https://api.wordpress.org/secret-key/1.1/salt/ — copy all 8 keys
- [ ] Paste the keys into wp-config.php (replace the placeholder lines)
- [ ] Verify DB_HOST is `localhost`
- [ ] Set WP_DEBUG to `false`
- [ ] Save the file on the server

---

## PHASE 5 — .htaccess Setup

- [ ] Copy `deploy/htaccess.example` to WordPress root as `.htaccess`
- [ ] After verifying SSL is working, uncomment the HTTPS redirect block

---

## PHASE 6 — WordPress First-Time Setup

If WordPress has not been installed (fresh install, not SQL import):
- [ ] Visit `https://yourdomain.com/wp-admin/install.php`
- [ ] Complete the install wizard
- [ ] Log in to wp-admin

If using the SQL import:
- [ ] Visit `https://yourdomain.com/wp-admin`
- [ ] Log in with: `admin` / `admin123`
- [ ] **IMMEDIATELY change the admin password** → Users → Your Profile → Set New Password
- [ ] Update admin email address

---

## PHASE 7 — Plugin Installation & Activation

Install these plugins via wp-admin → Plugins → Add New:

| Plugin | Purpose | Free/Paid |
|--------|---------|-----------|
| WooCommerce | E-commerce engine | Free |
| Yoast SEO | SEO optimization | Free |
| WP Super Cache | Page caching | Free |
| Smush | Image optimization | Free |
| Contact Form 7 | Contact forms | Free |
| Limit Login Attempts Reloaded | Security | Free |
| WooCommerce COD Gateway | Cash on delivery | Free (bundled) |
| WP Fastest Cache | Alt. caching | Free |

- [ ] Activate all plugins
- [ ] Run WooCommerce setup wizard if prompted (skip payment gateway setup for now)

---

## PHASE 8 — Theme Activation

- [ ] Go to Appearance → Themes
- [ ] Verify "Flatsome" parent theme is listed (if not, upload it)
- [ ] Activate "Flatsome Child" theme
- [ ] Confirm the child theme is active (shows "Active" badge)

---

## PHASE 9 — WooCommerce Configuration

- [ ] WooCommerce → Settings → General:
  - [ ] Set store address: 987 Tam Trinh, Hoàng Mai, Hà Nội
  - [ ] Set selling country: Vietnam
  - [ ] Currency: VND (Vietnamese Dong)
  - [ ] Currency position: Right with space
  - [ ] Thousand separator: `,`
  - [ ] Decimal separator: (empty)
  - [ ] Number of decimals: 0

- [ ] WooCommerce → Settings → Shipping:
  - [ ] Add Vietnam shipping zone
  - [ ] Add "Free Shipping" method for orders ≥ 870,000₫ (3-bundle minimum)
  - [ ] Add "Flat Rate" shipping: 30,000₫ for orders under 870,000₫

- [ ] WooCommerce → Settings → Payments:
  - [ ] Enable "Cash on Delivery (COD)"
  - [ ] Disable "Direct bank transfer" if not using
  - [ ] Set COD description in Vietnamese

- [ ] WooCommerce → Settings → Accounts & Privacy:
  - [ ] Enable guest checkout
  - [ ] Disable registration requirements

---

## PHASE 10 — Product Setup

- [ ] Go to Products → All Products
- [ ] Verify "Bình Trà Tử Sa Long Phụng" product exists (from SQL import)
- [ ] Upload product images: hero image + gallery images
- [ ] Verify variations are set up correctly:
  - [ ] 1 bộ → 299,000₫
  - [ ] 2 bộ → 579,000₫
  - [ ] 3 bộ → 870,000₫
- [ ] Set variation_id values in `inc/bundles.php` to match actual variation IDs

---

## PHASE 11 — Page & Permalink Setup

- [ ] Go to Settings → Reading:
  - [ ] Set "Your homepage displays" → A static page
  - [ ] Homepage: "Bình Trà Tử Sa Long Phụng — Đổi Màu Kỳ Diệu"
  - [ ] Posts page: none (not a blog)

- [ ] Go to Settings → Permalinks:
  - [ ] Select "Post name" structure: `/%postname%/`
  - [ ] Click Save (this regenerates .htaccess rewrite rules)

- [ ] Verify WooCommerce pages exist:
  - [ ] Cart → `/gio-hang/`
  - [ ] Checkout → `/thanh-toan/`
  - [ ] My Account → `/tai-khoan/`

---

## PHASE 12 — UX Builder Page Layout

- [ ] Go to Pages → Landing Page → Edit with UX Builder
- [ ] The `page-landing.php` template renders most content via PHP
- [ ] In UX Builder, you can add/edit:
  - [ ] Hero background or additional images
  - [ ] Any promotional banners or announcement bars
  - [ ] Product image gallery section
- [ ] Save and preview the page

---

## PHASE 13 — Final Verification

- [ ] Visit the homepage — confirm landing page template loads correctly
- [ ] Confirm countdown timer is ticking
- [ ] Test bundle selection → verify AJAX add-to-cart works
- [ ] Complete a test order (COD) end-to-end:
  - [ ] Select bundle on landing page
  - [ ] Fill checkout with test Vietnamese address
  - [ ] Place order
  - [ ] Confirm order appears in WooCommerce → Orders
  - [ ] Confirm thank-you page displays correctly
- [ ] Test on mobile device (or Chrome DevTools mobile emulation):
  - [ ] Sticky CTA bar appears after scrolling
  - [ ] FAQ accordion opens/closes
  - [ ] All sections look correct
- [ ] Check all internal links work
- [ ] Run Google PageSpeed Insights — target 80+ mobile score

---

## PHASE 14 — Post-Launch Security

- [ ] Change default `admin` username to something non-obvious
- [ ] Set strong 16+ character admin password
- [ ] Verify WP_DEBUG is `false` in wp-config.php
- [ ] Verify DISALLOW_FILE_EDIT is `true`
- [ ] Remove any test orders from WooCommerce → Orders
- [ ] Set up automated backups (DirectAdmin → Backups, or use UpdraftPlus plugin)
- [ ] Confirm SSL certificate is valid and HTTPS redirect is active
- [ ] Submit sitemap to Google Search Console: `https://yourdomain.com/sitemap_index.xml`

---

## EMERGENCY RECOVERY

If something goes wrong:
1. Restore from backup (DirectAdmin → Backups)
2. Re-import `database/import.sql` to a fresh database
3. Re-run domain replacement queries
4. Check PHP error log: DirectAdmin → Error Logs
5. Enable WP_DEBUG temporarily to see PHP errors
6. Check WooCommerce logs: WooCommerce → Status → Logs
