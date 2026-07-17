# ADR-011: Adopt Mutation Testing

## Status

**Accepted**

---

## Context

The project already includes several quality assurance tools, including:

- PHPUnit
- PHPStan (Level 8)
- Larastan
- Laravel Pint
- GrumPHP
- GitHub Actions

While these tools verify correctness, coding standards and static analysis, they cannot determine whether the test suite is capable of detecting changes in the application's behavior.

Mutation Testing addresses this limitation by intentionally introducing small changes (mutations) into the source code and verifying that the existing tests fail as expected.

This provides a more meaningful measure of test quality than code coverage alone.

---

## Decision

The project adopts **Infection PHP** as the mutation testing framework.

Mutation testing is integrated into the development workflow and executed as part of the Continuous Integration pipeline.

The project enforces the following minimum quality thresholds:

- Minimum Mutation Score Indicator (MSI): **100%**
- Minimum Covered Mutation Score Indicator (Covered MSI): **100%**

Any pull request or commit that does not satisfy these thresholds will fail the CI pipeline.

---

## Consequences

### Positive

- Increases confidence in the effectiveness of the test suite.
- Detects weak or incomplete tests.
- Encourages testing of boundary conditions and business rules.
- Prevents false confidence caused by high code coverage alone.
- Improves long-term maintainability.

### Negative

- Increases CI execution time.
- Mutation testing is computationally more expensive than traditional testing.
- Some mutations may be equivalent or harmless, requiring occasional manual review.

The additional execution time is considered an acceptable trade-off for the increased confidence in the correctness and robustness of the test suite.
