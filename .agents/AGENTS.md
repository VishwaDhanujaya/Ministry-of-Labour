# Custom Workspace Agent Rules

These rules apply automatically to any AI coding assistant (like Gemini/Antigravity) operating in this workspace.

## 1. Handover Protocol (Context Loading)
* **Read Context First**: Before analyzing the codebase or making edits, always read the [handover.md](file:///c:/xampp/htdocs/Ministry-of-Labour/.agents/handover.md) file at the root of the project to understand the structure, database configuration, dynamic translation flow, and recent updates.
* **Update After Changes**: Every time you perform any modification, creation, or deletion of code in this repository, you **MUST** update the `Recent Modifications Log` section in [handover.md](file:///c:/xampp/htdocs/Ministry-of-Labour/.agents/handover.md).
   * Specify the **date** of the change.
   * List the **files** edited (with file links).
   * Describe **what** was modified and **why** (including design justifications).
* **Keep It Clean**: Ensure the structure, file paths, and current status sections of [handover.md](file:///c:/xampp/htdocs/Ministry-of-Labour/.agents/handover.md) stay up-to-date as the project evolves.

## 2. Coding Standards & Integrity
* **Database Queries**: Ensure database interactions strictly follow the native PDO prepared statement parameters. Never interpolate variables directly into SQL queries to prevent SQL Injection.
* **Localization / Multilingual**: Keep global variables like `$current_lang` intact. Always write database queries that can gracefully fallback to English if Sinhala (`_si`) or Tamil (`_ta`) columns are empty.
* **Use Established Utilities**: Always use the built-in `App\Utilities\Mailer` class for sending emails rather than the native PHP `mail()` function to guarantee SMTP delivery standards.
* **File Upload Security**: Always use the `handleFileUpload()` utility located in `admin/includes/functions.php`. Do not write raw `move_uploaded_file()` scripts without these established MIME checks.

## 3. Workflow Efficiency & Bug-Free Architecture
* **Small Steps (Incremental Development)**: When tasked with a large feature, break it down into modular steps (e.g., Schema -> Backend Logic -> Frontend UI) and verify with the user at each step to prevent compounding errors.
* **Use Templates (If Available)**: When building new CMS pages, always check if a `templates/` directory exists. If it does, duplicate the boilerplate from there rather than generating code from scratch.
* **TODO-Driven Development**: If a `TODO.md` file exists at the workspace root, prioritize the sequence of tasks outlined within it. Mark items as completed once tested.
* **Proactive Explanations**: When resolving a bug or writing a complex algorithm, explain *why* it was done (e.g. security reasons, performance reasons) so the user can learn from the implementation.

## 4. UI/UX Consistency & Best Practices
* **Admin Notifications**: Never use native JavaScript `alert()` or `confirm()` boxes in the Admin Panel. Always use the built-in `window.showToast(message, 'success'|'error')` defined in `admin/assets/js/admin.js`.
* **Toast Notification System Standards**:
  - **Z-Index Layering**: The toast container must maintain a high `z-index` (at least `z-[99999]`) to ensure it renders on top of all modals (`official-modal`, `globalCropModal`, etc.).
  - **Unified Types**: Support four standard types: `'success'`, `'error'`, `'info'`, and `'warning'` with matching brand colors and SVG icons.
  - **Positioning**: Locate the toast notifications consistently in the top-right corner (`top-6 right-6`) on desktop to avoid blocking primary CTA buttons or booking forms.
  - **Dismiss UX**: Implement a countdown progress bar that pauses automatically when hovered (`mouseenter`) and resumes on `mouseleave`.
  - **Consistent Code**: Keep the frontend `showToast` in `assets/js/main.js` structurally identical to `admin/assets/js/admin.js`.
* **Animations & Polish**: Preserve `data-aos` attributes on HTML sections and rely on the established Tailwind micro-interactions (e.g. `hover:-translate-y-1 hover:shadow-lg`) for a premium feel.

## 5. Resilient External API Integrations
* **Avoid Client-Side Only Fetches**: Do not rely exclusively on client-side `fetch()` for unofficial or rate-limited third-party APIs (e.g., Google Translate). Client-side requests are vulnerable to CORS restrictions, strict `Referer` blocking, and privacy extensions/ad-blockers.
* **Server-Side Proxy Fallbacks**: Always implement a server-side PHP proxy endpoint (e.g., `admin/[name]-api.php`) to handle external API communication via cURL. This provides a resilient fallback that circumvents client-side network restrictions.
* **Handle Payload Limits**: When sending variable-length text to external APIs via GET requests, always implement chunking to prevent exceeding HTTP URI length limits (414 Request-URI Too Long).
* **API Endpoint Naming**: Name new admin AJAX endpoints using the `[name]-api.php` convention and place them in the `admin/` directory. Ensure they include `require_once 'includes/auth.php'` and enforce `verifyCsrfToken` checks.
