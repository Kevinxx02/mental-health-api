Domain.md
# Domain Model

## Purpose

This document defines the business domain of the application.

Its objective is to establish a common language between developers and domain experts before implementation begins.

The Domain Model describes business concepts, rules and behaviors independently from technical concerns such as databases, frameworks or APIs.

---

# Business Context

The application models a small portion of a Mental Health platform.

The only business capability implemented during the first iteration is **Therapy Session Management**.

A therapy session represents an appointment between a patient and a therapist scheduled for a specific date and time.

---

# Ubiquitous Language

The following terms have a precise meaning within the project.

## Session

A therapy appointment between one patient and one therapist.

A Session has its own identity and lifecycle.

---

## Patient

A person receiving mental health care.

During the first iteration, patients are represented only by their identifier.

Patient management is outside the project's scope.

---

## Therapist

A mental health professional conducting therapy sessions.

Therapists are represented only by their identifier.

Therapist management is outside the project's scope.

---

## Scheduled Session

A session that has been created and is waiting to occur.

This is the default state of every new session.

---

## Cancelled Session

A scheduled session that has been cancelled before completion.

A cancelled session is considered finished.

---

## Completed Session

A scheduled session that has been successfully conducted.

A completed session is considered finished.

---

# Aggregate

The primary aggregate of the system is:

* Session

No additional aggregates exist during the first iteration.

---

# Entity

## Session

The Session entity represents the lifecycle of a therapy appointment.

A Session owns its state and is responsible for protecting its business rules.

A Session should never enter an invalid state.

---

# Value Objects

The following Value Objects are expected to appear during implementation.

* SessionId
* PatientId
* TherapistId
* SessionStatus
* ScheduledAt

Additional Value Objects may be introduced if they improve expressiveness.

---

# Lifecycle

Every Session follows the same lifecycle.

```text id="kjb75j"
Scheduled
     │
     ├────────► Cancelled
     │
     └────────► Completed
```

Once a Session reaches a final state, it cannot transition to another state.

---

# Business Rules

The first iteration defines the following business rules.

## BR-001

A new Session is always created with the Scheduled status.

## BR-002

A Session cannot be scheduled in the past.

## BR-003

A Session must start during business hours.

## BR-004

A Session lasts exactly 30 minutes.

## BR-005

A Patient cannot have overlapping Sessions.

## BR-006

A Cancelled Session cannot be completed.

## BR-007

A Completed Session cannot be cancelled.

# Invariants

The Session entity is responsible for protecting the following invariants.

* A Session always has an identifier.
* A Session always has one Patient.
* A Session always has one Therapist.
* A Session always has one scheduled date.
* A Session always has one valid status.

These conditions must always be true throughout the entity's lifecycle.

---

# Use Cases

The Domain supports the following business actions.

* Create Session
* Get Session
* List Sessions
* Cancel Session
* Complete Session

No additional behaviors exist during the first iteration.

---

# Domain Boundaries

The Domain does not manage:

* Authentication
* Authorization
* Patient records
* Therapist records
* Clinical history
* Notifications
* Billing
* Reports

Those concerns belong to future iterations.

---

# Future Evolution

The Domain has been intentionally designed to support future extensions without breaking the existing model.

Possible future additions include:

* Session rescheduling
* Session notes
* Session outcomes
* Notifications
* Audit trail
* External calendar integration
* Domain Events

These features are intentionally excluded from the first iteration.
