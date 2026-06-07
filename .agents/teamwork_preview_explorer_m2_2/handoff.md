# Backend & Deployment Readiness Analysis

## Observation
- **db.php**: Lines 26-28 use `catch(PDOException $e) { die("Database connection failed: " . $e->getMessage()); }`, which outputs a raw, plain text error and stack trace.
- **check-room-availability.php**: Lines 9-17 return JSON in the format `['error' => '...']`. However, the frontend JS handling this request (`ampara-circuit-bungalow.php:1109`) expects `data.message` and ignores `data.error`, rendering backend validation messages invisible.
- **process-contact.php**: Line 206 returns internal SMTP errors directly to the client: `echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);`.
- **contact-us.php**: The JS fetch handler (line 426) relies on a static `<div id="toast">` element. If missing, it falls back to a raw browser `alert()`.
- **Missing Comments**: None of the analyzed backend PHP scripts have file-level DocBlocks or adequate inline comments explaining their structure for shared hosting.

## Logic Chain
1. **DB Error Exposure & API Breakage**: If the database is offline, `db.php` immediately `die()`s with plain text. Since `check-room-availability.php` requires `db.php` at the very top, a DB failure causes the endpoint to return text instead of JSON. The frontend `res.json()` parser crashes, masking the real issue and violating the requirement for clean API contracts. Exposing `$e->getMessage()` is also a security vulnerability.
2. **Inconsistent API Schemas**: `check-room-availability.php` uses `error` keys, while `process-contact.php` uses `success` and `message` keys. This inconsistency prevents the frontend from accurately displaying backend validation messages.
3. **SMTP Error Exposure**: Returning `{$mail->ErrorInfo}` in `process-contact.php` leaks internal server/SMTP configuration details to the public on failure.
4. **Brittle Toaster Implementation**: Because the UI Polish milestone is likely removing the static `#toast` element, `contact-us.php` will default to native `alert()` dialogs, directly violating the requirement to use "user-friendly UI toasters/notifications".
5. **Code Maintainability**: The lack of DocBlocks violates the M2 requirement to structure and comment the code for shared hosting environments.

## Caveats
- The analysis is scoped strictly to `process-contact.php`, `check-room-availability.php`, `db.php`, and their direct frontend JS handlers. Other endpoints or forms (if any exist) were not audited.
- It is assumed that a global dynamic toaster function (e.g., `showToast`) will be implemented in `main.js` to replace the static HTML toaster.

## Conclusion
To finalize Milestone 2 (Backend & Deployment Readiness), the following implementation strategy is recommended:
1. **Refactor db.php**: Remove `die()`. Log the PDOException using `error_log()` and throw a generic error or return a structured JSON response (e.g. by checking `$_SERVER['HTTP_ACCEPT']` for JSON expectation).
2. **Standardize API Responses**: Update `check-room-availability.php` to return `['success' => false, 'message' => '...']` for all validation and database errors.
3. **Scrub Sensitive Errors**: Modify `process-contact.php` to log `{$mail->ErrorInfo}` internally and return a generic "Message could not be sent. Please try again later."
4. **Dynamic UI Toasters**: Replace the static `#toast` DOM queries and `alert()` fallbacks in `contact-us.php` and `ampara-circuit-bungalow.php` with a global JS function that dynamically creates and renders toast notifications.
5. **Add Documentation**: Add comprehensive PHP DocBlocks to the top of all backend scripts.

## Verification Method
1. Break the DB connection (change the DB password in `.env`), then attempt to check room availability. The network tab must show a `500` status or a valid JSON payload with `success: false`, and the UI must display a friendly error (not a text stack trace).
2. Break the SMTP configuration in `.env` and submit the contact form. Verify that the UI displays a generic error message and does not expose PHPMailer internal details.
3. Inspect `process-contact.php`, `check-room-availability.php`, and `db.php` for standard PHP file headers.
