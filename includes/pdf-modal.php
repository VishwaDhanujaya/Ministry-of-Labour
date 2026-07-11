<?php
// Script to open PDFs in a new tab (replaces the old modal popup functionality)
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.open-pdf-modal');
        if (btn) {
            e.preventDefault();
            let url = btn.getAttribute('data-pdf-url');
            if (url) {
                // Resolve relative URLs against the <base> tag if present
                if (!url.startsWith('http://') && !url.startsWith('https://') && !url.startsWith('/')) {
                    const baseEl = document.querySelector('base');
                    if (baseEl) {
                        const baseUrl = baseEl.getAttribute('href');
                        if (baseUrl) {
                            url = baseUrl.replace(/\/$/, '') + '/' + url.replace(/^\//, '');
                        }
                    }
                }
                window.open(url, '_blank');
            }
        }
    });
});
</script>
