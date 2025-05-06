# Makefile untuk setup Laravel secara ringkas

.PHONY: install

install:
	@echo "📦 Menjalankan composer install..."
	composer install --no-dev --optimize-autoloader

	@echo "🔐 Mengatur permission vendor dan storage..."
	chmod -R 755 vendor
	chmod -R 775 storage bootstrap/cache
	chown -R www-data:www-data storage bootstrap/cache

	@echo "⚙️ Menjalankan php artisan app:install..."
	php artisan app:install
