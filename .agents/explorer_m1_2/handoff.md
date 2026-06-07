# Handoff Report: M1 SEO Optimization

## Observation
1. **Static SEO in Header**: In `includes/header.php` (lines 20-35), the `<title>`, `<meta name="description">`, `<meta name="keywords">`, and Open Graph tags (`og:title`, `og:description`, `og:image`, `og:url`) are hardcoded.
2. **Missing Meta Variables in Pages**: Public PHP files (e.g., `index.php`, `about-us.php`, `contact-us.php`) define `$page_title` in some cases but do not define `$meta_description`, `$meta_keywords`, or `$og_image` before calling `include 'includes/header.php';`.
3. **Dynamic Content Ignored**: Pages like `article.php` and `gallery-album.php` fetch rich data from the database (`$article['title']`, `$article['content']`, `$article['cover_image']`) but this data isn't passed to the header for SEO/Open Graph tags.
4. **Semantic HTML `<main>` Missing**: The public pages lack a `<main>` semantic wrapper. The header finishes rendering (`includes/header.php:301`) without opening a `<main>` tag, and `includes/footer.php` does not close it.

## Logic Chain
1. To support dynamic SEO metadata per page, `includes/header.php` must be modified to use variables like `$meta_title`, `$meta_description`, `$meta_keywords`, `$og_image`, and `$og_url`.
2. It should fall back to sensible defaults if these variables are not provided by the including page, preventing broken meta tags.
3. Each public page needs to declare these variables. Static pages get static strings. Dynamic pages (`article.php`, `gallery-album.php`) must assign these variables using data from their SQL queries before the `include 'includes/header.php';` statement.
4. To fulfill the semantic HTML requirement without restructuring every page's internal DOM, `<main id="main-content" class="flex-grow">` should be opened at the very bottom of `includes/header.php`, and `</main>` should be closed at the very top of `includes/footer.php`.
5. For the `flex-grow` class on `<main>` to push the footer to the bottom, the `<body>` tag in `includes/header.php` needs the Tailwind classes `flex flex-col min-h-screen`.

## Caveats
- `check-room-availability.php` and `process-contact.php` are API endpoints (JSON response) and do not need SEO or UI changes.
- The `$current_lang` override logic in dynamic pages (e.g., `article.php`) modifies `$article['title']` and `$article['content']`. Ensure the meta tag variables are set *after* the language overrides so the SEO matches the displayed language.

## Conclusion
The Worker agent should implement the following specific changes:

### 1. Update `includes/header.php`
- Change `<body>` class: `<body class="bg-white text-gray-800 antialiased scroll-smooth flex flex-col min-h-screen">`.
- Replace hardcoded `<title>` and `<meta>` tags (lines 20-35) with dynamic PHP blocks:
  ```php
  <?php
  $seo_title = $meta_title ?? ($page_title ?? 'Ministry of Labour') . ' - Government of Sri Lanka';
  $seo_desc = $meta_description ?? 'Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.';
  $seo_keys = $meta_keywords ?? 'Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety';
  $seo_og_img = $og_image ?? 'assets/img/og-preview.jpg';
  $seo_og_url = $og_url ?? 'https://www.labour.gov.lk' . $_SERVER['REQUEST_URI'];
  ?>
  <title><?= htmlspecialchars($seo_title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($seo_desc) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($seo_keys) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($seo_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($seo_desc) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($seo_og_img) ?>">
  <meta property="og:url" content="<?= htmlspecialchars($seo_og_url) ?>">
  ```
- At the very end of the file, after `</div>` (the mobile menu), add: `<main id="main-content" class="flex-grow">`.

### 2. Update `includes/footer.php`
- Prepend `</main>` right before the `<!-- Footer -->` / `<footer>` line.

### 3. Update Static Public Pages
For `index.php`, `about-us.php`, `contact-us.php`, `citizen-charter.php`, `downloads.php`, `gallery.php`, `articles.php`, `iau.php`, `rti.php`, `ampara-circuit-bungalow.php`:
- Define `$meta_description` (and optionally `$meta_keywords`) specific to the page content right before `include 'includes/header.php';`. Example for `index.php`:
  ```php
  $page_title = 'Home';
  $meta_description = 'Welcome to the official portal of the Ministry of Labour, Sri Lanka. We foster fair employment and protect workers\' rights.';
  ```

### 4. Update Dynamic Pages
- **`article.php`**: After line 27 (language overrides), add:
  ```php
  $meta_title = $article['title'];
  $meta_description = mb_substr(strip_tags($article['content']), 0, 160);
  $og_image = !empty($article['cover_image']) ? 'admin/' . $article['cover_image'] : 'assets/img/og-preview.jpg';
  ```
- **`gallery-album.php`**: After line 26, add:
  ```php
  $meta_title = $album['title'];
  $meta_description = 'View the ' . $album['title'] . ' gallery from the Ministry of Labour, Sri Lanka.';
  $og_image = !empty($album['cover_image']) ? 'admin/' . $album['cover_image'] : 'assets/img/og-preview.jpg';
  ```

## Verification Method
1. Run `php -S localhost:8000` to serve the website.
2. Load `http://localhost:8000/index.php` and verify `<head>` contains the updated dynamic meta tags.
3. Inspect the DOM to ensure the `<main id="main-content">` wraps the main content between the header and footer.
4. Load `http://localhost:8000/article.php?id=[EXISTING_ID]` and inspect `<head>`. Verify the `og:image`, `description`, and `title` match the specific article's content from the database.
