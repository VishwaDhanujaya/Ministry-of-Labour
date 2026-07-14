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
* **Animations & Polish**: Preserve `data-aos` attributes on HTML sections and rely on the established Tailwind micro-interactions (e.g. `hover:-translate-y-1 hover:shadow-lg`) for a premium feel.
