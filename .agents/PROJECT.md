# Project: Ministry of Labour Website Finalization

## Architecture
- PHP/MySQL application with a standard shared hosting architecture (e.g., cPanel, Bluehost).
- Tailwind CSS via `input.css` compiled to standard CSS files.
- `includes/` directory for standard header, footer, etc.
- `admin/` directory for the backend management.

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| 1 | SEO Optimization | Update meta tags, Open Graph, semantic HTML tags across public pages. Modify header logic to support dynamic SEO metadata per page. | none | DONE |
| 2 | Backend & Deployment Readiness | Verify forms (`process-contact.php`, `check-room-availability.php`), DB connections (`admin/includes/db.php`). Add PHP comments and structure code for shared hosting. | none | IN_PROGRESS (075e4a80) |
| 3 | UI Polish & Tailwind | Optimize Tailwind CSS classes. Ensure UI consistency for elements like toasters, notifications, and modals. Avoid separate component file proliferation. | none | IN_PROGRESS (cd142cd4) |
| 4 | Final E2E Test Suite Pass | Implement tests for Tiers 1-4. Harden with Adversarial coverage (Tier 5). Require 100% pass rate. | M1, M2, M3, E2E-READY | PLANNED |

## Interface Contracts
### Public Pages ↔ includes/header.php
- Pages should set variables (e.g., `$pageTitle`, `$metaDescription`, `$ogImage`) before including `header.php`. `header.php` must render these dynamically.

### Forms ↔ Backend Scripts
- Form submissions must cleanly handle validation and return user-friendly UI toasters/notifications.
- Database scripts must run on standard PHP/MySQL setups without external daemon requirements.

## Code Layout
- Public pages: `*.php` in root.
- Includes: `includes/` directory.
- Admin Panel: `admin/` directory and `admin/includes/`.
- Assets & CSS: `assets/`, `input.css`, `tailwind.config.js`.
