TestingStrategy.md
# Testing Strategy

## Purpose

Testing validates business behavior, not implementation details.

The objective is to ensure that the application behaves correctly as it evolves.

---

# Testing Levels

    Testing Pyramid

```text
Unit Tests

↓

Feature Tests

↓

Mutation Testing

↓

Static Analysis
```text

## Unit Tests

Unit Tests validate the Domain and Application layers without requiring Laravel.

Characteristics:

* Fast.
* Independent from Laravel.
* Independent from the database.
* Focused on business rules.

Examples:

* A completed session cannot be cancelled.
* A cancelled session cannot be completed.

---

## Feature Tests

Feature Tests validate the complete HTTP flow.

Characteristics:

* Execute Laravel.
* Validate endpoints.
* Verify HTTP responses.
* Verify persistence.

Examples:

* Creating a session returns HTTP 201.
* Cancelling a session updates its status.
* Listing sessions returns the expected collection.

---

## Mutation Testing

Mutation Testing evaluates the effectiveness of the automated test suite.

Instead of executing the application normally, it introduces small changes (mutations) into the source code.

A mutation is considered killed when at least one automated test detects the behavioral change.

The project targets a Mutation Score Indicator (MSI) of 100%.

# What Should Be Tested

Every important business rule.

Every business invariant.

Every Value Object.

Every Domain Exception.

Every HTTP endpoint.

Every bug before it is fixed.

---

# What Should Not Be Tested

Laravel internals.

PHP internals.

Framework behavior already covered by Laravel itself.

---

# Testing Principles

Tests should be:

* Independent.
* Repeatable.
* Readable.
* Deterministic.
* Fast.

Each test should validate one behavior.

---

# Naming

Test names should describe behavior.

Examples:

```text
it_creates_a_session()

it_cannot_complete_a_cancelled_session()

it_returns_a_404_when_session_does_not_exist()
```

---

# Goal

Testing should provide confidence to refactor the code without fear of breaking existing functionality.

# Static Analysis
Static Analysis complements automated testing by validating code before execution.

The project uses:

- PHPStan Level 8
- Larastan

Static Analysis verifies:

- Type safety
- Interface contracts
- Invalid method calls
- Dead code
- Architectural consistency

# Test Coverage
Code Coverage is monitored to identify untested areas of the application.

Coverage should be interpreted together with Mutation Testing.

High coverage alone does not guarantee effective tests.

# Quality Gates

Every contribution should pass:

```text
Pint

↓

PHPStan

↓

PHPUnit

↓

Feature Tests

↓

Mutation Testing

↓

GitHub Actions
```
