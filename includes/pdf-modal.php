<?php
// Script to open PDFs in a new tab (replaces the old modal popup functionality)
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.open-pdf-modal');
        if (btn) {
            e.preventDefault();
            const url = btn.getAttribute('data-pdf-url');
            if (url) {
                window.open(url, '_blank');
            }
        }
    });
});
</script>
