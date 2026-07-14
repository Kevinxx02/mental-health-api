# ADR-006: Containerize the Development Environment

## Status

**Accepted**

## Context

The project should be easy to set up by any developer without requiring local installation of infrastructure dependencies such as MariaDB.

Keeping infrastructure isolated from the host operating system improves reproducibility and minimizes environment-specific issues. Additionally, the project is intended to demonstrate modern backend development practices commonly used in professional teams.

## Decision

Infrastructure dependencies are executed inside Docker containers using Docker Compose.

Initially, the application container and the MariaDB database are containerized, allowing the complete development environment to be started with a single command.

## Consequences

### Positive

- Consistent development environment across machines.
- No local installation of MariaDB is required.
- Simplifies onboarding for new developers.
- Infrastructure can be recreated at any time.
- Aligns the project with modern backend development workflows.
- Provides a foundation for Continuous Integration and future deployments.

### Negative

- Requires Docker and Docker Compose.
- Slightly increases startup time compared to native execution.
- Developers must be familiar with basic Docker commands.
