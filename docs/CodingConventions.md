CodingConventions.md
# Coding Conventions

## Purpose

This document defines the coding conventions used throughout the project.

Its goal is to improve readability, maintainability and consistency across the codebase.

Consistency is preferred over personal preference.

---

# Language

All source code must be written in English.

This includes:

* Class names
* Interfaces
* Methods
* Variables
* Constants
* Enums
* Comments
* Commit messages
* Documentation

---

# Naming

Classes should represent business concepts.

Examples:

```text
Session
CreateSession
SessionRepository
SessionStatus
```

Class names should use **PascalCase**.

Methods and variables should use **camelCase**.

Constants should use **UPPER_SNAKE_CASE**.

Database tables should use **snake_case**.

---

# Responsibility

Every class should have a single responsibility.

Large classes should be split before they become difficult to understand.

---

# Controllers

Controllers must remain thin.

Controllers should only:

* Receive HTTP requests.
* Invoke the corresponding Use Case.
* Return HTTP responses.

Business logic must never be placed inside controllers.

---

# Domain

The Domain layer must not depend on Laravel.

Business rules belong exclusively to the Domain.

Primitive values should be replaced by Value Objects whenever they improve expressiveness.

## Value Objects should:

* Be immutable.
* Validate their own invariants.
* Expose meaningful behavior.
* Avoid primitive obsession.
---

# Application Layer

Each Use Case should represent one business action.

Use Cases should implement the corresponding Input Port.

Use Cases should not depend on framework-specific classes.

Commands and Responses should be used to communicate with the Interface layer.

Examples:

* CreateSession
* CancelSession
* CompleteSession

Use Cases should orchestrate business operations without containing business rules.

---

# Infrastructure

Infrastructure contains the concrete adapters required by the application.

Examples:

* Eloquent
* Database access
* External services
* Persistence
* Mappers

Infrastructure must never contain business decisions.

---

# Functions

Functions should:

* Perform one task.
* Have descriptive names.
* Avoid excessive length.
* Minimize side effects.

---

# Comments

Code should be self-explanatory whenever possible.

Comments should explain **why**, not **what**.

---

# Clean Code

The project follows these general principles:

* Prefer readability over clever solutions.
* Avoid duplicated code.
* Keep methods small.
* Avoid unnecessary abstractions.
* Refactor continuously.
* Make illegal states impossible whenever practical.
* Methods should return early whenever possible.
* Deep nesting should be avoided.

---

# Formatting

The project follows the PSR-12 coding standard.

Formatting is automatically enforced using Laravel Pint.

# Classes

Classes should be declared as `final` whenever inheritance is not required.

Immutable classes should use `readonly` when appropriate.

Inheritance should be preferred only when it models a real "is-a" relationship.

# Dependency Injection

Dependencies should be injected through constructors.

Service location should be avoided.

Interfaces should be preferred over concrete implementations.

# Exceptions

Business rule violations should be represented as Domain Exceptions.

Infrastructure exceptions should remain inside the Infrastructure layer whenever possible.

HTTP exceptions should be generated only by the Interface layer.

# Repository Pattern

Repository interfaces belong to the application core.

Concrete implementations belong to the Infrastructure layer.

Repositories should expose business-oriented operations rather than persistence details.

# Type Safety

Strict typing must be enabled in every PHP file.

Native PHP types should be preferred whenever possible.

PHPDoc should complement native types rather than replace them.

# PHPDoc

PHPDoc should only be used when native type declarations are insufficient.

Examples include:

* Generic collections
* Array shapes
* Template annotations
* Complex return types

# Ports

Input Ports define the operations exposed by the application.

Output Ports define the dependencies required by the application.

Concrete implementations should never be referenced directly from the Interface layer.
