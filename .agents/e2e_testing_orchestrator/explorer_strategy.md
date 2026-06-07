# E2E Pytest Suite Implementation Strategy

## Overview
This strategy outlines the implementation of a comprehensive, opaque-box E2E test suite (Tiers 1-4) using `pytest`, `requests`, and `BeautifulSoup`. As the application is not yet ready, tests will be written to target a dummy base URL. Execution will be limited to syntax and collection checks (`pytest --collect-only`).

## 1. Structure of `tests/conftest.py`
The `conftest.py` file will serve as the configuration and fixture entry point for the test suite.

**Proposed Fixtures:**
- `base_url`: Returns a dummy URL (e.g., `http://localhost:8000`) for test cases to build endpoints. Once the app is ready, this will be integrated with the PHP built-in server startup logic.
- `session`: Provides a `requests.Session()` object to maintain state (e.g., cookies) across multi-step scenarios, especially useful for Tier 4.

## 2. Helper Functions for HTML Parsing
To keep tests clean and maintainable, a separate module `tests/helpers.py` (or directly inside `conftest.py` as fixtures or normal python functions) will be created.

**Proposed Helpers:**
- `get_soup(response_text)`: Parses HTML and returns a `BeautifulSoup` object (`"html.parser"`).
- `assert_seo_tags(soup, expected_title, expected_desc_snippet)`: Asserts the `<title>` matches and the `<meta name="description">` contains the expected text.
- `assert_form_fields(soup, form_locator, expected_fields)`: Asserts that a form contains the required `input`/`textarea`/`select` fields.
- `extract_csrf_token(soup)`: Finds and returns a CSRF token from a form, if applicable.
- `assert_success_message(soup, expected_text)`: Checks for a standard success alert/banner in the DOM.
- `assert_error_message(soup, expected_text)`: Checks for a standard error alert/banner in the DOM.

## 3. Test Files Organization
The test files will be explicitly separated by Tiers to align with the milestones in `SCOPE.md`.

### Tier 1: Happy Path (Baseline Functionality)
- **`test_tier1_public_pages.py`**: Verifies that public pages (Home, About, Contact, Bungalows, etc.) load successfully (HTTP 200) and contain expected SEO tags.
- **`test_tier1_forms.py`**: Happy path for Contact Form submission with valid data.
- **`test_tier1_availability.py`**: Happy path for Room Availability check using valid future dates.
- **`test_tier1_assets.py`**: Verifies that Articles and Gallery modules load without errors and render items.

### Tier 2: Boundary & Corner Cases (Invalid Inputs)
- **`test_tier2_forms.py`**: Form validation scenarios (missing required fields, invalid email format, exceedingly long inputs, XSS payloads).
- **`test_tier2_availability.py`**: Boundary cases for availability (past dates, end date before start date, empty dates).
- **`test_tier2_pages.py`**: Accessing non-existent pages (404 handling) or missing query parameters.

### Tier 3: Interactions & Pairwise Testing
- **`test_tier3_interactions.py`**: Cross-feature interactions. For example:
  - Submitting a contact form after checking room availability.
  - Submitting multiple form requests consecutively (rate-limiting check).
  - Navigating through gallery items and triggering an inquiry.

### Tier 4: Real-World Scenarios (End-to-End User Flows)
- **`test_tier4_scenarios.py`**: Exercises full user journeys with multiple steps.
  - *Scenario 1*: User arrives at Home -> navigates to About -> proceeds to Contact Us -> successfully submits the form.
  - *Scenario 2*: User browses Bungalows -> opens details -> checks availability for valid dates.
  - *Scenario 3*: Admin access attempts -> Try accessing restricted admin/login paths and assert redirect/forbidden.

## 4. Execution Protocol
Since the backend is not implemented yet, tests must ONLY be validated for syntax and collection.
- **Command**: `pytest --collect-only tests/`
- All tests should be written standardly (e.g., `response = requests.get(base_url + "/about-us.php")`), but no active testing should be attempted until the backend infrastructure is provisioned.
