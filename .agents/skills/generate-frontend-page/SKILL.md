---
name: generate-frontend-page
description: Use this skill when the user asks to create a new public-facing frontend page (like an about page, contact page, or news listing).
---
# Frontend Page Generation Protocol

When scaffolding a new public page, follow these layout rules to ensure consistency:

### 1. Backend & Data Fetching
* Include `admin/includes/db.php` if database access is needed.
* Do NOT use `requireLogin()`. Public pages must not enforce admin auth.
* Handle translations dynamically. The user's active language is stored in the global `$current_lang` variable (set in `db.php`).
* If fetching text from the database, always implement fallback logic (e.g. check `title_$current_lang` and fallback to English `title`).

### 2. Layout Structure
* Include `includes/header.php` at the very top and `includes/footer.php` at the very bottom.
* Ensure responsive font styling by using `font-montserrat` for structural headings (`h1`, `h2`) and `font-inter` for paragraphs/body text.

### 3. Styling & Security
* Use standard Tailwind CSS utility classes and reference brand colors defined in `tailwind.config.js` (`bg-primary`, `text-secondary`).
* Always wrap user-generated outputs or DB text in `htmlspecialchars()` to prevent XSS vulnerabilities.
