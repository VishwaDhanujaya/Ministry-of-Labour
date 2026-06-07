# Scope: E2E Test Suite Creation

## Architecture
- Pytest based test suite.
- Uses `requests` and `BeautifulSoup` to parse HTML and verify tags.
- Helper fixture to start/stop local PHP server and create DB if needed.

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| 1 | Infrastructure & Tier 1 | Setup `tests/conftest.py`, basic server startup, and Tier 1 tests (Happy path SEO, Form, availability, page load) | none | PLANNED |
| 2 | Tier 2 & 3 | Tier 2 (Boundary/Corner cases like invalid form submissions) and Tier 3 (Cross-feature interactions) | M1 | PLANNED |
| 3 | Tier 4 | Real-world application scenarios, End-to-End flows | M2 | PLANNED |

## Interface Contracts
### Test Runner ↔ System Under Test
- Test runner starts `php -S localhost:8000 -t ..`
- Base URL: `http://localhost:8000`
- Tests perform HTTP requests to `index.php`, `about-us.php`, `contact-us.php`, `process-contact.php`, etc.
