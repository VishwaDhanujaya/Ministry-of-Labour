# Ministry of Labour — Sri Lanka Web Portal

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Security Status](https://img.shields.io/badge/Security-PDO%20%7C%20CSRF%20%7C%20RBAC-success?style=for-the-badge)](#security-best-practices)
[![License](https://img.shields.io/badge/License-Government_Open-blue?style=for-the-badge)](#license--attribution)

The official web portal and Content Management System (CMS) for the **Ministry of Labour, Sri Lanka**. This portal provides a modern, accessible, and secure digital platform for public service delivery, employee dispute escalations, circuit bungalow reservations, publication distribution, and real-time announcements.

---

## Key Features

### Full Trilingual Architecture (English, Sinhala, Tamil)
- **Centralized Dictionary System**: Seamless UI localization using the `t()` helper function and a unified translation dictionary (`includes/translations.php`).
- **Dynamic Content Fallbacks**: Database entities (News, Vacancies, Procurements, Special Notices) query localized columns (`title_si`, `title_ta`) and gracefully fall back to English if native text is unpopulated.
- **Clean Prefix & Query Routing**: Supports clean SEO-friendly URLs (`/si/news/12`, `/ta/about-us`, `/en/downloads`) with cookie and session language persistence.
- **Localized Date Formatting**: Native date rendering engine (`format_date_trilingual()`) formatting dates into Sinhala (ජනවාරි), Tamil (ஜனவரி), and English.

### Circuit Bungalow Online Booking System (Ampara)
- **Interactive Calendar & Availability**: Real-time room availability calculation against confirmed bookings.
- **Tiered Pricing Structure**: Automatic rate selection for Ministry Officers, Govt/Private Sector personnel, and Foreign Visitors.
- **Multi-Step Request Flow**: Complete reservation request management with CSRF protection and offline payment approval workflows.

### Public Complaints & Escalation Channel
- **Integrated Guidance**: Direct routing to the Department of Labour CMS Portal (`cms.labourdept.gov.lk`).
- **WhatsApp Ministry Escalation**: Dedicated escalation workflow with valid CMS reference verification.

### Enterprise Security & Integrity
- **100% Prepared Statements**: Strict PDO parameter binding preventing SQL Injection (`PDO::ATTR_EMULATE_PREPARES = false`).
- **CSRF & Brute-Force Shield**: Constant-time token verification (`hash_equals`) and automatic IP lockout (5 failed attempts = 15-minute lock).
- **Secure File Upload Utility**: Server-side MIME verification (`finfo_open`), extension whitelisting, random hash renaming, and monthly directory organization (`uploads/YYYY/MM/`).
- **XSS & Session Defense**: Strict output sanitization (`htmlspecialchars`), `HttpOnly`/`SameSite=Lax` session cookies, and 5-minute idle timeouts.

### Comprehensive CMS Admin Dashboard
- **Role-Based Access Control (RBAC)**: Fine-grained permissions distinguishing `executive_officer` (Super Admin) and `content_editor`.
- **Google Translate API Auto-Translation**: Auto-translates news titles and body content from English into Sinhala and Tamil in a single click using Quill.js rich text editor integration.
- **Publishing Workflow**: Draft -> Pending Approval -> Published status pipeline.

---

## Technology Stack

| Layer | Technologies Used |
| :--- | :--- |
| **Backend Core** | PHP 8.1+ (Procedural Architecture with Object-Oriented Utilities) |
| **Database** | MySQL 8.0+ / MariaDB using PHP Data Objects (PDO) |
| **Styling & UI** | Tailwind CSS v3.4 (Custom Build), Vanilla CSS, AOS (Animate On Scroll) |
| **Frontend Scripts** | Vanilla JavaScript (ES6+), Lightbox (fsLightbox), Quill.js |
| **Server Environment** | Apache (mod_rewrite enabled, gzip deflate, browser cache controls) |
| **Build Tools** | Node.js / npm (Tailwind CLI compilation pipeline) |

---

## Repository Directory Structure

```
Ministry-of-Labour/
├── admin/                        # CMS Admin Panel
│   ├── assets/                   # Admin CSS, JS (admin.js), and icons
│   ├── includes/                 # Admin Auth (auth.php), DB, & Helper Functions
│   ├── uploads/                  # Organized media & document upload repository
│   └── index.php                 # Admin Dashboard & Module Management
├── assets/                       # Public Static Assets
│   ├── css/                      # Compiled production CSS (style.css)
│   ├── img/                      # Logos, emblems, slider banners & bungalow gallery
│   └── js/                       # Public script helpers
├── includes/                     # Shared Public Components
│   ├── header.php                # Topbar, Logo, Nav, SEO Meta, Language Switcher
│   ├── sub-hero.php              # Inner Page Banner & Dynamic Breadcrumbs
│   ├── footer.php                # Quick Links, GIC 1919 Branding, Detail Modal
│   ├── translations.php          # Central Trilingual Dictionary & Helpers
│   └── Mailer.php                # SMTP Mailer Utility (PHPMailer wrapper)
├── input.css                     # Tailwind CSS source directives & design tokens
├── tailwind.config.js            # Tailwind Theme Configuration (Colors & Typography)
├── index.php                     # Homepage Portal
├── news.php                      # News Directory Page
├── news-single.php               # Single Article View Page
├── downloads.php                 # Downloads Hub (Acts, Amendments, Procurements)
├── ampara-circuit-bungalow.php   # Bungalow Details & Availability Page
├── contact-us.php                # Contact Information & Contact Form
├── complaints.php                # Complaints & WhatsApp Escalation Guidance
├── .htaccess                     # Apache Rewrite Rules (Pretty URLs, Security Header, Gzip)
├── .env.example                  # Environment Variables Template
└── README.md                     # Project Documentation
```

---

## Installation & Local Setup Guide

### Prerequisites
- **XAMPP / WAMP / MAMP** (PHP 8.1+ & MySQL 8.0+)
- **Node.js & npm** (for compiling Tailwind CSS)
- **Git**

### 1. Clone the Repository
```bash
git clone https://github.com/VishwaDhanujaya/Ministry-of-Labour.git
cd Ministry-of-Labour
```

### 2. Configure Environment (`.env`)
Copy `.env.example` to create `.env` in the project root:
```bash
cp .env.example .env
```
Edit `.env` to match your local setup:
```env
APP_ENV=development
APP_URL=http://localhost/Ministry-of-Labour

# Database Credentials
DB_HOST=localhost
DB_NAME=ministry_of_labour
DB_USER=root
DB_PASS=

# Mail / SMTP Configuration
SMTP_HOST=smtp.mailtrap.io
SMTP_PORT=587
SMTP_USER=your_username
SMTP_PASS=your_password
SMTP_FROM_EMAIL=info@labourmin.gov.lk
SMTP_FROM_NAME="Ministry of Labour Sri Lanka"

# Google reCAPTCHA v2 (Public Forms)
RECAPTCHA_SITE_KEY=your_recaptcha_site_key
RECAPTCHA_SECRET_KEY=your_recaptcha_secret_key
```

### 3. Import Database Schema
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new database named `ministry_of_labour` with collation `utf8mb4_unicode_ci`.
3. Import the SQL dump file located in `database/ministry_of_labour.sql` (or `schema.sql`).

### 4. Build Tailwind CSS Assets
Install node dependencies and compile styles:
```bash
npm install
npm run build:prod
```
*For active development with auto-rebuild:*
```bash
npm run watch
```

### 5. Access the Local Site
- **Public Portal**: `http://localhost/Ministry-of-Labour/`
- **Admin CMS Dashboard**: `http://localhost/Ministry-of-Labour/admin/`

---

## Security Best Practices

1. **Prepared Statements**: All database operations use `$pdo->prepare()` with parameterized execution.
2. **Strict MIME Upload Checking**: Raw file content headers are verified server-side via `FILEINFO_MIME_TYPE` to stop uploaded shell scripts.
3. **Session Hardening**: `session.cookie_httponly = 1`, `session.cookie_samesite = Lax`, and 300s inactivity auto-logout.
4. **Rate Limiting**: IP-based rate limiting on administrative logins to prevent brute-force attacks.

---

## License & Attribution

- **Copyright**: © 2026 **Ministry of Labour, Government of Sri Lanka**. All rights reserved.
- **Designed & Developed by**: SLT Digital / Project Engineering Team.
