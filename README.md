### Workbench project build on PHP 8.3 and Symfony 6.3

## Requirements
- docker

## Installation
1. On host: `docker compose up -d`
2. Enter container and run `bin/install`  
3. [optional] Get your Weather API Key from https://www.weatherapi.com and add it to `.env.local.php`

---

App will be available at `localhost:8001`

---

- Sass build with "watch" - `php bin/console sass:build -w`
- JS map rebuild - `php bin/console  importmap:update`

---
### TODO
- wybór języka (+ tłumaczenia całej strony)
- logowanie(autoryzacja, sesja)
- powiadomienia do todo
- panel użytkownika
