# Chạy WordPress local (không Docker)

## Bước 1 — Cài PHP (chỉ làm một lần)

```bash
brew install php@8.3
```

> Tôi không cài hộ được: Homebrew cần quyền đọc `~/.gitconfig` mà môi trường
> của tôi bị chặn. Bạn chạy lệnh này trong Terminal của mình.

Mất khoảng 5–10 phút vì phải biên dịch vài thư viện.

## Bước 2 — Chạy

```bash
cd /Users/cps/Documents/fls/tps/tp-wp
./start-local.sh
```

- Web: http://localhost:8090
- Quản trị: http://localhost:8090/wp-admin — `admin` / `TinPhat@2026`
- Dừng: `Ctrl+C`

Đổi cổng nếu 8090 bận: `./start-local.sh 8095`

## Thành phần

| | |
|---|---|
| WordPress | 7.0.4 (khớp database hiện có) |
| PHP | 8.3, chạy bằng built-in server |
| MySQL | 8.0 trên máy, DB `tpc_web_prod` |
| Web server | Không cần — `php -S` là đủ cho dev |

`router.php` xử lý permalink vì built-in server không có mod_rewrite.

## Khác gì bản Docker

- **Dữ liệu giống hệt** — cùng một MySQL, cùng database
- WordPress core giờ nằm trong thư mục dự án (trước ở volume Docker)
- Không cần bật Docker Desktop
- Nhanh hơn, ít tốn RAM

Bản Docker vẫn dùng được: `docker compose start`. Hai bản dùng chung
database nên **đừng chạy cả hai cùng lúc trên cùng một cổng**.

## Nếu gặp lỗi

**"MySQL chưa chạy"**
```bash
brew services start mysql@8.0
```

**"Cổng đang bận"** → dùng cổng khác: `./start-local.sh 8095`

**Lỗi PHP extension** — WordPress cần `mysqli`, `gd`, `mbstring`.
Bản `php@8.3` của Homebrew có sẵn cả ba. Kiểm tra:
```bash
/opt/homebrew/opt/php@8.3/bin/php -m | grep -E "mysqli|gd|mbstring"
```

## Ghi chú

- `wp-config.php` và WordPress core **không đưa vào git** (đã thêm `.gitignore`)
- Máy khác clone về cần: tải lại core + chạy `make seed`
