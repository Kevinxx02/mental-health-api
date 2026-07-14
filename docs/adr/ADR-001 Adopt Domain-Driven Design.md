# ADR-001: Adopt Domain-Driven Design

**Status:** Accepted

## Context

The objective of this project is not only to build a functional REST API, but also to demonstrate modern backend architecture and software engineering practices.

The application models a business domain rather than a collection of CRUD operations. Business rules, terminology and behavior should remain independent from technical concerns such as frameworks, databases or HTTP.

A traditional Laravel application often places business logic inside Controllers, Models or Services, making the domain tightly coupled to the framework.

## Decision

The project will adopt a Domain-Driven Design (DDD) inspired architecture.

Business logic will be organized into clearly separated layers:

* Domain
* Application
* Infrastructure
* Interface

The Domain layer will contain the business model and remain independent from Laravel.

Laravel will be treated as an implementation detail responsible for exposing HTTP endpoints and integrating with external systems.

## Consequences

### Positive

* Clear separation of responsibilities.
* Improved maintainability.
* Better testability.
* Framework-independent business logic.
* Easier future evolution.

### Negative

* Increased initial complexity.
* More classes than a traditional Laravel application.
* Longer learning curve.
