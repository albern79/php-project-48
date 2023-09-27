
install: # установить зависимости
	composer install


validate: # проверить файл
	composer validate

lint: # запустить phpcs
	composer exec --verbose phpcs -- --standard=PSR12 src bin

gendiff: #запустить программ
	./bin/gendiff

test: # запустить тест
	composer exec --verbose phpunit tests