# ADR-003: Use Repository Pattern for Persistence

## Status

**Accepted**

## Context

Business logic requires access to persisted entities.

Allowing the Domain or Application layers to communicate directly with Eloquent would couple business logic to the persistence mechanism.

Persistence is considered an implementation detail.

## Decision

Repository interfaces will be defined inside the Domain layer.

Concrete implementations will be placed in the Infrastructure layer.

Repositories represent collections of Domain Entities rather than database tables.

Repository methods should express business intent instead of database operations.

Examples:

* save()
* findById()
* findAll()
* existsOverlappingSession()

## Consequences

### Positive

* Domain remains persistence-agnostic.
* Easier testing through mocks or stubs.
* Infrastructure can change without affecting business logic.
* Repository methods use the ubiquitous language.

### Negative

* Additional abstraction layer.
* Requires mapping between Entities and persistence models.
