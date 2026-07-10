# Mental Health API

REST API for managing therapy sessions, built with Laravel following Domain-Driven Design (DDD) principles.

## Features

* Schedule a therapy session
* Complete a session
* Cancel a session
* Reschedule a session
* Retrieve a session
* List all sessions

## Tech Stack

* PHP 8.3
* Laravel 13
* MariaDB 11
* Apache
* Docker & Docker Compose
* PHPUnit
* OpenAPI 3.1

---

# Requirements

The following software must be installed:

* Docker
* Docker Compose

No local installation of PHP, Composer or MariaDB is required.

---

# Installation

Clone the repository:

```bash
git clone <repository-url>
cd mental-health-api
```

Copy the environment file:

```bash
cp .env.example .env
```

Build and start the containers:

```bash
docker compose up --build -d
```

Install PHP dependencies:

```bash
docker compose exec app composer install
```

Generate the Laravel application key:

```bash
docker compose exec app php artisan key:generate
```

Run the database migrations:

```bash
docker compose exec app php artisan migrate
```

---

# Accessing the API

The application will be available at:

```
http://localhost:8000
```

Example endpoint:

```
GET http://localhost:8000/api/sessions
```

---

# Running Tests

Execute the complete test suite:

```bash
docker compose exec app php artisan test
```

---

# API Documentation

The OpenAPI specification is located at:

```
docs/openapi.yaml
```

It can be opened using Swagger UI or any OpenAPI-compatible tool.

---

# Project Structure

```
app/
 ├── Application
 ├── Domain
 ├── Infrastructure
 └── Http
```

The project follows a layered Domain-Driven Design architecture:

* Domain contains the business rules.
* Application contains the use cases.
* Infrastructure contains persistence implementations.
* Http contains controllers, requests and resources.

---

# Useful Commands

Restart containers:

```bash
docker compose restart
```

Stop containers:

```bash
docker compose down
```

Remove containers and database volume:

```bash
docker compose down --volumes --remove-orphans
```

Rebuild containers:

```bash
docker compose up --build -d
```

Run migrations:

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
