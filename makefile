.PHONY: install

install:
	@echo "📦 Menjalankan composer install..."
	composer install --no-dev --optimize-autoloader

	@echo "⚙️ Menjalankan php artisan app:install..."
	php artisan app:setup

	@echo "🔐 Mengatur access user storage..."
	sudo chown -R www-data:www-data storage bootstrap/cache
	sudo chgrp -R www-data storage bootstrap/cache

	@echo "🔐 Mengatur permission vendor dan storage..."
	sudo chmod -R 755 vendor
	sudo chmod -R 775 storage bootstrap/cache

	@echo "🔐 Set env ke production..."
	sh ./set-production.sh

	@echo "🔐 Mengatur permission vendor dan storage..."
	php artisan queu:clear
	php artisan queu:work

migrate:
	@ehco "Menjalankan fresh migrate"
	php artisan migrate:fresh --force

group:
	sudo chgrp -R www-data storage bootstrap/cache

seed:
	@echo "Menjalankan database seed"
	php artisan db:seed --force

caddy:
	@echo "🔐 Mengatur permission vendor dan storage..."
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache
	chown -R www-data:www-data storage bootstrap/cache

user:
	@echo "🔐 Mengatur permission vendor dan storage..."
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache
	sudo chown -R $USER:$USER storage bootstrap/cache
