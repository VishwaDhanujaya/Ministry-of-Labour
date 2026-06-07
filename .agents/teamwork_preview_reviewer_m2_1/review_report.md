## Review Summary

**Verdict**: REQUEST_CHANGES

## Findings

### [Critical] Sensitive Error Leakage on Non-AJAX Fallback
- **What**: Raw `PDOException` messages are exposed to the user when submitting the booking form synchronously.
- **Where**: `ampara-circuit-bungalow.php` (lines 52, 185)
- **Why**: In the `catch (PDOException $e)` block, the variable `$error` is set to include `$e->getMessage()`. If the request is not an AJAX request (e.g., if JS is disabled or fails), this raw exception string is rendered directly into the HTML via `<?= htmlspecialchars($error) ?>`. This violates the requirement to use `error_log` instead of raw outputting sensitive errors.
- **Suggestion**: Log the raw error unconditionally (`error_log($e->getMessage());`). Set `$error` to a safe, generic message like "Database error while submitting booking" for the HTML rendering path.

### [Major] Frontend Toast Implementation Failure
- **What**: Form submissions still rely on raw `alert()` dialogs for success/error feedback.
- **Where**: `contact-us.php` (lines 400-401, 435, 448), `ampara-circuit-bungalow.php` (lines 1213-1214, 1227, 1238)
- **Why**: Both scripts look for a toast element using `document.getElementById('toast')`. Since this element is never defined in the HTML structure (neither in the page itself nor in `header.php`/`footer.php`), the `toast` variable is always `null`. Consequently, the scripts always hit the `else { alert(...) }` fallback branch.
- **Suggestion**: Utilize the globally available `window.showToast(message, type)` function defined in `assets/js/main.js`, which dynamically creates and injects the toast UI into the DOM.

## Verified Claims
- DB DB Connection config correctly supports environment variables and uses strict PDO attributes → verified via code inspection.
- The `.env` file is properly blocked in `.htaccess` via Apache directives → verified via code inspection.
- Mailer in `process-contact.php` correctly logs errors and returns generic JSON → verified via code inspection.

## Unverified Items
- PHP syntax via `php -l` → Not directly run due to command execution environment constraints, but manual visual inspection of the code confirmed no obvious syntax errors.
