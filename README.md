### Workbench project build on PHP 8.3 and Symfony 7.2

## Requirements
- docker

## Installation
1. On host: `docker compose up -d`
2. Enter container and run `bin/install`
3. *[optional]* Get your Weather API Key from https://www.weatherapi.com and add it to `.env.local.php`

---

App will be available at `localhost:8001`  
Login `admin@mail.com:admin`

---
### Usefull commands
- Sass build with "watch" - `bin/console sass:build -w`
- JS map rebuild - `bin/console  importmap:update`
- Extract missing translations - `bin/translations`

---
### TODO
- login (autrorization, sessions)
- notifications in Todo list
- user Control panel
- unit tests
- codeception/codesniffer
- potwierdzanie maila przy rejestracji
- resetowanie hasla
- metody flash nie dzialaja
