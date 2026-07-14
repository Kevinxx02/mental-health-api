# ADR-009: Adopt Continuous Integration with GitHub Actions

## Status

**Accepted**

## Context

The project is intended to demonstrate production-ready backend development practices. While local quality tools help developers identify issues before committing code, they cannot guarantee that every contributor executes the same validation process.

A centralized and reproducible validation mechanism is required to ensure that every change is built and verified in a clean environment before being merged into the main branch.

Continuous Integration (CI) provides an automated quality gate that validates every push and pull request independently of the developer's local environment.

## Decision

The project adopts **GitHub Actions** as its Continuous Integration platform.

Every push and pull request targeting the main branches automatically triggers a workflow that:

* Builds the complete Docker environment.
* Starts the application and database containers.
* Waits for the infrastructure to become available.
* Installs project dependencies.
* Executes Laravel Pint to verify coding standards.
* Runs PHPStan and Larastan for static analysis.
* Executes the complete PHPUnit test suite.
* Generates a code coverage report.
* Fails immediately if any validation step does not succeed.

The CI pipeline executes inside isolated GitHub-hosted runners, ensuring every validation starts from a clean and reproducible environment.

## Consequences

### Positive

* Every code change is validated automatically.
* Eliminates dependency on developers' local environments.
* Detects integration issues before code is merged.
* Ensures consistent execution of quality checks.
* Increases confidence in the stability of the main branch.
* Provides immediate feedback when regressions are introduced.
* Demonstrates modern DevOps and software delivery practices.

### Negative

* Increases pipeline execution time.
* Requires maintenance of the CI workflow configuration.
* Consumes GitHub Actions runner resources.
* Infrastructure-related failures may occasionally affect pipeline execution.

Despite these trade-offs, Continuous Integration significantly improves reliability, reproducibility, and confidence in the software delivery process, making it an essential component of the project's development workflow.
