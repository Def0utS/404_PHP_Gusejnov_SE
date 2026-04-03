.PHONY: install

install:
	composer install
	cp -n .env.example .env 2>/dev/null || true
	php artisan key:generate
	php artisan migrate --force
