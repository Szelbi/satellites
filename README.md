### Satellites project build on PHP 8.2 and Symfony 6.3

## Requirements
- docker
- docker-compose

## Installation

`docker-compose up -d`

Within container:  
`composer install`

---

App will be available at `localhost:8006`



---

- Sass build - `php bin/console sass:build -w`
- JS map rebuild - `php bin/console  importmap:update`

---
### TODO
- logowanie(autoryzacja, sesja)
- powiadomienia do todo
- panel użytkownika
