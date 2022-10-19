Set up:
- docker-compose build
- docker-compose up -d
- docker exec -it php bash
- composer install
- composer db-reset

Urls:
- localhost:8003
- swagger: localhost:8003/api/doc

Tests:
- php bin/phpunit tests/unit
- php bin/phpunit tests/functional
