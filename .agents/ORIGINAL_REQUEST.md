# Original User Request

## Initial Request — 2026-06-07T13:11:45+05:30

# Teamwork Project Prompt — Final

> Status: Launched
> Goal: Craft prompt → get user approval → delegate to teamwork_preview

Finalize a PHP and TailwindCSS website for the Ministry of Labour to be deployed on shared hosting (e.g., Bluehost). The project involves applying SEO best practices, thoroughly verifying all backend flows, optimizing Tailwind CSS usage within existing files, and ensuring a polished, consistent UI for a client demo.

Working directory: c:\xampp\htdocs\Ministry-of-Labour
Integrity mode: development

## Requirements

### R1. SEO Optimization
Apply standard SEO best practices (such as meta tags, Open Graph tags, and semantic HTML structure) to all public-facing pages without altering the visual design of the website.

### R2. Backend Integration & Verification
Ensure that all forms, database interactions, and dynamic PHP logic function seamlessly. The code must be compatible with a standard shared PHP/MySQL hosting environment. Avoid complex configurations.

### R3. UI Consistency & Tailwind Optimization
Ensure that any extra UI elements (like toasters and notifications) match the site's overall aesthetic. Optimize the use of Tailwind CSS classes directly within the files. Do not create excessive separate component files unless absolutely necessary.

### R4. Code Quality & Deployment Readiness
Clean up the codebase by adding proper comments and structuring the PHP code for maintainability. The final deliverable must be fully deployment-ready for a first test session with the client.

## Acceptance Criteria

### Programmatic Verification
- [ ] A script must successfully verify that all PHP files load without errors or warnings.
- [ ] A programmatic check or test flow must ensure that database connections and form submissions execute successfully.
- [ ] An automated check must confirm the presence of standard SEO meta tags across main pages.

### Agent-as-Judge UI & Code Review
- [ ] An agent verifies that UI elements (toasters/notifications) visually match the established site design.
- [ ] An agent confirms the codebase uses Tailwind efficiently without an unnecessary proliferation of component files.
- [ ] An agent verifies that the code is well-commented and structured cleanly for a shared hosting environment.
