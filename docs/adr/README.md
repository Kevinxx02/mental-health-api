# Architecture Decision Records (ADR)

This directory contains the **Architecture Decision Records (ADRs)** for the Mental Health API project.

ADRs document significant architectural decisions made during the development of the system. Each record captures the context in which the decision was made, the chosen solution, and its consequences. Their purpose is to preserve architectural knowledge, making it easier to understand why the system was designed the way it is.

## ADR Index

| ADR     | Status   | Description                                    |
| ------- | -------- | ---------------------------------------------- |
| ADR-001 | Accepted | Adopt Domain-Driven Design                     |
| ADR-002 | Accepted | Keep the Domain Independent from Laravel       |
| ADR-003 | Accepted | Use Repository Pattern for Persistence         |
| ADR-004 | Accepted | Represent Business Concepts with Value Objects |
| ADR-005 | Accepted | Use Named Constructors for Entity Creation     |
| ADR-006 | Accepted | Containerize the Development Environment       |
| ADR-007 | Accepted | Use UUID v7 as Entity Identifiers              |
| ADR-008 | Accepted | Static Analysis and Code Quality               |
| ADR-009 | Accepted | Continuous Integration Pipeline                |
| ADR-010 | Accepted | Accept PHP Metrics Architectural Warnings      |
| ADR-011 | Accepted | Adopt Mutation Testing                         |

## ADR Structure

Each ADR follows the same structure:

1. **Status** — Current state of the decision (Accepted, Superseded, Deprecated, etc.).
2. **Context** — The problem or motivation that led to the decision.
3. **Decision** — The architectural decision that was made.
4. **Consequences** — The positive and negative implications of adopting the decision.

This standardized format makes architectural decisions easy to review and maintain as the project evolves.

## References

* `../Architecture.md` — High-level system architecture.
* `../Domain.md` — Domain model and business rules.
* `../DevelopmentGuide.md` — Local development environment.
* `../TestingStrategy.md` — Testing approach and quality goals.
* `../CodingConventions.md` — Coding standards followed by the project.
