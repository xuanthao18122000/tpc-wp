.PHONY: up down restart logs cli shell build watch seed fresh local

local:         ## Chạy bằng PHP built-in server (không cần Docker)
	./start-local.sh

up:            ## Khởi động stack Docker
	docker compose up -d

down:          ## Dừng stack
	docker compose down

restart:       ## Khởi động lại
	docker compose restart

logs:          ## Xem log WordPress
	docker compose logs -f wordpress

cli:           ## Chạy lệnh wp: make cli CMD="plugin list"
	docker compose exec -T wpcli wp $(CMD) --allow-root

shell:         ## Vào shell container WordPress
	docker compose exec wordpress bash

build:         ## Build CSS + JS của theme
	cd wp-content/themes/tinphat && npm run build

watch:         ## Build theo dõi thay đổi (dev)
	cd wp-content/themes/tinphat && npm run dev

seed:          ## Chạy toàn bộ script seed
	docker compose exec -T wpcli wp eval-file /scripts/setup-languages.php --allow-root
	docker compose exec -T wpcli wp eval-file /scripts/setup-polylang-options.php --allow-root
	docker compose exec -T wpcli wp eval-file /scripts/seed-pages.php --allow-root
	docker compose exec -T wpcli wp eval-file /scripts/seed-projects.php --allow-root

fresh:         ## Xoá sạch DB và cài lại (CẨN THẬN)
	docker compose down -v
	docker compose up -d
