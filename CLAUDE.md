# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Symfony 7.2 workbench application built with PHP 8.3, featuring satellite tracking, todo management, weather integration, and multi-language support. The application uses Doctrine ORM for database operations and includes features like user authentication, contact forms, and a translation system.

## Development Environment

The project runs in Docker containers. Use these commands:

- **Start environment**: `docker compose up -d`
- **Setup application**: `bin/install` (run inside container)
- **Application URL**: `localhost:8001`
- **Default login**: `admin@mail.com:admin`
- **Container name**: `workbench-app`

## Essential Commands

**IMPORTANT**: All PHP/Symfony commands should be executed inside the Docker container using:
`docker exec workbench-app [command]`

### Build & Assets
- **Build CSS**: `docker exec workbench-app bin/console sass:build` or `docker exec workbench-app bin/build`
- **Build CSS with watch**: `docker exec workbench-app bin/console sass:build -w`
- **Update JS imports**: `docker exec workbench-app bin/console importmap:update`

### Development
- **Extract translations**: `docker exec workbench-app bin/translations`
- **Doctrine migrations**: `docker exec workbench-app bin/console doctrine:migrations:migrate`
- **Create user**: `docker exec workbench-app bin/console app:create-use [email] [password]`
- **Grant admin role**: `docker exec workbench-app bin/console app:grant-role [email] ROLE_ADMIN`
- **Clear cache**: `docker exec workbench-app bin/console cache:clear`

### Console Access
- **Symfony console**: `docker exec workbench-app bin/console` (access to all Symfony commands)
- **Interactive shell**: `docker exec -it workbench-app bash`

## Architecture

### Core Structure
- **Controllers**: Handle HTTP requests for different features (satellites, todos, weather, auth)
- **Entities**: Database models with traits for common functionality (timestamps, positioning, properties)
- **Services**: Business logic layer (SatelliteService, TodoService, WeatherApiService, MailerService)
- **Forms**: Symfony form types for user input handling
- **Commands**: Custom console commands for user management

### Key Features
- **Satellite tracking**: Core functionality for satellite data management
- **Todo management**: Task tracking with CRUD operations
- **Weather integration**: External API integration with WeatherApi.com
- **Multi-language**: English/Polish translation support
- **User system**: Authentication with role-based access

### Database
- Uses Doctrine ORM with MySQL
- Entities use traits for common fields (ID, timestamps, positioning)
- Migration-based schema management

### Frontend
- Twig templates with Bootstrap 5
- SASS compilation via Symfony Asset Mapper
- JavaScript modules managed through importmap

## Configuration

### Environment
- Set Weather API key in `.env.local.php` from https://www.weatherapi.com
- Docker configuration in `docker-compose.yml`

### Key Directories
- `src/`: Application source code
- `templates/`: Twig templates
- `assets/`: Frontend assets (SCSS, JS)
- `translations/`: Language files (en, pl)
- `config/`: Symfony configuration
- `migrations/`: Database migrations

## Testing & Quality

The project uses Symfony's standard testing structure. Run tests through the Symfony console or check for specific test scripts in composer.json.