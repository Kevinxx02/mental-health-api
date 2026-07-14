# ADR-004: Represent Business Concepts with Value Objects

## Status

**Accepted**

## Context

Primitive types such as strings, integers and DateTime objects provide little semantic meaning and allow invalid values to propagate throughout the application.

Business concepts deserve explicit representations.

## Decision

Business concepts should be modeled as Value Objects whenever they improve expressiveness and enforce business rules.

Examples include:

* SessionId
* PatientId
* TherapistId
* ScheduledAt
* SessionStatus

Value Objects should be immutable.

They should validate their own invariants whenever appropriate.

## Consequences

### Positive

* More expressive domain model.
* Increased type safety.
* Better encapsulation of business rules.
* Reduced reliance on primitive values.

### Negative

* More classes.
* Additional mapping required during persistence.
