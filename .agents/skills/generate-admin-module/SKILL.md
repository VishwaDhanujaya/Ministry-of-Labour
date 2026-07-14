---
name: generate-admin-module
description: Use this skill when the user asks to create a new admin CMS page, dashboard module, or CRUD management interface.
---
# Admin Module Generation Protocol

When scaffolding a new admin page in this repository, you MUST follow this precise structure:

### 1. Template Verification First
* Check if a `templates/` directory exists at the root. If it does, duplicate the boilerplate code from `templates/admin-crud.php` (or similar) instead of writing the structure from scratch. This guarantees zero-bug architectures.

### 2. Backend & Security Setup
* Always require standard includes: `includes/db.php`, `includes/auth.php`, and `includes/functions.php`.
* Execute `requireLogin();` immediately.
* If a specific role is needed, use `requirePermission('executive_officer');`.
* Protect form submissions using `requireCsrfToken('POST', 'post');`.

### 3. Form Processing & DB
* Use native PDO prepared statements for all `SELECT`, `INSERT`, `UPDATE`, and `DELETE` queries. Never use raw variable insertion in SQL.
* Process file uploads using `handleFileUpload()` from `functions.php`. Do not use native `move_uploaded_file()`.
* Output successes to a `$success` variable and errors to an `$error` variable.

### 4. Frontend Layout
* The layout MUST include `includes/header.php`, `includes/sidebar.php`, and `includes/topbar.php`.
* Wrap the main content in: `<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">`.
* Display success/error messages using the existing Tailwind alert banners (e.g., `.bg-emerald-50` and `.bg-rose-50`).
