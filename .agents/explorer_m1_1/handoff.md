# Handoff Report: M1 SEO Optimization

## 1. Observation
- **`includes/header.php`** currently hardcodes SEO elements (lines 20-35): `<title>`, `<meta name="description">`, `<meta name="keywords">`, `<meta property="og:url">`, `<meta property="og:title">`, `<meta property="og:description">`, and `<meta property="og:image">`.
- Several public pages (like `about-us.php`, `gallery.php`, `article.php`) define a variable `$page_title` before `include 'includes/header.php';`, but `header.php` does not use it to render the `<title>`.
- Other public pages (like `index.php`) do not define any SEO variables before including the header.
- The `PROJECT.md` and `SCOPE.md` contracts mandate that pages should set variables like `$pageTitle`, `$metaDescription`, and `$ogImage` before including `header.php`, and `header.php` must render them dynamically.

## 2. Logic Chain
- To achieve dynamic SEO metadata without breaking existing pages, `includes/header.php` must be modified to check for these variables (`$pageTitle` or `$page_title`, `$metaDescription`, `$metaKeywords`, `$ogImage`, `$ogUrl`) and use them. If they are not set, it should fallback to the current default values.
- All public-facing PHP pages need to be updated to explicitly set these variables (at least `$pageTitle` and `$metaDescription`) before `include 'includes/header.php';`.
- For dynamic pages like `article.php` or `gallery-album.php`, the SEO variables should be populated using data fetched from the database (e.g., using `$article['title']` for the title and a snippet of `$article['content']` for the description).

## 3. Caveats
- Some files already use `$page_title` instead of `$pageTitle`. The logic in `header.php` should handle both to prevent regressions, or the worker can standardize all files to use `$pageTitle`.
- We must make sure that `htmlspecialchars()` is used when outputting these variables in `header.php` to prevent XSS.

## 4. Conclusion
The Implementer needs to perform the following:
1. **Update `includes/header.php` (Lines 20-35)** to use a PHP block that resolves `$finalTitle`, `$finalDescription`, `$finalKeywords`, `$finalOgImage`, and `$finalOgUrl` from user-provided variables or defaults, and outputs them safely. Example:
   ```php
   <!-- SEO Best Practices -->
   <?php
   $defaultTitle = "Ministry of Labour - Government of Sri Lanka";
   $finalTitle = $defaultTitle;
   if (isset($pageTitle) && !empty($pageTitle)) {
       $finalTitle = $pageTitle . " | " . $defaultTitle;
   } elseif (isset($page_title) && !empty($page_title)) {
       $finalTitle = $page_title . " | " . $defaultTitle;
   }
   
   $defaultDescription = "Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.";
   $finalDescription = isset($metaDescription) && !empty($metaDescription) ? $metaDescription : $defaultDescription;
   
   $defaultKeywords = "Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety";
   $finalKeywords = isset($metaKeywords) && !empty($metaKeywords) ? $metaKeywords : $defaultKeywords;
   
   $defaultOgImage = "assets/img/og-preview.jpg";
   $finalOgImage = isset($ogImage) && !empty($ogImage) ? $ogImage : $defaultOgImage;
   
   $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   $defaultOgUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   $finalOgUrl = isset($ogUrl) && !empty($ogUrl) ? $ogUrl : $defaultOgUrl;
   ?>
   <title><?= htmlspecialchars($finalTitle) ?></title>
   <meta name="description" content="<?= htmlspecialchars($finalDescription) ?>">
   <meta name="keywords" content="<?= htmlspecialchars($finalKeywords) ?>">
   <meta name="robots" content="index, follow">

   <!-- Open Graph / Facebook -->
   <meta property="og:type" content="website">
   <meta property="og:url" content="<?= htmlspecialchars($finalOgUrl) ?>">
   <meta property="og:title" content="<?= htmlspecialchars($finalTitle) ?>">
   <meta property="og:description" content="<?= htmlspecialchars($finalDescription) ?>">
   <meta property="og:image" content="<?= htmlspecialchars($finalOgImage) ?>">
   ```

2. **Update all public pages** (`index.php`, `about-us.php`, `contact-us.php`, `downloads.php`, etc.) to define at minimum `$pageTitle` and `$metaDescription` before `include 'includes/header.php';`.
3. **Enhance `article.php`** so that it uses the fetched `$article` to set `$pageTitle = $article['title'];` and `$metaDescription = strip_tags(mb_substr($article['content'], 0, 150));`

## 5. Verification Method
- Open `index.php` in a browser or via `curl` and verify the meta tags match the defaults or the variables set in the file.
- Open `article.php?id=[valid_id]` and verify the `<title>` and `<meta name="description">` tags dynamically reflect the database content.
