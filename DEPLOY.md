# Triển khai lên server

Repo chỉ chứa mã nguồn (~5MB). WordPress core, plugin và thư mục
`uploads` đều nằm ngoài git nên phải lấy riêng.

Database đã được nạp sẵn lên server với URL `https://tinphatcons.com`
— xem mục 6 nếu cần đổi domain.

---

## 1. Lấy mã nguồn

```bash
cd /home/.test/tps-wp
git clone https://github.com/xuanthao18122000/tpc-wp.git .
```

## 2. Tải WordPress core

Repo không chứa core (`wp-admin/`, `wp-includes/`, `wp-*.php`).
Phiên bản đang dùng ở máy phát triển: **7.1.2**

```bash
curl -L https://wordpress.org/wordpress-7.1.2.tar.gz -o /tmp/wp.tar.gz
tar xzf /tmp/wp.tar.gz -C /tmp
cp -rn /tmp/wordpress/* .
rm -rf /tmp/wordpress /tmp/wp.tar.gz
```

`cp -rn` không ghi đè file sẵn có, nên `wp-content/` của repo được giữ nguyên.

## 3. Tạo wp-config.php

```bash
cp wp-config-sample.php wp-config.php
```

Sửa phần kết nối database — điền giá trị thật, **đừng commit file này**
(`wp-config.php` đã nằm trong `.gitignore`):

```php
define( 'DB_NAME',     'tpc_prod' );
define( 'DB_USER',     '<user>' );
define( 'DB_PASSWORD', '<mật khẩu>' );
define( 'DB_HOST',     '<host>:3306' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );
```

Thông tin kết nối lấy từ người quản trị hệ thống, không lưu trong repo.

Lấy khoá bảo mật mới tại https://api.wordpress.org/secret-key/1.1/salt/
rồi dán đè khối `AUTH_KEY ... NONCE_SALT`.

Thêm vào trước dòng `/* That's all, stop editing! */`:

```php
/* Chạy sau proxy/CDN có TLS thì WordPress mới nhận đúng là https. */
if ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] )
	&& 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}

define( 'WP_DEBUG', false );
define( 'DISALLOW_FILE_EDIT', true );
```

## 4. Cài plugin

Bảy plugin, phiên bản khớp với máy phát triển:

```bash
wp plugin install advanced-custom-fields --version=6.8.9 --activate
wp plugin install polylang --version=3.8.7 --activate
wp plugin install seo-by-rank-math --version=1.0.277.2 --activate
wp plugin install wpforms-lite --version=2.0.1.1 --activate
wp plugin install webp-converter-for-media --version=6.6.5 --activate
wp plugin install updraftplus --version=1.26.7 --activate
wp plugin install wordfence --version=9.0.0           # cài, KHÔNG bật
```

Wordfence ở máy phát triển đang tắt. Bật hay không tuỳ bạn, nhưng nên
cấu hình lại từ đầu trên server chứ đừng mang cấu hình cũ sang.

Không có WP-CLI thì tải thủ công:

```bash
cd wp-content/plugins
for p in advanced-custom-fields polylang seo-by-rank-math \
         wpforms-lite webp-converter-for-media updraftplus wordfence; do
  curl -sL "https://downloads.wordpress.org/plugin/$p.zip" -o "$p.zip"
  unzip -q "$p.zip" && rm "$p.zip"
done
```

## 5. Chép thư mục uploads

**Bắt buộc.** Gồm ảnh banner, ảnh dự án và file PDF hồ sơ năng lực —
không có cách nào sinh lại.

Chạy lệnh này **trên máy phát triển**:

```bash
rsync -avz --progress \
  <thu-muc-du-an-local>/wp-content/uploads/ \
  <user>@<host>:/home/.test/tps-wp/wp-content/uploads/
```

Khoảng 114MB. Riêng `tinphat-docs/ho-so-nang-luc-tin-phat.pdf` đã 62MB —
cân nhắc nén lại trước khi chép.

## 6. Đổi domain (nếu khác tinphatcons.com)

Database đang dùng `https://tinphatcons.com`. Muốn đổi thì **phải dùng
WP-CLI**, đừng chạy `UPDATE ... REPLACE` thẳng trong SQL: nhiều cấu hình
lưu dạng PHP serialize, chuỗi mang sẵn độ dài nên thay thẳng sẽ hỏng
(mất cấu hình Polylang, Rank Math...).

```bash
wp search-replace 'https://tinphatcons.com' 'https://domain-moi.com' \
  --all-tables --precise --skip-columns=guid --dry-run   # xem trước
wp search-replace 'https://tinphatcons.com' 'https://domain-moi.com' \
  --all-tables --precise --skip-columns=guid             # chạy thật
wp cache flush
```

`--skip-columns=guid` là bắt buộc: cột `guid` là định danh cố định của
bài viết, đổi đi sẽ khiến trình đọc RSS coi bài cũ là bài mới.

## 7. Phân quyền và permalink

```bash
chown -R www-data:www-data /home/.test/tps-wp
find /home/.test/tps-wp -type d -exec chmod 755 {} \;
find /home/.test/tps-wp -type f -exec chmod 644 {} \;
chmod 640 wp-config.php

wp rewrite flush --hard
```

Nginx cần rule chuẩn của WordPress:

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

## 8. Kiểm tra

```bash
curl -I https://tinphatcons.com/vi/          # mong đợi 200
curl -I https://tinphatcons.com/en/          # mong đợi 200
curl -I https://tinphatcons.com/vi/du-an/    # mong đợi 200
curl -I https://tinphatcons.com/wp-admin/    # mong đợi 302 về trang đăng nhập
```

Vào `/wp-admin` một lần để Rank Math hoàn tất kích hoạt module sitemap.

---

## Những thứ KHÔNG nằm trong repo

| Phần | Dung lượng | Cách lấy |
|---|---|---|
| WordPress core | 98 MB | Mục 2 |
| 7 plugin | 142 MB | Mục 4 |
| `wp-content/uploads/` | 114 MB | Mục 5 — rsync, không sinh lại được |
| `wp-config.php` | — | Mục 3 |
| Database | 6 MB | Đã nạp sẵn lên server |

## Dựng lại banner (không bắt buộc)

Banner đã nằm sẵn trong `uploads/`. Chỉ cần chạy lại khi muốn đổi ảnh
hoặc chỉnh bố cục:

```bash
# Cần python có PyMuPDF để bóc ảnh từ file PDF hồ sơ năng lực
PDF_PYTHON=/duong/dan/toi/python php scripts/make-banners.php
php scripts/run.php scripts/seed-home.php
```
