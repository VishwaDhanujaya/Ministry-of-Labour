# Scope: M1 - SEO Optimization

## Architecture
- PHP/MySQL application with a standard shared hosting architecture.
- `includes/header.php` needs to be updated to support dynamic SEO metadata.
- Public pages need to set variables before including `header.php`.

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| 1 | SEO Optimization | Update meta tags, Open Graph, semantic HTML tags across public pages. Modify header logic to support dynamic SEO metadata per page. | none | DONE |

## Interface Contracts
### Public Pages ↔ includes/header.php
- Pages should set variables (e.g., `$pageTitle`, `$metaDescription`, `$ogImage`) before including `header.php`. `header.php` must render these dynamically.
