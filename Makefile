all: install run migrate seed
install:
	composer install
run:
	./vendor/bin/sail up -d
migrate:
	sleep 5
	./vendor/bin/sail artisan migrate
seed:
	./vendor/bin/sail artisan db:seed
restart:
	./vendor/bin/sail restart
stop:
	./vendor/bin/sail stop
rebuild:
    ./vendor/bin/sail build --no-cache