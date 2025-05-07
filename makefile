.PHONY: install

install:
	@echo "📦 Menjalankan composer install..."
	composer install --no-dev --optimize-autoloader

	@echo "🔐 Mengatur permission vendor dan storage..."
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache

	@echo "⚙️ Menjalankan php artisan app:install..."
	php artisan app:setup

	@echo "🔐 Mengatur access user storage..."
	sudo chown -R www-data:www-data storage bootstrap/cache

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