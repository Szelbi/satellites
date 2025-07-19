# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Symfony 7.3 workbench application built with PHP 8.4, featuring satellite tracking, todo management, weather integration, and 
multi-language support. The application uses Doctrine ORM for database operations and includes features like user authentication, contact forms, and a translation system.

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

**IMPORTANT**: After making changes to SCSS files, ALWAYS rebuild CSS with `docker exec workbench-app bin/console sass:build -q`

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

### Domain-Driven Design Structure

The application follows DDD (Domain-Driven Design) principles with bounded contexts organized into modules:

#### Core Modules (Bounded Contexts)
- **Satellite**: Core satellite tracking functionality
- **Todo**: Task management system
- **Weather**: Weather data integration
- **User**: Authentication and user management
- **Communication**: Email and messaging services
- **Shared**: Common utilities and cross-cutting concerns

#### DDD Layer Structure
Each module follows a consistent 4-layer architecture:

**Domain Layer** (`Domain/`):
- `Entity/`: Core business entities and domain models
- `Repository/`: Repository interfaces (contracts)
- `Service/`: Domain services with business logic
- `ValueObject/`: Value objects and domain-specific data structures

**Application Layer** (`Application/`):
- `Command/`: Command handlers for write operations (CQRS)
- `Query/`: Query handlers for read operations (CQRS)
- `Service/`: Application services orchestrating domain logic
- `Dto/`: Data Transfer Objects for application boundaries

**Infrastructure Layer** (`Infrastructure/`):
- `Repository/`: Concrete repository implementations
- `Service/`: External service integrations
- `Persistence/`: Database and storage implementations

**User Interface Layer** (`UserInterface/`):
- `Web/Controller/`: HTTP controllers for web interface
- `Web/Form/`: Symfony form types
- `Cli/Command/`: Console commands
- `Api/`: API controllers (if applicable)

#### Shared Components
The `Shared/` module contains:
- **Domain traits**: Common entity traits (IdTrait, TimestampableEntityTrait, PositionTrait, etc.)
- **Application services**: Cross-cutting application concerns
- **Infrastructure**: Shared persistence and external service integrations
- **UI components**: Common controllers and form utilities

### Key Features
- **Satellite tracking**: Core functionality for satellite data management
- **Todo management**: Task tracking with CRUD operations
- **Weather integration**: External API integration with WeatherApi.com
- **Multi-language**: English/Polish translation support
- **User system**: Authentication with role-based access
- **Email verification**: User registration with email verification workflow

### Database
- Uses Doctrine ORM with MySQL
- Entities use shared traits from `Shared/Domain/Entity/Trait/` for common fields
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
- `src/`: Application source code organized in DDD modules
  - `src/Satellite/`: Satellite tracking bounded context
  - `src/Todo/`: Todo management bounded context
  - `src/Weather/`: Weather integration bounded context
  - `src/User/`: User management bounded context
  - `src/Communication/`: Email and messaging bounded context
  - `src/Shared/`: Shared utilities and cross-cutting concerns
  - `src/Service/`: Legacy services (being migrated to bounded contexts)
- `templates/`: Twig templates
- `assets/`: Frontend assets (SCSS, JS)
- `translations/`: Language files (en, pl)
- `config/`: Symfony configuration
- `migrations/`: Database migrations
- `tests/`: Unit and integration tests organized by bounded context

## Testing & Quality

The project uses PHPUnit for testing with a structure organized by bounded contexts:
- **Unit tests**: Located in `tests/Unit/` following the DDD module structure
- **Integration tests**: For testing module interactions and external dependencies
- **Run tests**: `docker exec workbench-app vendor/bin/phpunit` or `docker exec workbench-app composer test`
- **Test configuration**: `phpunit.dist.xml`

Example test paths:
- `tests/Unit/Service/MailerServiceTest.php`: Legacy service tests
- `tests/Unit/Service/Application/`: Application service tests
- `tests/Unit/Service/Infrastructure/`: Infrastructure service tests

## Code Style Guidelines

### DDD Architecture Rules
- **Bounded Context Isolation**: Each module (`Satellite/`, `Todo/`, `Weather/`, etc.) should be self-contained
- **Layer Dependencies**: Follow dependency direction: UserInterface → Application → Domain ← Infrastructure
- **No Cross-Module Dependencies**: Modules should not directly depend on each other (use events or shared interfaces)
- **Domain First**: Start with Domain layer when implementing new features

### PHP Class Structure
**NEVER put multiple classes in a single file.** Each class must have its own separate file following PSR-4 autoloading standards. This includes:
- Main classes and their DTOs/Value Objects
- Exception classes
- Interfaces and implementations
- Enums and data structures

Always create separate files for better maintainability, autoloading, and code organization.

### Naming Conventions
- **Entities**: Singular nouns (e.g., `User`, `Satellite`, `Todo`)
- **Services**: End with `Service` or `Handler` (e.g., `UserRegistrationHandler`, `WeatherApiHandler`)
- **Commands/Queries**: Descriptive action names (e.g., `CreateUserCommand`, `GetProjectListQuery`)
- **DTOs**: End with `Dto` (e.g., `WeatherApiResponseDto`, `VerificationResult`)

### File Formatting
**ALWAYS end files with a single empty line.** This follows Git and POSIX standards for proper file formatting.

### Translation System
**CRITICAL**: All user-facing content MUST use the translation system. NEVER add hardcoded text in any language.

#### Translation Requirements
- **Templates**: Use `{{ 'translation.key'|trans }}` for all text content
- **PHP Code**: Inject `TranslatorInterface` and use `$translator->trans('key')`
- **Form Labels**: Use translation keys in form field options: `'label' => 'form.field_name'`
- **Flash Messages**: Always use `$translator->trans('message.key')` instead of hardcoded strings
- **Email Subjects**: Use translation keys in EmailBuilder service

#### Translation Files
- **English**: `translations/messages.en.yaml`
- **Polish**: `translations/messages.pl.yaml`
- Both files must be kept in sync with identical key structure


#### Before Adding New Content
1. Add translation keys to both `messages.en.yaml` and `messages.pl.yaml`
2. Use the translation system from the start - never hardcode first
3. Test content in both languages before finalizing

## Testing Policy

**CRITICAL**: After making ANY code changes, ALWAYS run unit tests to ensure nothing is broken.

### Running Tests
- **Command**: `docker exec workbench-app vendor/bin/phpunit --no-coverage --stop-on-failure`
- **When to run**: After every code modification
- **Requirement**: All tests MUST pass before proceeding with additional changes

### Test-Driven Development Flow
1. Make code changes
2. Run unit tests immediately
3. Fix any failing tests before continuing
4. Only then proceed with next changes

**Note**: The pre-push git hook will automatically run tests before allowing push to remote repository.
