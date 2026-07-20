# ADR-012 Adopt Hexagonal Architecture

## Status

Accepted

---

## Context

The project already followed Domain-Driven Design (DDD) and Clean Architecture principles.

Business rules were isolated from Laravel and infrastructure concerns through repository abstractions and dependency inversion.

As the project evolved, the application layer began exposing multiple use cases, making the interaction between external clients and the application core an explicit architectural concern.

To further decouple the application from its delivery mechanisms and improve long-term maintainability, the project adopts the Ports and Adapters (Hexagonal) architectural style.

---

## Decision

The application adopts Hexagonal Architecture by introducing explicit Input Ports and Output Ports.

Input Ports define the operations that external clients can invoke.

Output Ports define the dependencies required by the application layer.

Concrete implementations remain inside the Infrastructure layer.

Examples include:

- `ScheduleSessionUseCase` as an Input Port.
- `SessionRepository` as an Output Port.
- `EloquentSessionRepository` as the Infrastructure adapter implementing the Output Port.

Laravel controllers now depend on Input Ports instead of concrete use case implementations.

---

## Consequences

### Positive

- Better separation between the application core and framework-specific code.
- Controllers become independent from concrete handlers.
- Infrastructure can evolve without affecting business logic.
- The architecture becomes easier to extend with additional delivery mechanisms (CLI, queues, message brokers, gRPC, etc.).
- The dependency direction remains consistent with Clean Architecture principles.

### Negative

- Additional abstractions increase the number of interfaces.
- Dependency injection configuration becomes slightly more complex.
- The architecture introduces more files for relatively small features.

---

## Rationale

Hexagonal Architecture complements the existing DDD and Clean Architecture approach rather than replacing it.

DDD defines how the business model is represented.

Clean Architecture defines dependency direction.

Hexagonal Architecture defines how the application communicates with the outside world through explicit ports and adapters.

These approaches are complementary and together provide a maintainable and framework-independent architecture.

---

## Alternatives Considered

### Keep the previous layered architecture

The project could continue exposing concrete use case implementations directly to controllers.

This approach would work correctly but would couple the HTTP layer to application implementations instead of application contracts.

Introducing explicit ports better communicates architectural intent and simplifies future extensions.

---

## References

- Alistair Cockburn — Hexagonal Architecture (Ports and Adapters)
- Robert C. Martin — Clean Architecture
- Eric Evans — Domain-Driven Design
