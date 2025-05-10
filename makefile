.PHONY: install dev

install:
	@echo "📦 Menghapus database Laravel jika ada..."
	mysql -u root -p -e "DROP DATABASE IF EXISTS  laravel;"
	
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
	php artisan queue:clear
	php artisan queue:work

dev:
	@echo "📦 Menjalankan composer install..."
	composer install

	@echo "⚙️ Menjalankan php artisan..."
	php artisan key:generate
	php artisan migrate --force
	php artisan db:seed --force
	php artisan storage:link
	php artisan optimize
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache
	php artisan event:cache
	php artisan queue:clear


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
