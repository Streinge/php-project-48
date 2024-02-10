install:
	composer install

gendiff:
	./bin/gendiff

validate:
	composer validate

autoload:
		composer dump-autoload