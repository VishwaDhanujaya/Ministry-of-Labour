<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category = $_POST['category'];
    $publish_date = !empty($_POST['publish_date']) ? date('Y-m-d', strtotime($_POST['publish_date'])) : null;
    $summary = trim($_POST['summary']);
    $content = trim($_POST['content']);
    $tags = trim($_POST['tags']);
    $language = $_POST['language'];
    $visibility = $_POST['visibility'] ?? 'public';
    $is_featured = ($_POST['is_featured'] ?? 'no') === 'yes' ? 1 : 0;
    $is_special_notice = ($_POST['is_special_notice'] ?? 'no') === 'yes' ? 1 : 0;
    
    // Check which button was clicked
    $status = isset($_POST['save_draft']) ? 'Draft' : 'Published';

    // File upload logic
    $cover_image = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = handleFileUpload($_FILES['cover_image'], 'uploads/news');
        if ($uploadResult['success']) {
            $cover_image = 'uploads/news/' . $uploadResult['filename'];
        } else {
            $error = $uploadResult['error'];
        }
    } else {
        $error = "Cover image is required.";
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO news (title, category, publish_date, summary, content, cover_image, tags, language, visibility, is_featured, is_special_notice, status, author_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $category, $publish_date, $summary, $content, $cover_image, $tags, $language, $visibility, $is_featured, $is_special_notice, $status, $_SESSION['admin_id']])) {
            $success = "Article " . ($status === 'Draft' ? "saved as draft." : "published successfully.");
        } else {
            $error = "Failed to save article to database.";
        }
    }
}

// Fetch recent drafts for the widget
$stmt = $pdo->prepare("SELECT title, created_at, status FROM news WHERE status = 'Draft' ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$recentDrafts = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Upload News</h2>
            <button class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Article
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Form (Col 2) -->
            <div class="lg:col-span-2">
                <?php if (!empty($error)): ?>
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm font-medium">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" class="js-validate-form js-reset-on-success space-y-6">
                    
                    <!-- Article Title -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Article Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required placeholder="Enter article headline" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>

                    <!-- Category & Publish Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Category <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="">All Categories</option>
                                    <option value="Media">Media</option>
                                    <option value="Notices">Notices</option>
                                    <option value="Policy">Policy</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Publish Date</label>
                            <div class="relative">
                                <input type="date" name="publish_date" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 placeholder-gray-400">
                            </div>
                        </div>
                    </div>

                    <!-- Summary / Excerpt -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Summary / Excerpt <span class="text-red-500">*</span></label>
                        <textarea name="summary" required placeholder="Brief description (shown on homepage)" rows="3" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <!-- Full Article Body -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Full Article Body <span class="text-red-500">*</span></label>
                        <textarea name="content" required placeholder="Full article content" rows="8" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Cover Image <span class="text-red-500">*</span></label>
                        <input type="file" name="cover_image" accept="image/png, image/jpeg, image/jpg, image/webp" required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900">
                    </div>

                    <!-- Tags & Language -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Tags (comma separated) <span class="text-red-500">*</span></label>
                            <input type="text" name="tags" required placeholder="Labour, EPF,..." class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Language <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="language" required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="English">English</option>
                                    <option value="Sinhala">Sinhala</option>
                                    <option value="Tamil">Tamil</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="submit" name="save_draft" value="1" class="js-save-draft px-6 py-2.5 border border-[#4E0000] text-[#4E0000] rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors bg-white">
                            Save as Draft
                        </button>
                        <button type="submit" name="publish" value="1" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                            Publish Article
                        </button>
                    </div>

                </div> <!-- End Main Form wrapper, sidebar starts outside form -->

            <!-- Right Column: Sidebar Widgets (Col 1) -->
            <div class="space-y-8">
                <!-- Publish Options Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Publish Options</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Visibility -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Visibility <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="visibility" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                    <option value="Hidden">Hidden</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Featured Article -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Featured Article?</label>
                            <div class="relative">
                                <select name="is_featured" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Special Notice -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Special Notice?</label>
                            <div class="relative">
                                <select name="is_special_notice" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                </form> <!-- END FORM -->

                <!-- Recent Drafts Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Recent Drafts</h3>
                    </div>
                    <div class="p-6">
                        <?php if(empty($recentDrafts)): ?>
                            <p class="text-[13px] text-gray-500">No recent drafts.</p>
                        <?php else: ?>
                            <?php foreach($recentDrafts as $draft): ?>
                            <div class="flex flex-col gap-1.5 cursor-pointer group mb-4">
                                <h4 class="font-semibold text-gray-900 text-[13px] group-hover:text-[#4E0000] transition-colors leading-snug"><?= htmlspecialchars($draft['title']) ?></h4>
                                <p class="text-[11px] text-gray-500">Last edited <?= date('M d, Y', strtotime($draft['created_at'])) ?></p>
                                <div class="mt-1">
                                    <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
