<?php
// article.php
require_once 'admin/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: news");
    exit;
}

$stmt = $pdo->prepare("SELECT n.*, a.name as author_name FROM news n LEFT JOIN admins a ON n.author_id = a.id WHERE n.id = ? AND n.status = 'Published'");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: news");
    exit;
}

// Override title and content based on current language
if ($current_lang === 'si') {
    if (!empty($article['title_si'])) $article['title'] = $article['title_si'];
    if (!empty($article['content_si'])) $article['content'] = $article['content_si'];
} elseif ($current_lang === 'ta') {
    if (!empty($article['title_ta'])) $article['title'] = $article['title_ta'];
    if (!empty($article['content_ta'])) $article['content'] = $article['content_ta'];
}

// Fetch additional images
$imgStmt = $pdo->prepare("SELECT * FROM news_images WHERE news_id = ?");
$imgStmt->execute([$id]);
$additionalImages = $imgStmt->fetchAll();

// Fetch recent posts for sidebar (limit 10)
$recentPostsRaw = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC LIMIT 10")->fetchAll();
$recentPosts = [];
foreach ($recentPostsRaw as $post) {
    if ($current_lang === 'si' && !empty($post['title_si'])) $post['title'] = $post['title_si'];
    elseif ($current_lang === 'ta' && !empty($post['title_ta'])) $post['title'] = $post['title_ta'];
    $recentPosts[] = $post;
}

// Fetch Previous Article
$prevStmt = $pdo->prepare("SELECT * FROM news WHERE status = 'Published' AND (created_at < ? OR (created_at = ? AND id < ?)) ORDER BY created_at DESC, id DESC LIMIT 1");
$prevStmt->execute([$article['created_at'], $article['created_at'], $article['id']]);
$prevArticle = $prevStmt->fetch();
if ($prevArticle) {
    if ($current_lang === 'si' && !empty($prevArticle['title_si'])) $prevArticle['title'] = $prevArticle['title_si'];
    elseif ($current_lang === 'ta' && !empty($prevArticle['title_ta'])) $prevArticle['title'] = $prevArticle['title_ta'];
}

// Fetch Next Article
$nextStmt = $pdo->prepare("SELECT * FROM news WHERE status = 'Published' AND (created_at > ? OR (created_at = ? AND id > ?)) ORDER BY created_at ASC, id ASC LIMIT 1");
$nextStmt->execute([$article['created_at'], $article['created_at'], $article['id']]);
$nextArticle = $nextStmt->fetch();
if ($nextArticle) {
    if ($current_lang === 'si' && !empty($nextArticle['title_si'])) $nextArticle['title'] = $nextArticle['title_si'];
    elseif ($current_lang === 'ta' && !empty($nextArticle['title_ta'])) $nextArticle['title'] = $nextArticle['title_ta'];
}

$page_title = 'News';
$pageTitle = strip_tags($article['title']);
$metaDescription = mb_substr(strip_tags($article['content']), 0, 160);
$metaKeywords = 'Ministry of Labour, News, Sri Lanka, Updates';

// Determine absolute base URL dynamically
$base_dir_news = dirname($_SERVER['SCRIPT_NAME']);
if ($base_dir_news === '\\' || $base_dir_news === '/') {
    $base_dir_news = '';
}
$site_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $base_dir_news . '/';

if (!empty($article['cover_image'])) {
    $ogImage = $site_url . 'admin/' . ltrim($article['cover_image'], '/');
}
$ogUrl = $site_url . 'news/' . $article['id'];

$breadcrumbs = [
    ['label' => 'News', 'url' => 'news'],
    ['label' => htmlspecialchars($article['title'])]
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-[1400px]">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-2xl sm:text-3xl md:text-[38px] font-semibold font-montserrat text-[#2D2D43] mb-6 leading-tight notranslate">
                    <?= htmlspecialchars($article['title']) ?>
                </h2>
                
                <div class="flex items-center gap-6 text-[13px] font-inter text-gray-500 font-medium mb-8 pb-4 border-b border-gray-200">

                    <span><?= date('F j, Y', strtotime($article['created_at'])) ?></span>
                </div>

                <?php if (!empty($article['cover_image']) && file_exists('admin/' . $article['cover_image'])): ?>
                <div class="mb-10 rounded-2xl overflow-hidden shadow-sm cursor-pointer group">
                    <a data-fslightbox="gallery" href="<?= $base_url ?>admin/<?= htmlspecialchars($article['cover_image']) ?>" class="block w-full h-full">
                        <img loading="lazy" src="<?= $base_url ?>admin/<?= htmlspecialchars($article['cover_image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-auto object-cover max-h-[500px] hover:scale-105 transition-transform duration-500">
                    </a>
                </div>
                <?php endif; ?>

                <div class="prose max-w-none text-gray-600 font-inter text-[15px] leading-relaxed mb-12 space-y-6 notranslate">
                    <?= $article['content'] // Content is typically rich text (HTML) so we output it directly ?>
                </div>

                <?php if (!empty($additionalImages)): ?>
                <div class="mb-12">
                    <h3 class="text-xl font-semibold font-montserrat text-[#2D2D43] mb-6">Gallery</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        <?php foreach($additionalImages as $img): ?>
                            <a data-fslightbox="gallery" href="<?= $base_url ?>admin/<?= htmlspecialchars($img['image_path']) ?>" class="block rounded-xl overflow-hidden shadow-sm aspect-square bg-gray-100 cursor-pointer group relative active:scale-95 transition-transform duration-200">
                                <img loading="lazy" src="<?= $base_url ?>admin/<?= htmlspecialchars($img['image_path']) ?>" class="w-full h-full object-cover md:group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/10 opacity-0 active:opacity-100 md:group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Pagination Links -->
                <div class="flex flex-col md:flex-row justify-between border-t border-gray-200 pt-8 gap-8">
                    <?php if ($prevArticle): ?>
                    <a href="news/<?= $prevArticle['id'] ?>" class="group max-w-xs block">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">&lt; Previous</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed notranslate"><?= htmlspecialchars($prevArticle['title']) ?></p>
                    </a>
                    <?php else: ?>
                    <div class="max-w-xs opacity-40">
                        <div class="text-[15px] font-montserrat text-gray-400 font-semibold mb-2">&lt; Previous</div>
                        <p class="text-[13px] text-gray-400 font-inter leading-relaxed">No older updates</p>
                    </div>
                    <?php endif; ?>

                    <?php if ($nextArticle): ?>
                    <a href="news/<?= $nextArticle['id'] ?>" class="group max-w-xs text-left md:text-right block">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">Next &gt;</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed notranslate"><?= htmlspecialchars($nextArticle['title']) ?></p>
                    </a>
                    <?php else: ?>
                    <div class="max-w-xs text-left md:text-right opacity-40">
                        <div class="text-[15px] font-montserrat text-gray-400 font-semibold mb-2">Next &gt;</div>
                        <p class="text-[13px] text-gray-400 font-inter leading-relaxed">No newer updates</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar (Reused from news.php) -->
            <div class="w-full lg:w-1/3">
                <div class="border border-gray-100 rounded-3xl p-8 sticky top-32 bg-white shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                    <!-- Search -->
                    <div class="mb-10">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[13px] placeholder-gray-400 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-inter" placeholder="Search">
                        </div>
                    </div>
                    
                    <!-- Recent Posts -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Recent Posts</h3>
                        <ul class="space-y-5">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="news/<?= $post['id'] ?>" class="flex items-start gap-4 group">
                                    <div class="w-14 h-14 rounded-xl border border-slate-100 bg-slate-50 overflow-hidden shrink-0 shadow-sm relative group-hover:shadow-md transition-all duration-300">
                                        <?php if (!empty($post['cover_image']) && file_exists('admin/' . $post['cover_image'])): ?>
                                            <img loading="lazy" src="<?= $base_url ?>admin/<?= htmlspecialchars($post['cover_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-[13.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors line-clamp-2 leading-snug notranslate" title="<?= htmlspecialchars($post['title']) ?>">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </h4>
                                        <span class="text-[11px] text-slate-400 font-inter font-medium tracking-wide mt-1 block"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
