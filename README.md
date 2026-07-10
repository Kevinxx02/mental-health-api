# Mental Health API

RESTful API for managing therapy sessions built with Laravel 13 following Domain-Driven Design (DDD) and Clean Architecture principles.

The project demonstrates the implementation of a rich domain model, application use cases, repository abstraction, Docker-based development environment, automated application setup and OpenAPI 3.1 documentation.

## Features

- Schedule a therapy session
- Complete a therapy session
- Cancel a therapy session
- Reschedule a therapy session
- Retrieve a therapy session
- List all therapy sessions

## Tech Stack

- PHP 8.3
- Laravel 13
- MariaDB 11
- Apache
- Docker & Docker Compose
- PHPUnit
- OpenAPI 3.1 (Swagger UI)

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

The project includes:

- Unit tests
- Integration tests

Run the complete test suite:

```bash
docker compose exec app php artisan test
```

---

# Project Structure

```
app
├── Application
│   └── Application use cases
├── Domain
│   ├── Entities
│   ├── Exceptions
│   ├── Repositories
│   └── Value Objects
├── Infrastructure
│   └── Persistence
└── Http
    ├── Controllers
    ├── Requests
    └── Resources
```

---

# Design Principles

This project follows:

- Domain-Driven Design (DDD)
- Clean Architecture
- SOLID Principles
- Repository Pattern
- Dependency Injection
- Value Objects
- Rich Domain Model

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
- [ ] Authentication
- [ ] Pagination
- [ ] Filtering
- [ ] CI/CD Pipeline
- [ ] Static Analysis (PHPStan)
- [ ] Code Coverage Reports

---

# License

This project is intended for educational and portfolio purposes.
