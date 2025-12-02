.PHONY: install new run fix

install:
	docker run --rm --interactive --tty --volume $$(pwd):/app composer:latest install

new:
	docker run --rm -ti -v $$(pwd):/app/ php:8.5-cli php app/run.php aoc:new

run:
	docker run --rm -ti -v $$(pwd):/app/ php:8.5-cli php app/run.php aoc:run

fix:
	docker run --rm -ti -v $$(pwd):/app/ php:8.5-cli php app/vendor/bin/php-cs-fixer fix
