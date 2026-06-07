# Handoff Report: M1 SEO Optimization

## 1. Observation
- `includes/header.php` currently has hardcoded SEO tags: `<title>`, `<meta name="description">`, `<meta name="keywords">`, and Open Graph tags (`og:type`, `og:url`, `og:title`, `og:description`, `og:image`).
- Public pages (like `article.php`, `gallery-album.php`, `about-us.php`) define a variable `$page_title` (e.g. `$page_title = 'Articles';`) right before including `header.php`. However, `$page_title` sometimes contains HTML tags (e.g., in `iau.php` or `rti.php`) since it's also used for the hero banner subtitle.
- `PROJECT.md` specifies that pages should set variables like `$pageTitle`, `$metaDescription`, and `$ogImage` to configure SEO dynamically per page.

## 2. Logic Chain
- To support dynamic SEO metadata without breaking the existing `$page_title` visual rendering, we should introduce a PHP block in `includes/header.php` before the `<!DOCTYPE html>` declaration.
- This block will check if `$pageTitle`, `$metaDescription`, `$ogImage`, etc., are set. If not, it falls back to `$page_title` (with HTML tags stripped using `strip_tags()`) and then to standard fallback text.
- The hardcoded meta tags in `<head>` will be replaced by `<?= htmlspecialchars($seoTitle) ?>` (and so on) to ensure safe output.
- Dynamic pages such as `article.php` and `gallery-album.php` should explicitly set `$pageTitle`, `$metaDescription`, and `$ogImage` based on database content before requiring `header.php`. 
- For instance, in `article.php`, `$pageTitle` can be set to `$article['title']`, and `$metaDescription` to a truncated, tag-stripped version of `$article['content']`.

## 3. Caveats
- `og:url` is currently hardcoded to `https://www.labour.gov.lk/`. It's better to dynamically construct it using `$_SERVER['HTTP_HOST']` and `$_SERVER['REQUEST_URI']` as a fallback, or simply allow pages to set `$ogUrl`.
- Image paths in `$ogImage` should be correct relative to the base URL. When `article.php` passes an image from the DB, it should prepend `'admin/'` (e.g., `'admin/' . $article['cover_image']`).

## 4. Conclusion
To fulfill the SEO Optimization milestone, the implementer must:
1.  **Modify `includes/header.php`**:
    - Add a PHP block at the top to resolve SEO variables (`$seoTitle`, `$seoDesc`, `$seoKw`, `$seoOgImage`, `$seoOgUrl`, `$seoOgType`, `$seoOgTitle`, `$seoOgDesc`) from page-provided variables (`$pageTitle`, `$metaDescription`, etc.), using `strip_tags($page_title)` and sensible defaults as fallbacks.
    - Replace the hardcoded `<title>`, `<meta name="description">`, `<meta name="keywords">`, and `og:*` tags with the resolved PHP variables wrapped in `htmlspecialchars()`.
2.  **Modify `article.php`**:
    - Before `include 'includes/header.php';`, set `$pageTitle = strip_tags($article['title']);`.
    - Set `$metaDescription = mb_substr(strip_tags($article['content']), 0, 160) . '...';`.
    - Set `$ogImage = 'admin/' . $article['cover_image'];` (if exists).
    - Set `$ogType = 'article';`.
3.  **Modify `gallery-album.php`**:
    - Set `$pageTitle = strip_tags($album['title']);`.
    - Set `$metaDescription = "View gallery album: " . strip_tags($album['title']);`.
    - Set `$ogImage = 'admin/' . $album['cover_image'];` (if exists).

## 5. Verification Method
- **Static Pages:** Visit `/about-us.php` and inspect the page source. Verify the `<title>` is "About Us | Ministry of Labour - Government of Sri Lanka" and Open Graph tags contain the default description.
- **Dynamic Pages:** Visit `/article.php?id=1` (or any valid ID) and inspect the page source. Ensure the `<title>` matches the article title, `<meta name="description">` contains the article snippet, and `<meta property="og:image">` points to the article's cover image.
- **HTML Safety:** Verify that HTML injected via titles (e.g., `iau.php`) is safely stripped and does not break the `<title>` tag.
