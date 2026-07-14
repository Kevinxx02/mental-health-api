# ADR-008: Use Static Analysis and Automated Code Quality Tools

## Status **Accepted**

## Context

The project aims to demonstrate production-quality backend development practices rather than simply implementing business functionality.

As the codebase grows, relying exclusively on manual code reviews and automated tests is not sufficient to detect architectural violations, type inconsistencies, coding standard deviations, or maintainability issues. Additionally, enforcing quality standards manually introduces inconsistency across contributors and development environments.

To maintain a predictable and high-quality codebase, quality checks should be automated and executed consistently throughout the development workflow.

## Decision

The project adopts a set of complementary automated quality tools that validate different aspects of the codebase.

The following tools are used:

* **PHPStan (Level 8)** to perform static analysis and detect type errors, unreachable code, incorrect API usage, and architectural inconsistencies.
* **Larastan** to extend PHPStan with Laravel-specific type analysis and framework awareness.
* **Laravel Pint** to automatically enforce a consistent coding style based on the PSR-12 standard.
* **GrumPHP** to execute quality checks before each commit, preventing code that violates project standards from entering version control.

Each tool addresses a different aspect of software quality:

* Laravel Pint ensures code style consistency.
* PHPStan and Larastan improve correctness and maintainability through static analysis.
* GrumPHP integrates these checks into the local development workflow, encouraging developers to resolve issues before committing changes.

These tools complement, rather than replace, automated testing.

## Consequences

### Positive

* Detects many programming errors before runtime.
* Encourages strong typing and safer code.
* Maintains a consistent coding style across the entire project.
* Reduces the likelihood of introducing regressions.
* Provides immediate feedback during development.
* Promotes maintainable and self-documenting code.
* Ensures quality checks are executed consistently before code is committed.

### Negative

* Increases the initial project setup complexity.
* Requires developers to understand and occasionally configure static analysis tools.
* Some false positives may require explicit annotations or configuration.
* Slightly increases development time due to automated validation before commits.

Despite these trade-offs, the benefits in maintainability, consistency, and long-term code quality outweigh the additional tooling complexity.
