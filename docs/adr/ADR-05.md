# ADR-005: Use Named Constructors for Entity Creation

**Status:** Accepted

## Context

Public constructors expose implementation details and allow entities to be instantiated without expressing business intent.

Entity creation itself is part of the business process and should communicate the ubiquitous language.

## Decision

Entities should expose Named Constructors instead of public constructors whenever creation represents a business action.

Constructors should remain private or protected.

For example:

```php
Session::schedule(...)
```

is preferred over:

```php
new Session(...)
```

Named Constructors are responsible for creating valid entities while enforcing initial business invariants.

## Consequences

### Positive

* More expressive code.
* Creation reflects business language.
* Prevents invalid entity initialization.
* Centralizes creation rules.

### Negative

* Requires additional factory methods.
* Slightly less familiar for developers accustomed to public constructors.
