.PHONY: install

install:
	@echo "📦 Menjalankan composer install..."
	composer install --no-dev --optimize-autoloader

	@echo "🔐 Mengatur permission vendor dan storage..."
	chown -R www-data:www-data storage bootstrap/cache
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache

	@echo "⚙️ Menjalankan php artisan app:install..."
	php artisan app:install

migrate:
	@ehco "Menjalankan fresh migrate"
	php artisan migrate:fresh --force

seed:
	@echo "Menjalankan database seed"
	php artisan db:seed --force

caddy:
	@echo "🔐 Mengatur permission vendor dan storage..."
	chown -R caddy:caddy storage bootstrap/cache
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache

user:
	@echo "🔐 Mengatur permission vendor dan storage..."
	chown -R $USER:$USER storage bootstrap/cache
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache