install:
	composer install

gendiff:
	./bin/gendiff

validate:
	composer validate

autoload:
	composer dump-autoload

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin

say-hello:
	echo "Hello World!"