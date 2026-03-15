# Database Import Guide

## Overview

The `import.sql` file contains a complete WordPress + WooCommerce database setup
for the **Bình Trà Tử Sa Long Phụng** landing page project.

## What's Included

| Table | Content |
|-------|---------|
| `wp_options` | Site settings, WooCommerce config, active plugins, theme |
| `wp_posts` | Landing page, WooCommerce pages (cart, checkout), product + variations |
| `wp_postmeta` | Product data, prices, attributes, SEO meta, page template |
| `wp_terms` | Product categories (Bình Trà, Quà Tặng, Phong Thủy) |
| `wp_term_taxonomy` | Taxonomy registrations |
| `wp_term_relationships` | Product → category assignments |
| `wp_users` | Default admin user |
| `wp_usermeta` | Admin role and capabilities |

## What's NOT Included

- Media uploads (images must be uploaded separately via wp-admin → Media)
- Order history (clean slate for production)
- WooCommerce sessions / carts (transient data)
- Plugin-specific tables (created automatically on plugin activation)
- Flatsome UX Builder page layout JSON (edit via UX Builder after import)

## Import Instructions

### Via phpMyAdmin (recommended for DirectAdmin)

1. Open phpMyAdmin (DirectAdmin → MySQL Management → phpMyAdmin)
2. Select your database from the left sidebar
3. Click the **Import** tab
4. Click **Choose File** → select `import.sql`
5. Set format to **SQL**
6. Click **Go**

### Via WP-CLI (SSH access)

```bash
wp db import database/import.sql
```

### Via MySQL CLI

```bash
mysql -u DB_USER -p DB_NAME < database/import.sql
```

## After Import: Domain Replacement

**CRITICAL**: The SQL file uses `https://YOURDOMAIN.COM` as a placeholder.
After import, run these queries in phpMyAdmin → SQL tab:

```sql
-- Replace with your actual domain
SET @OLD_DOMAIN = 'https://YOURDOMAIN.COM';
SET @NEW_DOMAIN = 'https://youractualsite.com';

UPDATE wp_options
SET option_value = REPLACE(option_value, @OLD_DOMAIN, @NEW_DOMAIN)
WHERE option_name IN ('siteurl', 'home');

UPDATE wp_posts
SET guid = REPLACE(guid, @OLD_DOMAIN, @NEW_DOMAIN);

UPDATE wp_posts
SET post_content = REPLACE(post_content, @OLD_DOMAIN, @NEW_DOMAIN);

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, @OLD_DOMAIN, @NEW_DOMAIN)
WHERE meta_value LIKE '%YOURDOMAIN.COM%';

UPDATE wp_options
SET option_value = REPLACE(option_value, 'admin@YOURDOMAIN.COM', 'your@realemail.com')
WHERE option_name = 'admin_email';
```

For **serialized data** (Flatsome options, WooCommerce settings), use Search-Replace-DB:

```bash
# WP-CLI (most reliable for serialized data)
wp search-replace 'https://YOURDOMAIN.COM' 'https://youractualsite.com' --all-tables

# Or download the tool:
# https://interconnectit.com/search-and-replace-db-script/
```

## Default Admin Credentials

| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |
| **ACTION REQUIRED** | **Change this immediately after first login** |

## Product IDs

After import, the product IDs are:

| Post ID | Type | Description |
|---------|------|-------------|
| 10 | Page | Landing page (homepage) |
| 100 | Product | Main variable product |
| 101 | Variation | 1 bộ — 299,000₫ |
| 102 | Variation | 2 bộ — 579,000₫ |
| 103 | Variation | 3 bộ — 870,000₫ |

After import, update `inc/bundles.php` if you need to set explicit `variation_id` values.

## Troubleshooting

**Error: Duplicate entry for key 'PRIMARY'**
→ The database already has data. Either drop all tables first, or use a fresh empty database.

**Error: Unknown column or table**
→ The SQL expects standard WordPress table prefix `wp_`. If you use a custom prefix,
do a find-replace in import.sql before importing.

**Products not showing correct price**
→ After WooCommerce activates, it may regenerate product lookup tables.
Run: WooCommerce → Status → Tools → Update product lookup tables.

**Permalink 404 errors**
→ Go to Settings → Permalinks → Save Changes (regenerates .htaccess rewrite rules).
