<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<?php
$admin_js_path = dirname(dirname(__DIR__)) . '/admin/assets/js/admin.js';
$admin_js_version = file_exists($admin_js_path) ? filemtime($admin_js_path) : time();
?>
<script src="<?= $base_url ?>admin/assets/js/admin.js?v=<?= $admin_js_version ?>"></script>
</body>
</html>
