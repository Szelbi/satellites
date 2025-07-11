### Workbench project build on PHP 8.3 and Symfony 7.2

## Requirements
- docker

## Installation
1. On host: `docker compose up -d`
2. Enter container and run `bin/install`

- By default emails will be send to mailgoh service. Its available at `http://localhost:8025/`. 
Optionally you can add your real sender email configuration (etc. `MAILER_DSN=smtp://<mail>>:<app_password>@smtp.gmail.com:587`) to `.
env.local`  
- To get real weather info you need to create Weather API account at https://www.weatherapi.com and provide its API Key to `.env.local`
(`WEATHER_API_KEY=<api_key>`)

---

App will be available at `http://localhost:8001`  
Mailhog service: `http://localhost:8025`  
Admin login: `admin@mail.com:admin`  

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
