# Handoff Report: Milestone 2 Reviewer Feedback Analysis

## Observation
1. **Raw Error Leak in `ampara-circuit-bungalow.php`:**
   At line 52 of `ampara-circuit-bungalow.php`, the catch block is implemented as:
   ```php
   } catch (PDOException $e) {
       $error = "Failed to submit booking: " . $e->getMessage();
       if ($isAjax || $acceptsJson) {
           error_log($error);
           ...
   ```
   If the request is not AJAX (fallback submission), the script continues and outputs the `$error` variable into the HTML later on (line 183). This directly prints the raw `PDOException` message to the user's browser.

2. **Toast Fallback Issue in `ampara-circuit-bungalow.php`:**
   In the JavaScript block (lines 1213-1258), the script attempts to locate a toast container:
   ```javascript
   const toast = document.getElementById('toast');
   const toastMessage = document.getElementById('toast-message');
   ```
   These elements do not exist in the DOM. Consequently, the condition `if(toast && toastMessage)` fails, forcing the script to fall back to `alert()`.

3. **Toast Issue in `contact-us.php`:**
   The reviewer mentioned `contact-us.php`, but upon reviewing the current state of `contact-us.php` (lines 425-450), the JavaScript is *already* properly utilizing `window.showToast()`. The reviewer's feedback either referred to a prior state of the file or grouped both files together.

## Logic Chain
- Exposing `$e->getMessage()` in a production environment leaks internal database structure and query details. The error message should be sent only to `error_log()`, and a generic message should be assigned to the user-facing `$error` variable.
- For the frontend, relying on hardcoded DOM IDs for the toast container breaks when those IDs are missing. `assets/js/main.js` already provides a global `window.showToast()` utility which dynamically injects the required toast HTML. Calling this global function resolves the UI issue.

## Caveats
- No caveats. The issues were clearly verified in the code.

## Conclusion
The critical PDOException leak in `ampara-circuit-bungalow.php` is verified. The frontend script in `ampara-circuit-bungalow.php` must also be refactored to use the global `window.showToast()` utility. `contact-us.php` appears to have already been fixed to use `window.showToast()`.

### Recommended Fix/Implementation Strategy
1. **`ampara-circuit-bungalow.php` (Backend Fix)**:
   Change the `catch` block (lines 51-59) to decouple logging from the user-facing error variable:
   ```php
   } catch (PDOException $e) {
       error_log("Failed to submit booking: " . $e->getMessage());
       if ($isAjax || $acceptsJson) {
           header('Content-Type: application/json');
           echo json_encode(['success' => false, 'message' => 'Database error while submitting booking.']);
           exit;
       }
       $error = "Database error while submitting booking.";
   }
   ```

2. **`ampara-circuit-bungalow.php` (Frontend Fix)**:
   Replace the `document.getElementById('toast')` logic within the `fetch` handlers (lines ~1213-1258). Use the pattern already present in `contact-us.php`:
   ```javascript
   if (window.showToast) {
       window.showToast(data.message || 'Booking request submitted successfully!', 'success');
   } else {
       alert(data.message || 'Booking request submitted successfully!');
   }
   ```
   Apply this consistently for both the `.then` (success/error paths) and `.catch` blocks.

## Verification Method
1. **Backend Verification**: Intentionally misconfigure the database credentials in `admin/includes/db.php`. Submit a booking request to `ampara-circuit-bungalow.php` without using AJAX (e.g., by disabling JS or submitting directly via an API tool that ignores AJAX headers). Verify the HTML response displays "Database error while submitting booking." instead of the raw `PDOException`.
2. **Frontend Verification**: With correct credentials, submit a valid booking request via the form on `ampara-circuit-bungalow.php`. Verify that a styled toast notification appears on the screen instead of a native browser `alert()` dialog.
