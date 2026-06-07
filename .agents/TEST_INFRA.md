# E2E Test Infra: Ministry of Labour Website

## Test Philosophy
- Opaque-box, requirement-driven. No dependency on implementation design.
- Methodology: Category-Partition + BVA + Pairwise + Workload Testing.
- Python-based test suite using `pytest`, `requests`, and `BeautifulSoup`.
- Tests will spin up a temporary PHP built-in server (`php -S localhost:8000`) connected to a test database if necessary, or just test the endpoints.

## Feature Inventory
| # | Feature | Source (requirement) | Tier 1 | Tier 2 | Tier 3 |
|---|---------|---------------------|:------:|:------:|:------:|
| 1 | Public Page Load & SEO | R1, Programmatic Verification | 5      | 5      | ✓      |
| 2 | Contact Form Submission | R2, Programmatic Verification | 5      | 5      | ✓      |
| 3 | Room Availability Check | R2 | 5      | 5      | ✓      |
| 4 | Article & Gallery Load | R2 | 5      | 5      | ✓      |

## Test Architecture
- Test runner: `pytest` executed via a wrapper script `run_e2e_tests.sh` or `run_e2e_tests.ps1` that starts the PHP server, runs tests, and shuts down the server.
- Test case format: Python `pytest` functions.
- Directory layout: `c:\xampp\htdocs\Ministry-of-Labour\tests`

## Real-World Application Scenarios (Tier 4)
| # | Scenario | Features Exercised | Complexity |
|---|----------|--------------------|------------|
| 1 | End User Flow: Browse Home -> View About -> Submit Contact Form | 1, 2 | Medium |
| 2 | End User Flow: View Bungalow -> Check Availability | 1, 3 | Low |
| 3 | Admin User Flow: Try to access admin without login | 4 | Low |

## Coverage Thresholds
- Tier 1: ≥5 per feature
- Tier 2: ≥5 per feature (where boundaries exist)
- Tier 3: pairwise coverage of major feature interactions
- Tier 4: ≥5 realistic application scenarios
