

SHELL := /bin/bash

reload:
	@echo "♻️  droping  database..."
	symfony console doctrine:database:drop --force  
	@echo "♻️  creating  database..."	
	symfony console doctrine:database:create  			
	@echo "♻️  charging config tables  ..."
	symfony console doctrine:schema:update --force 
	@echo "♻️  loaging  fixtures..."
	symfony console doctrine:fixtures:load -n

new:
	composer install
	composer require symfonycasts/tailwind-bundle
	php bin/console tailwind:init
	php bin/console tailwind:build --watch

run:
	php bin/console tailwind:build --watch

compose:
	rm -rf var/cache/*
	rm -rf vendor/
	composer install

.PHONY: reload

