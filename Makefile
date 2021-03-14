setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate --seed
lint:
	composer phpcs --
lint-fix:
	composer phpcbf --
deploy:
	git push heroku
log:
	tail -f storage/logs/laravel.log
start:
	php artisan serve --host localhost
test-coverage:
	composer phpunit -- tests --whitelist tests --coverage-clover coverage-report
test:
	php artisan test
build:
	npm install
	npm run watch
