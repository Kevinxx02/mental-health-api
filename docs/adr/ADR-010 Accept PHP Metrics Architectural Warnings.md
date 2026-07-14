# ADR-010: Accept PHP Metrics Architectural Warnings

## Status

**Accepted**

---

## Context

The project uses PHP Metrics to continuously evaluate architectural quality and maintainability.

During the analysis, PHP Metrics reports a small number of architectural warnings related to:

- Stable Abstractions Principle (SAP)
- Stable Dependencies Principle (SDP)

The affected packages include:

- App\Http\Requests
- App\Http\Resources
- App\Domain\Session\ValueObjects
- App\Domain\Session\Exceptions
- App\Domain\Session\Repositories
- App\Domain\Shared\ValueObjects
- App\Infrastructure\Persistence\Eloquent\Models

No Critical or Error violations were reported.

---

## Decision

The reported warnings are intentionally accepted.

The project follows Domain-Driven Design (DDD) and Clean Architecture.

Several packages intentionally contain concrete implementations because abstraction would not improve the design.

Examples include:

- Value Objects
- Domain Exceptions
- Laravel Form Requests
- API Resources
- Eloquent Models

Introducing interfaces or additional abstraction layers solely to satisfy software metrics would unnecessarily increase complexity without providing architectural benefits.

The project prioritizes clear domain modeling over achieving a perfect metrics score.

---

## Consequences

### Positive

- Preserves a simple and expressive domain model.
- Avoids unnecessary abstraction.
- Keeps Value Objects immutable and self-contained.
- Reduces maintenance overhead.
- Maintains compliance with DDD principles.

### Negative

- PHP Metrics will continue reporting a small number of SAP and SDP warnings.
- The project will not achieve a zero-warning metrics report.

These warnings are considered acceptable and do not represent architectural defects.
