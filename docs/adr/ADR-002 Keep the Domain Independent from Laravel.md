# ADR-002: Keep the Domain Independent from Laravel

**Status:** Accepted

## Context

Laravel provides many convenient features such as Eloquent Models, HTTP Requests, Collections and helper functions.

While these features improve developer productivity, coupling the Domain to Laravel makes business logic difficult to reuse, test and evolve independently.

The Domain should represent the business, not the framework.

## Decision

The Domain layer must not depend on Laravel.

Specifically, Domain classes must not reference:

* Eloquent Models
* HTTP Requests or Responses
* Facades
* Service Container
* Laravel helper functions
* Framework-specific exceptions

The Domain should only depend on PHP and other Domain components.

## Consequences

### Positive

* Business logic can be tested without Laravel.
* Lower coupling.
* Greater portability.
* Clear architectural boundaries.

### Negative

* Additional mapping between Domain and Infrastructure.
* Slightly more implementation effort.
