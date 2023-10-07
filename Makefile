all: install run migrate seed
install:
	composer install
run:
	./vendor/bin/sail up -d
migrate:
    # check mysql to be ready before doing db migration or seeding
    pass=$(. ./.env ; echo $DB_PASSWORD); \
	while ! ./vendor/bin/sail exec mysql bash -c " mysqladmin ping -u sail -p$(echo $pass)"; do \
        sleep 2; \
    done; \
    # when mysql is ready and ready to listen, run migrate
    ./vendor/bin/sail artisan migrate
seed: migrate
    pass=$(. ./.env ; echo $DB_PASSWORD); \
	while ! ./vendor/bin/sail exec mysql bash -c " mysqladmin ping -u sail -p$(echo $pass)"; do \
        sleep 2; \
    done; \
	./vendor/bin/sail artisan db:seed
restart:
	./vendor/bin/sail restart
stop:
	./vendor/bin/sail stop
rebuild:
	./vendor/bin/sail build --no-cache