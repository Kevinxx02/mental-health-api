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

---

# Application Layer

Each Use Case should represent one business action.

Examples:

* CreateSession
* CancelSession
* CompleteSession

Use Cases should orchestrate business operations without containing business rules.

---

# Infrastructure

Infrastructure contains implementation details.

Examples:

* Eloquent
* Database access
* External services
* Persistence

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

---

# Formatting

The project follows the PSR-12 coding standard.

Formatting should be enforced automatically whenever possible.
