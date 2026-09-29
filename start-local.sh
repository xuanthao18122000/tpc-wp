#!/usr/bin/env bash
#
# Chạy WordPress bằng PHP built-in server (không cần Docker).
#
#   ./start-local.sh          # cổng mặc định 8090
#   ./start-local.sh 8095     # chỉ định cổng khác
#
set -euo pipefail

PORT="${1:-8090}"
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/opt/homebrew/opt/php@8.3/bin/php"

[ -x "$PHP" ] || PHP="$(command -v php)"

if [ -z "$PHP" ]; then
  echo "Chưa có PHP. Cài bằng: brew install php@8.3" >&2
  exit 1
fi

# MySQL phải chạy trước. Không hardcode mật khẩu ở đây — chỉ kiểm tra
# cổng 3306 có ai lắng nghe không là đủ. Thông tin kết nối thật nằm
# trong wp-config.php (file này không đưa lên git).
if ! nc -z 127.0.0.1 3306 >/dev/null 2>&1; then
  echo "MySQL chưa chạy. Khởi động bằng: brew services start mysql@8.0" >&2
  exit 1
fi

if lsof -nP -iTCP:"$PORT" -sTCP:LISTEN >/dev/null 2>&1; then
  echo "Cổng $PORT đang bận. Chạy lại với cổng khác: ./start-local.sh 8095" >&2
  exit 1
fi

# Built-in server mặc định xử lý MỘT request tại một thời điểm. Trang
# wp-admin gọi nhiều request song song (admin-ajax, heartbeat, CSS/JS)
# nên hay bị treo hoặc đứt kết nối -> trình duyệt báo 404/không tải được.
# PHP_CLI_SERVER_WORKERS cho phép fork nhiều tiến trình con xử lý song song.
WORKERS="${PHP_CLI_SERVER_WORKERS:-8}"

echo "WordPress:  http://localhost:$PORT"
echo "Quản trị:   http://localhost:$PORT/wp-admin"
echo "Workers:    $WORKERS"
echo "Dừng:       Ctrl+C"
echo

# router.php xử lý permalink đẹp cho built-in server.
PHP_CLI_SERVER_WORKERS="$WORKERS" exec "$PHP" -S "localhost:$PORT" -t "$ROOT" "$ROOT/router.php"
