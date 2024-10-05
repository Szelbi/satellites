### Satellites project build on PHP 8.2 and Symfony 6.3

## Requirements
- docker

## Installation

`docker compose up -d`

Within container:  
`composer install`  
`bin/install`  
`bin/update`  

Get your Weather API Key from https://www.weatherapi.com and add it to `.env.local.php`

---

App will be available at `localhost:8080`


---

- Sass build with "watch" - `php bin/console sass:build -w`
- JS map rebuild - `php bin/console  importmap:update`

---
### TODO
- wybór języka (+ tłumaczenia całej strony)
- uprawnienia do folderów projektu (www-data)
- zmienić użytkownika na kontenerze z root na system
- logowanie(autoryzacja, sesja)
- powiadomienia do todo
- panel użytkownika
