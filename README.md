# tp-wp — Tín Phát Construction (WordPress)

Clone của bản Next.js `tinphat-new` sang WordPress + Flatsome, song ngữ VI/EN.

## Chạy

```bash
./start-local.sh    # khởi động (http://localhost:8090)
make build          # build CSS/JS theme
make watch          # dev, tự build khi sửa
```

### Vì sao cần nhiều worker

`php -S` mặc định chỉ xử lý **một request tại một thời điểm**. Trang
`wp-admin` tải song song nhiều request (admin-ajax, heartbeat, CSS, JS),
xếp hàng đủ lâu thì server đứt kết nối hoặc chết hẳn — trình duyệt báo
404 / không tải được, dễ tưởng nhầm là lỗi permalink.

`start-local.sh` đặt sẵn `PHP_CLI_SERVER_WORKERS=8` để fork 8 tiến trình
con. Muốn đổi:

```bash
PHP_CLI_SERVER_WORKERS=16 ./start-local.sh
```

Kiểm tra đã chạy đúng chưa (phải thấy 9 dòng = 1 master + 8 worker):

```bash
ps aux | grep "php -S" | grep -v grep
```

Đây là giới hạn của server built-in, chỉ dùng cho môi trường dev. Hosting
thật chạy Nginx/Apache + PHP-FPM nên không gặp.

## Database

Dùng **MySQL 8.0 trên máy host**, không phải container:

| | |
|---|---|
| Database | `tpc_web_prod` |
| User | `tinphat` (chỉ có quyền trên DB này) |
| Host (từ container) | `host.docker.internal:3306` |

Thông số nằm trong `.env` (đã gitignore).

**Lưu ý cấu hình máy:** `/opt/homebrew/etc/my.cnf` đã đổi
`bind-address` từ `127.0.0.1` sang `0.0.0.0` để container kết nối được.
Bản gốc lưu tại `my.cnf.bak`. MySQL 8.0 dùng chứng chỉ tự ký nên
`config/wp-cli.yml` bật `skip-ssl` cho các lệnh `wp db`.

Admin: http://localhost:8090/wp-admin — `admin` / `TinPhat@2026`

## Stack

| Thành phần | Phiên bản | Ghi chú |
|---|---|---|
| WordPress | 7.0.4 | Bản vá bảo mật mới nhất nhánh 7.0 |
| PHP | 8.3 | |
| MySQL | 8.0 (chạy trên máy host, DB `tpc_web_prod`) | |
| Polylang | 3.8.7 | Song ngữ, hreflang |
| Rank Math | 1.0.277.2 | SEO, tự nhận Polylang |
| ACF | 6.8.9 | |
| Converter for Media | 6.6.5 | WebP |
| Wordfence | 9.0.0 | Bảo mật — **đang tắt ở local**, xem ghi chú dưới |
| WPForms Lite | 2.0.1.1 | Form liên hệ |
| UpdraftPlus | 1.26.7 | Backup (trên mức có CVE-2026-10795) |

Theme `tinphat` **độc lập, không có theme cha** — toàn bộ CSS tự chứa
(Bootstrap + style của template Centralcons đã port sang).
Không dùng Flatsome nên **không cần license Envato nào**: toàn bộ
source là GPL.

## Cấu trúc

```
tp-wp/
├── docker-compose.yml
├── scripts/                    # WP-CLI seed, chạy lại nhiều lần được
│   ├── setup-languages.php
│   ├── setup-polylang-options.php
│   ├── seed-pages.php
│   └── seed-projects.php
└── wp-content/themes/tinphat/  # child theme
    ├── header.php / footer.php / page.php
    ├── index.php / single.php / search.php / 404.php
    ├── inc/
    │   ├── setup.php           # theme support, menu, dọn head
    │   ├── assets.php          # enqueue, cache-bust theo filemtime
    │   ├── helpers.php         # hàm tiện ích
    │   ├── seo.php             # JSON-LD Organization + x-default
    │   ├── posttype/register.php
    │   └── builder/            # shortcode UX Builder
    ├── assets/src/             # nguồn CSS/JS
    ├── assets/dist/            # build ra (không sửa tay)
    └── languages/              # tinphat-en_US.po/.mo
```

## Sơ đồ URL

Slug **phẳng một cấp** — cấu trúc cây vẫn giữ trong database để tab
điều hướng, menu và breadcrumb hoạt động, nhưng URL không lồng nhau.

| VI | EN |
|---|---|
| `/vi/` | `/en/` |
| `/vi/gioi-thieu/` | `/en/about-us/` |
| `/vi/tong-quan/` | `/en/overview/` |
| `/vi/thong-diep-giam-doc/` | `/en/directors-message/` |
| `/vi/tam-nhin-gia-tri-cot-loi/` | `/en/vision-core-values/` |
| `/vi/doi-tac-khach-hang/` | `/en/partners-clients/` |
| `/vi/nang-luc/` | `/en/capabilities/` |
| `/vi/linh-vuc-hoat-dong/` | `/en/what-we-do/` |
| `/vi/may-moc-thiet-bi/` | `/en/plant-equipment/` |
| `/vi/quy-trinh-thi-cong/` | `/en/construction-process/` |
| `/vi/chung-chi-giay-phep/` | `/en/certificates-licences/` |
| `/vi/tin-tuc/` | `/en/news/` |
| `/vi/lien-he/` | `/en/contact/` |

URL lồng cũ (`/vi/gioi-thieu/tong-quan/`) **redirect 301** sang URL phẳng,
tránh nội dung trùng lặp.

Xử lý trong `inc/permalinks.php`:
- `page_link` — sinh URL phẳng, giữ đúng tiền tố ngôn ngữ
- `parse_request` — nhận cả `name` (URL 1 cấp) lẫn `pagename` (nhiều cấp)
- `template_redirect` — 301 từ URL cũ sang chuẩn

### Vì sao giữ `/vi` `/en`

Bỏ tiền tố và lưu ngôn ngữ vào localStorage sẽ **hại SEO**: Google
crawler không chạy JavaScript storage, nên chỉ index được một ngôn ngữ,
mất `hreflang`, và hai bản dịch dùng chung URL bị coi là trùng lặp.


## Shortcode

Đăng ký bằng `add_shortcode()` chuẩn WordPress nên chạy độc lập.
Dùng trong nội dung trang:

```
[tinphat_key_numbers heading="..." subheading="..."]
  [tinphat_key_number_item label="Dự án hoàn thành" value="100" unit="dự án"]
[/tinphat_key_numbers]

[tinphat_projects title="Dự án" limit="9" category=""]
```

## Quy ước code

- Mọi output đi qua `esc_html()` / `esc_attr()` / `esc_url()`
- Query dùng `WP_Query`, không viết SQL thô
- Chuỗi hiển thị bọc `__()` với textdomain `tinphat`
- Bản dịch EN ở `languages/tinphat-en_US.po`, build `.mo` bằng
  `wp i18n make-mo`

## Không dùng Flatsome

Theme đã gỡ hoàn toàn phụ thuộc Flatsome (03/09/2026):

- `style.css` bỏ `Template: flatsome` → theme độc lập
- Bổ sung `index.php`, `single.php`, `search.php`, `404.php`
- CSS bỏ `@layer` và preflight của Tailwind — layer có độ ưu tiên thấp
  hơn CSS thường nên Tailwind sẽ ghi đè style của template
- Chỉ import `tailwindcss/theme.css` + `utilities.css`, không lấy
  preflight (reset) vì template đã có reset riêng

Class `TinPhat_Shortcode` vẫn giữ nhánh `add_ux_builder_shortcode()`
có guard `function_exists()` — không có Flatsome thì bỏ qua, nếu sau
này cài lại thì tự hoạt động.

## Đã clone xong

- Header + footer theo đúng thiết kế gốc (CSS template port nguyên, 15k dòng)
- Trang chủ: banner slider, khối số liệu đếm, carousel dự án
- Trang con: ảnh bìa + breadcrumb + **tab điều hướng** + nội dung
  - Tab tự sinh từ cây trang: trang con hiện anh em cùng cha,
    trang cha hiện các con của nó
  - Cuộn ngang khi tràn, tự cuộn tới mục đang xem
  - Không hiện nếu nhánh chỉ có một trang
- Favicon: biểu tượng lục giác Tín Phát (cắt từ `logo-doc.png`, bỏ phần chữ
  vì ở 32×32 không đọc được)
- Menu song ngữ, chuyển ngôn ngữ, drawer mobile, ô tìm kiếm
- 9 dự án × 2 ngôn ngữ, có ảnh đại diện
- Tin tức: dùng `post` mặc định của WordPress
  - 6 bài × 2 ngôn ngữ, 3 chuyên mục (Tin dự án / Hoạt động nội bộ / Tin công ty)
  - Trang `/vi/tin-tuc/` và `/en/news/` là archive (`page_for_posts`)
  - `home.php` (danh sách), `category.php` (theo chuyên mục), `single.php` (bài đơn)
  - Bộ lọc chuyên mục, phân trang, badge ngày trên ảnh
- 236 ảnh + 25 font đã copy sang `wp-content/uploads/tinphat/`
- Trang **Tầm nhìn, giá trị cốt lõi**: dựng lại đúng bố cục centralcons —
  ảnh lệch phải với hộp xanh chồng lên bên trái, tiêu đề `.title_section`
  của template, và lưới mosaic 3 cột cho 5 giá trị cốt lõi (ô ảnh chiếm
  2 cột, tỉ lệ 2:1; thẻ chữ hình vuông). Nội dung là dữ liệu thật của
  Tín Phát, icon dùng bộ `value-0X.webp` sẵn có.
- Trang **Liên hệ**: 4 thẻ thông tin (trụ sở / hotline / email / giờ làm
  việc), bản đồ Google nhúng theo địa chỉ thật (không cần API key), và
  khối form. WPForms chưa có form nào nên hiện khối hướng dẫn kèm số
  điện thoại + email; tạo form trong WPForms rồi chạy lại seed là tự
  nhúng.
- **4 trang năng lực**: Lĩnh vực hoạt động (số liệu + 6 thẻ năng lực),
  Máy móc & Thiết bị (3 bảng thiết bị + cơ cấu nhân sự), Quy trình thi
  công (6 bước), Chứng chỉ & Giấy phép. Toàn bộ số liệu lấy từ bản
  Next.js cũ — dữ liệu thật của Tín Phát.
- **Trang tin tức**: dựng lại theo centralcons — khối tin nổi bật (1 bài
  lớn + 3 bài danh sách bên phải) rồi lưới "Tin tức khác" 3 cột. Dùng lại
  đúng class `.news__page` có sẵn trong template nên không thêm CSS bố cục.
- Trang **Đối tác và khách hàng**: giới thiệu, 3 thẻ lĩnh vực phục vụ
  (dân dụng / công nghiệp / thương mại), 3 lưới logo theo nhóm, khối CTA.

## Seed nội dung (không cần WP-CLI)

Đã bỏ Docker nên không còn container `wpcli`. Dùng runner trong repo:

```bash
php scripts/run.php scripts/seed-about-pages.php
php scripts/run.php scripts/seed-contact-page.php
php scripts/run.php scripts/seed-capability-pages.php
php scripts/run.php scripts/seed-news-thumbnails.php
```

Runner nạp WordPress, giả lập lớp `WP_CLI` và **đặt user admin** — nếu
không, WordPress lọc `post_content` bằng `wp_kses_post` và xoá sạch SVG
inline (user CLI mặc định không có quyền `unfiltered_html`).

Mọi script trong `scripts/` chạy lại nhiều lần được, kết quả không đổi.

## Việc còn lại

- [ ] **Logo đối tác thật**: trang `doi-tac-khach-hang` hiện dùng 19 logo
      khách hàng của Central làm mockup, chia 3 nhóm (chủ đầu tư / đối tác
      thi công / nhà cung cấp). Thay bằng logo thật rồi chạy lại
      `scripts/seed-about-pages.php`.
- [ ] Nội dung cho CPT văn hóa, video, tuyển dụng, đối tác (đã đăng ký, chưa có bài)
- [ ] **Ảnh tin tức**: đang mượn ảnh công trình/phối cảnh trong uploads
      làm ảnh đại diện. Các file `news-0X-*.webp` của template KHÔNG dùng
      được vì in rõ logo CENTRAL. Thay ảnh thật rồi chạy lại
      `scripts/seed-news-thumbnails.php`.
- [ ] Thay ảnh mockup Central bằng ảnh thật của Tín Phát
  (`uploads/tinphat/` còn nhiều ảnh mang thương hiệu Central)
- [ ] Form liên hệ: tạo form trong WPForms rồi chạy lại
      `scripts/seed-contact-page.php` (script tự nhúng form đầu tiên)
- [ ] Cấu hình cache theo hosting thật
- [ ] **Rank Math sitemap**: cần vào `/wp-admin` một lần để hoàn tất
  kích hoạt module. Hiện đang dùng sitemap của WordPress core
  (`/wp-sitemap.xml`) — vẫn tách đúng VI/EN nên không gấp.

## Wordfence — tắt ở môi trường dev

Wordfence khi mới cài sẽ gọi API ra ngoài mỗi request để lấy firewall
rules. Trong container không có đường ra phù hợp nên phải chờ timeout:
**16.5s/request** thay vì 0.33s.

Đã deactivate ở local. Khi deploy lên hosting thật thì bật lại:

```bash
make cli CMD="plugin activate wordfence"
```

Rồi vào `/wp-admin` chạy wizard một lần để nó lấy được rules.

## Hiệu năng (Lighthouse)

| | Mô phỏng 4G chậm | Mạng thật (no throttle) |
|---|---|---|
| Performance | 76 | **100** |
| Accessibility | **100** | |
| Best Practices | **100** | |
| SEO | **100** | |

LCP 6.8s ở chế độ throttle là do Lighthouse mô phỏng mạng 4G chậm —
đo trực tiếp trên máy chỉ **0.6s**. Trên hosting có CDN sẽ tốt hơn nhiều.

Đã tối ưu:
- Banner 3.5MB → 764KB (JPEG → WebP q68, 1600px)
- Logo 1.65MB → 71KB (1632px → 400px)
- Ảnh nền CSS 1MB → 343KB (WebP)
- Gỡ Font Awesome (30KB CSS + font) → 4 icon SVG inline
- Font: 19 `@font-face` → 5 (bỏ subset thai, weight 300/500/600)
- CSS 302KB → 274KB
- `fetchpriority="high"` + preload cho ảnh LCP, lazy cho ảnh còn lại
- Thêm `width`/`height` cho ảnh (chống layout shift — CLS 0.001)
- Cache-Control cho asset tĩnh

## Backup

`backups/tpc_web_prod-YYYYMMDD.sql` — dump thủ công:

```bash
/opt/homebrew/opt/mysql@8.0/bin/mysqldump -h 127.0.0.1 -u root -p \
  --no-tablespaces --single-transaction tpc_web_prod > backups/$(date +%Y%m%d).sql
```
