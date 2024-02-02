### Satellites project build on PHP 8.2 and Symfony 6.3

## Requirements
- docker
- docker-compose

## Installation

`docker-compose up -d`

Within container:  
`composer install`  
`php bin/install`  
`php bin/console sass:build`  

---

App will be available at `localhost:8006`



---

- Sass build with "watch" - `php bin/console sass:build -w`
- JS map rebuild - `php bin/console  importmap:update`

---
### TODO
- uprawnienia do folderów projektu (www-data)
- logowanie(autoryzacja, sesja)
- powiadomienia do todo
- panel użytkownika
