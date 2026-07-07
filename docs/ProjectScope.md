ProjectScope.md
# Project Scope

## Project Overview

This project consists of developing a REST API using Laravel, following a Domain-Driven Design (DDD) inspired architecture.

The purpose of the project is **not** to build a complete Mental Health Management System. Instead, it aims to demonstrate professional backend development practices through a small, well-designed, and maintainable application.

The project is intentionally scoped to simulate a technical assessment with an estimated implementation time of two days.

The focus is software quality rather than feature quantity.

---

# Project Goals

The primary objective is to demonstrate the ability to build a professional backend application while applying modern software engineering principles.

The project should demonstrate knowledge of:

* PHP 8.4
* Laravel 12
* MariaDB
* Domain-Driven Design (DDD)
* SOLID Principles
* Clean Code
* REST API Design
* Automated Testing
* OpenAPI / Swagger
* Docker
* Git

Success is measured by architecture, maintainability, code quality and testing rather than by the number of implemented features.

---

# Business Domain

The project models a small part of a Mental Health platform.

Only one business capability is implemented:

**Therapy Session Management**

The API is responsible for managing the lifecycle of therapy sessions.

No additional business domains are included in this iteration.

---

# Functional Scope

Version 1 of the project includes the following use cases:

## Create Session

Create a new therapy session.

Business rules will be validated before the session is created.

---

## Get Session

Retrieve a therapy session by its identifier.

---

## List Sessions

Retrieve the list of registered therapy sessions.

Pagination may be added in future iterations.

---

## Cancel Session

Cancel a previously scheduled session.

Business rules determine whether cancellation is allowed.

---

## Complete Session

Mark a scheduled session as completed.

Business rules determine whether completion is allowed.

---

# Initial Business Rules

The first iteration defines the following business rules:

* Every session is created with the **Scheduled** status.
* A cancelled session cannot be completed.
* A completed session cannot be cancelled.
* A patient cannot have two sessions scheduled for the same date and time.

Additional rules may be introduced in future iterations if required.

---

# API Scope

The API exposes only the endpoints required to support the defined use cases.

```text
POST    /api/v1/sessions

GET     /api/v1/sessions

GET     /api/v1/sessions/{id}

PATCH   /api/v1/sessions/{id}/cancel

PATCH   /api/v1/sessions/{id}/complete
```

No additional endpoints are included in Version 1.

---

# Out of Scope

The following features are explicitly excluded from the initial version.

## Authentication & Authorization

* User authentication
* Role management
* Permissions
* OAuth
* JWT
* Laravel Sanctum

---

## Business Features

* Patient management
* Therapist management
* Clinical records
* Diagnoses
* Treatments
* Scheduling calendar
* Notifications
* Email delivery
* SMS integration
* Billing
* Payments
* Reports
* Dashboards

---

## Infrastructure

* Redis
* Queues
* Background Jobs
* Event-driven architecture
* Message brokers
* Microservices
* External API integrations

---

## Frontend

This project does not include any frontend application.

The backend will be consumed exclusively through its REST API.

Testing and interaction will be performed using tools such as Swagger UI or API clients.

---

# Technical Scope

The project includes:

* REST API
* Laravel
* MariaDB
* Domain-Driven Design architecture
* Repository Pattern (when appropriate)
* Value Objects
* Unit Tests
* Feature Tests
* OpenAPI / Swagger documentation
* Docker environment
* Git version control

---

# Project Constraints

To remain aligned with the objectives of a technical assessment, the following constraints apply:

* The project intentionally maintains a small scope.
* Only one business capability will be implemented.
* Every implemented feature must provide architectural value.
* Features that do not contribute to the learning objectives should be avoided.
* Simplicity is preferred over unnecessary abstraction.

---

# Success Criteria

The project will be considered successful if:

* The API correctly implements the defined business rules.
* The Domain remains independent from Laravel.
* The architecture is clean and easy to understand.
* Responsibilities are clearly separated.
* Automated tests validate the expected behavior.
* OpenAPI documentation accurately describes the API.
* The application can be executed both locally and through Docker.

---

# Future Iterations

Future versions of the project may include:

* Authentication with Laravel Sanctum
* External API integrations
* Domain Events
* Observer Pattern
* Strategy Pattern
* Specification Pattern
* Advanced filtering
* Pagination
* Audit logging
* Static analysis
* CI/CD pipeline
* Code coverage reports

These features are intentionally excluded from Version 1 to preserve the project's limited scope.
