# Scope: Milestone 2 (Backend & Deployment Readiness)

## Architecture
- PHP/MySQL application with standard shared hosting architecture.

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| 2 | Backend & Deployment Readiness | Verify forms (`process-contact.php`, `check-room-availability.php`), DB connections (`admin/includes/db.php`). Add PHP comments and structure code for shared hosting. | none | IN_PROGRESS |

## Interface Contracts
### Forms ↔ Backend Scripts
- Form submissions must cleanly handle validation and return user-friendly UI toasters/notifications.
- Database scripts must run on standard PHP/MySQL setups without external daemon requirements.
