<?php
// article.php
require_once 'admin/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: articles");
    exit;
}

$stmt = $pdo->prepare("SELECT n.*, a.name as author_name FROM articles n LEFT JOIN admins a ON n.author_id = a.id WHERE n.id = ? AND n.status = 'Published'");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: articles");
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
$imgStmt = $pdo->prepare("SELECT * FROM article_images WHERE article_id = ?");
$imgStmt->execute([$id]);
$additionalImages = $imgStmt->fetchAll();

// Fetch recent posts for sidebar (limit 10)
$recentPostsRaw = $pdo->query("SELECT * FROM articles WHERE status = 'Published' ORDER BY created_at DESC LIMIT 10")->fetchAll();
$recentPosts = [];
foreach ($recentPostsRaw as $post) {
    if ($current_lang === 'si' && !empty($post['title_si'])) $post['title'] = $post['title_si'];
    elseif ($current_lang === 'ta' && !empty($post['title_ta'])) $post['title'] = $post['title_ta'];
    $recentPosts[] = $post;
}

$page_title = 'Articles';
$pageTitle = strip_tags($article['title']);
$metaDescription = mb_substr(strip_tags($article['content']), 0, 160);
$metaKeywords = 'Ministry of Labour, News, Articles, Sri Lanka, Updates, ' . strip_tags($article['category']);
if (!empty($article['cover_image'])) {
    $ogImage = 'admin/' . $article['cover_image'];
}

$breadcrumbs = [
    ['label' => 'Articles', 'url' => 'articles'],
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
                <h2 class="text-3xl md:text-[38px] font-semibold font-montserrat text-[#2D2D43] mb-6 leading-tight notranslate">
                    <?= htmlspecialchars($article['title']) ?>
                </h2>
                
                <div class="flex items-center gap-6 text-[13px] font-inter text-gray-500 font-medium mb-8 pb-4 border-b border-gray-200">
                    <span><?= htmlspecialchars($article['category']) ?></span>
                    <span><?= date('F j, Y', strtotime($article['created_at'])) ?></span>
                </div>

                <?php if (!empty($article['cover_image']) && file_exists('admin/' . $article['cover_image'])): ?>
                <div class="mb-10 rounded-2xl overflow-hidden shadow-sm cursor-pointer group">
                    <a data-fslightbox="gallery" href="admin/<?= htmlspecialchars($article['cover_image']) ?>" class="block w-full h-full">
                        <img loading="lazy" src="admin/<?= htmlspecialchars($article['cover_image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-auto object-cover max-h-[500px] hover:scale-105 transition-transform duration-500">
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
                            <a data-fslightbox="gallery" href="admin/<?= htmlspecialchars($img['image_path']) ?>" class="block rounded-xl overflow-hidden shadow-sm aspect-square bg-gray-100 cursor-pointer group relative active:scale-95 transition-transform duration-200">
                                <img loading="lazy" src="admin/<?= htmlspecialchars($img['image_path']) ?>" class="w-full h-full object-cover md:group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/10 opacity-0 active:opacity-100 md:group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Pagination Links -->
                <div class="flex flex-col md:flex-row justify-between border-t border-gray-200 pt-8 gap-8">
                    <a href="#" class="group max-w-xs">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">&lt; Previous</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed">The committee approved by the Cabinet to amend the labour laws is consulting the...</p>
                    </a>
                    <a href="#" class="group max-w-xs text-left md:text-right">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">Next &gt;</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed">Press release on private sector salary increase...</p>
                    </a>
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
                        <ul class="space-y-4">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="article/<?= $post['id'] ?>" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span class="notranslate"><?= htmlspecialchars($post['title']) ?></span>
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
