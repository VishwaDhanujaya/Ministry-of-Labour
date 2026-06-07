# Handoff Report: Milestone 2 Iteration 1 Reviewer Feedback Analysis

## Observation
1. **PDOException Leak**: In `ampara-circuit-bungalow.php` (line 52), the raw database error message is assigned to the `$error` variable: `$error = "Failed to submit booking: " . $e->getMessage();`. This variable is rendered directly into the HTML on line 185 `<?= htmlspecialchars($error) ?>` when the script falls back to non-AJAX handling.
2. **Toast Element Lookup**: I searched both `contact-us.php` and `ampara-circuit-bungalow.php` for `document.getElementById('toast')` and `id="toast"`. Neither exists in the current codebase.
3. **Current Toast Logic**: In `contact-us.php` (lines 425-447) and `ampara-circuit-bungalow.php` (lines 1216-1238), the scripts use `if (window.showToast) { window.showToast(...) } else { alert(...) }`. 
4. **Toast Registration**: `window.showToast` is registered globally in `assets/js/main.js` inside a `DOMContentLoaded` event listener (line 401).

## Logic Chain
1. The reviewer correctly identified a security/UX issue with the raw `PDOException` leaking in `ampara-circuit-bungalow.php`. The catch block uses `error_log` inside the `if ($isAjax)` condition, but fails to use it for the standard form POST fallback, resulting in the raw message being exposed to the user.
2. Regarding the toast issue, the reviewer claimed the scripts attempt to find an `id="toast"` element. The current files do not do this. They check for the existence of `window.showToast` and execute it, falling back to `alert()` only if it's undefined.
3. Because form submission requires human interaction, `DOMContentLoaded` will have already fired by the time the submit handler executes. Thus, `window.showToast` will be defined, and the script will successfully trigger the toast, never hitting the `alert()` fallback unless JavaScript fails to load `main.js` entirely.

## Caveats
1. The reviewer's feedback regarding `id="toast"` may have been accurate for a previous iteration or commit, but the issue is not present in the current codebase state.
2. The reviewer might simply be objecting to the *presence* of the `alert()` fallback branches in the code, misinterpreting them as actively executing. While defensively sound, they could be removed to strictly satisfy a reviewer requesting 100% toast usage.

## Conclusion
1. **Fix Strategy for PDO Leak**: Update `ampara-circuit-bungalow.php` lines 52-53. Replace the direct concatenation with an `error_log()` call and assign a generic message to `$error`.
   ```php
   error_log("Failed to submit booking: " . $e->getMessage());
   $error = "Database error while submitting booking. Please try again later.";
   ```
2. **Fix Strategy for Toasts**: No functional fix is strictly required since `window.showToast` is already used and `id="toast"` is not queried. However, to fully satisfy the reviewer and remove any ambiguity, the developer should strip the `if (window.showToast) ... else { alert(...) }` logic and directly invoke `window.showToast(...)` in both `contact-us.php` and `ampara-circuit-bungalow.php`.

## Verification Method
1. **PDO Leak**: Intentionally break the database query in `ampara-circuit-bungalow.php` and submit a standard POST request (non-AJAX). Verify that the UI displays the generic error and `error_log` captures the PDO trace.
2. **Toasts**: Submit forms on both `contact-us.php` and `ampara-circuit-bungalow.php` via UI to confirm that a visual toast appears and no native `alert()` dialog is triggered.
