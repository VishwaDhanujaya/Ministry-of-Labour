<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<?php
$base_url = $base_url ?? '';
$admin_js_path = dirname(dirname(__DIR__)) . '/admin/assets/js/admin.js';
$admin_js_version = file_exists($admin_js_path) ? filemtime($admin_js_path) : time();
?>
<script src="<?= $base_url ?>admin/assets/js/admin.js?v=<?= $admin_js_version ?>"></script>

<!-- Global Toast Notification Bridge -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    <?php if (!empty($error)): ?>
        if (typeof window.showToast === 'function') {
            window.showToast(<?= json_encode($error) ?>, 'error');
        }
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        if (typeof window.showToast === 'function') {
            window.showToast(<?= json_encode($success) ?>, 'success');
        }
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        if (typeof window.showToast === 'function') {
            window.showToast("Operation completed successfully.", 'success');
            
            // Clean up URL parameters without refreshing
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.replaceState({}, '', url);
        }
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        if (typeof window.showToast === 'function') {
            window.showToast(<?= json_encode($_GET['error']) ?>, 'error');
            
            // Clean up URL parameters without refreshing
            const url = new URL(window.location);
            url.searchParams.delete('error');
            window.history.replaceState({}, '', url);
        }
    <?php endif; ?>
});
</script>

</body>
</html>
