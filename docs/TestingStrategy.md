TestingStrategy.md
# Testing Strategy

## Purpose

Testing validates business behavior, not implementation details.

The objective is to ensure that the application behaves correctly as it evolves.

---

# Testing Levels

The project uses two primary testing levels.

## Unit Tests

Unit Tests validate the Domain.

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

# What Should Be Tested

Every important business rule.

Every Use Case.

Every API endpoint.

Every identified bug before fixing it.

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
