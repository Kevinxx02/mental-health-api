# Mental Health API

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20)
![PHPStan](https://img.shields.io/badge/PHPStan-Level%208-success)
![Mutation](https://img.shields.io/badge/Mutation%20Score-100%25-success)
![Coverage](https://img.shields.io/badge/Coverage-98.2%25-success)
![License](https://img.shields.io/badge/license-Portfolio-blue)

RESTful API for managing therapy sessions built with Laravel 13, demonstrating enterprise backend practices including Domain-Driven Design (DDD), Hexagonal Architecture, Clean Architecture, automated testing, and continuous integration.

The project focuses on building production-quality backend software by combining rich domain modeling, automated quality gates, static analysis, automated testing, Dockerized development and Continuous Integration.

## Features

- Schedule a therapy session
- Complete a therapy session
- Cancel a therapy session
- Reschedule a therapy session
- Retrieve a therapy session
- List all therapy sessions

## Tech Stack

### Backend

- PHP 8.3
- Laravel 13
- MariaDB 11
- Apache

### Development

- Docker
- Docker Compose

### CI/CD

- GitHub Actions

### Documentation

- OpenAPI 3.1 (Swagger)
- Mermaid.js
- Architecture Decision Records (ADR)

---

# Requirements

The following software must be installed:

- Docker
- Docker Compose

No local installation of PHP, Composer or MariaDB is required.

---

# Installation

Clone the repository and start the containers:

```bash
git clone <repository-url>
cd mental-health-api
cp .env.example .env
docker compose up --build -d
```

During the first startup the application automatically:

- Installs Composer dependencies
- Generates the Laravel application key
- Waits for MariaDB to become available
- Executes the database migrations
- Starts Apache

Once the containers are running, the API is ready to use.

---

# Accessing the API

Base URL:

```
http://localhost:8000
```

Example endpoint:

```
GET http://localhost:8000/api/sessions
```

---

# API Documentation

Interactive Swagger UI documentation is available at:

```
http://localhost:8000/docs
```

The raw OpenAPI specification is located at:

```
docs/openapi.yaml
```

---

# Testing

Run the test suite:

```bash
docker compose exec app php artisan test
```

Generate code coverage:

```bash
docker compose exec app php artisan test --coverage
```

Generate an HTML coverage report:

```bash
docker compose exec app vendor/bin/phpunit --coverage-html coverage
```

---

# Project Structure

```
Application
    Ports
        In
        Out
    Session
        ScheduleSession
        ShowSession
        CancelSession
        CompleteSession
        RescheduleSession
        ListSessions

Domain
    Session
        Entities
        ValueObjects
        Exceptions
        Repositories

Infrastructure
    Persistence
    Http
    Providers
```

---

# Design Principles

This project follows:

- Domain-Driven Design (DDD)
- Clean Architecture
- Hexagonal Architecture
- SOLID Principles
- Repository Pattern
- Dependency Injection
- Value Objects
- Rich Domain Model

---

## Continuous Integration

GitHub Actions automatically validates every push and pull request.

The pipeline performs:

- Docker build
- Dependency installation
- Laravel Pint
- PHPStan
- PHPUnit
- Code Coverage
- Mutation Testing

---

## Quality Assurance

The project enforces code quality through multiple automated tools:

- Laravel Pint (PSR-12 code style)
- PHPStan Level 8
- Larastan
- PHPUnit
- Code Coverage (98.2% coverage)
- GrumPHP pre-commit hooks
- GitHub Actions Continuous Integration
- Mutation Testing (100% MSI)
- Composer Audit

Local commits are validated through GrumPHP pre-commit hooks, while GitHub Actions verifies every push and pull request.

---

# Development Commands

Start the containers:

```bash
docker compose up -d
```

Rebuild the containers:

```bash
docker compose up --build -d
```

Stop the containers:

```bash
docker compose down
```

Stop the containers and remove the database volume:

```bash
docker compose down --volumes --remove-orphans
```

Restart the containers:

```bash
docker compose restart
```

Run database migrations:

```bash
docker compose exec app php artisan migrate
```

Rollback the last migration:

```bash
docker compose exec app php artisan migrate:rollback
```

Clear Laravel caches:

```bash
docker compose exec app php artisan optimize:clear
```

Open a shell inside the application container:

```bash
docker compose exec app bash
```

Run Laravel Pint:

```bash
docker compose exec app ./vendor/bin/pint
```

Run PHPStan:

```bash
docker compose exec app ./vendor/bin/phpstan analyse
```

Run PHPUnit:

```bash
docker compose exec app php artisan test
```

Generate Coverage:

```bash
docker compose exec app php artisan test --coverage
```

```bash
docker compose exec -T app vendor/bin/infection --min-msi=100 --min-covered-msi=100
```

---

# Roadmap

- [x] Schedule session
- [x] Complete session
- [x] Cancel session
- [x] Reschedule session
- [x] Retrieve a session
- [x] List all sessions
- [x] Dockerized development environment
- [x] Swagger UI integration
- [x] Continuous Integration Pipeline
- [x] Static Analysis (PHPStan)
- [x] Code Coverage Reports
- [x] Mutation Testing (Infection PHP)
- [x] Architecture Diagrams
- [x] PHP Metrics Report
- [x] Project Badges
- [x] Security Analysis (Composer Audit / CodeQL)

## Future Improvements

- [ ] GitHub Release Workflow

---

## Documentation

Detailed project documentation is available in the `docs` directory.

- Project documentation: `docs/README.md`
- OpenAPI specification: `docs/openapi.yaml`

---

# License

This project is intended for educational and portfolio purposes.
