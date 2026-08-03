<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<?php
$base_url = $base_url ?? '';
$admin_js_path = dirname(dirname(__DIR__)) . '/admin/assets/js/admin.js';
$admin_js_version = file_exists($admin_js_path) ? filemtime($admin_js_path) : time();
$cropper_js_path = dirname(dirname(__DIR__)) . '/admin/assets/js/image-cropper.js';
$cropper_js_version = file_exists($cropper_js_path) ? filemtime($cropper_js_path) : time();
?>
<script src="<?= $base_url ?>admin/assets/js/admin.js?v=<?= $admin_js_version ?>"></script>
<script src="<?= $base_url ?>admin/assets/js/image-cropper.js?v=<?= $cropper_js_version ?>"></script>

<!-- Global Toast Notification Bridge -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    <?php
    $displayedError = false;
    $displayedSuccess = false;
    ?>

    <?php if (!empty($error)): ?>
        if (typeof window.showToast === 'function') {
            window.showToast(<?= json_encode($error) ?>, 'error');
        }
        <?php $displayedError = true; ?>
    <?php endif; ?>

    <?php if (!$displayedError && isset($_GET['error'])): ?>
        if (typeof window.showToast === 'function') {
            <?php
            $error_messages = [
                'forbidden' => 'You do not have permission to access that page.',
                'unauthorized' => 'Please log in to continue.',
            ];
            $error_key = $_GET['error'];
            $error_msg = $error_messages[$error_key] ?? (trim($error_key) !== '' ? $error_key : 'An error occurred.');
            $error_type = ($error_key === 'forbidden') ? 'warning' : 'error';
            ?>
            window.showToast(<?= json_encode($error_msg) ?>, <?= json_encode($error_type) ?>);
        }
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        if (typeof window.showToast === 'function') {
            window.showToast(<?= json_encode($success) ?>, 'success');
        }
        <?php $displayedSuccess = true; ?>
    <?php endif; ?>

    <?php if (!$displayedSuccess && isset($_GET['success'])): ?>
        if (typeof window.showToast === 'function') {
            <?php
            $getSuccess = trim($_GET['success']);
            $successMsg = ($getSuccess !== '' && $getSuccess !== '1' && $getSuccess !== 'true') ? $getSuccess : "Operation completed successfully.";
            ?>
            window.showToast(<?= json_encode($successMsg) ?>, 'success');
        }
    <?php endif; ?>

    <?php if (isset($_GET['success']) || isset($_GET['error'])): ?>
        // Clean up URL parameters without refreshing page
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, '', url);
    <?php endif; ?>
});
</script>

</body>
</html>
