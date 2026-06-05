<?php
// gallery-album.php
require_once 'admin/includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: gallery.php');
    exit;
}

$id = (int)$_GET['id'];

// Fetch the album
$stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ? AND status = 'Public'");
$stmt->execute([$id]);
$album = $stmt->fetch();

if (!$album) {
    header('Location: gallery.php');
    exit;
}

// Fetch images for this album
$imgStmt = $pdo->prepare("SELECT * FROM gallery_images WHERE gallery_id = ? ORDER BY created_at ASC");
$imgStmt->execute([$id]);
$images = $imgStmt->fetchAll();

$page_title = $album['title'] . ' - Gallery Album';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white min-h-[50vh]">
    <div class="container mx-auto max-w-[1400px]">
        
        <!-- Back Link & Title -->
        <div class="mb-12">
            <a href="gallery.php" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-secondary mb-6 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Gallery
            </a>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900"><?= htmlspecialchars($album['title']) ?></h2>
            <p class="text-gray-500 mt-2 text-[15px] font-inter">Published on <?= date('F j, Y', strtotime($album['created_at'])) ?></p>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            
            <?php if(empty($images)): ?>
                <div class="col-span-full text-center text-gray-500 py-10 bg-gray-50 rounded-xl border border-gray-100">This album has no additional images yet.</div>
            <?php else: ?>
                <?php foreach ($images as $img): ?>
                <!-- Single Image Item (Triggers Lightbox) -->
                <div class="gallery-item group relative bg-gray-100 rounded-xl overflow-hidden aspect-square shadow-sm cursor-pointer block" data-caption="<?= htmlspecialchars($album['title']) ?>">
                    <img src="admin/<?= htmlspecialchars($img['image_path']) ?>"
                        alt="<?= htmlspecialchars($album['title']); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                    
                    <!-- Hover Action -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                        <svg class="w-8 h-8 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Lightbox Modal (Reusing existing logic from scripts.js) -->
<div id="lightbox-modal" class="fixed inset-0 bg-[#070e17]/95 backdrop-blur-md z-[120] opacity-0 pointer-events-none transition-all duration-500 flex flex-col justify-center items-center p-4">
    <button id="lightbox-close" aria-label="Close Lightbox" class="absolute top-6 right-6 w-11 h-11 bg-white/5 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-white/10 active:scale-95 transition-all focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    <div class="w-full max-w-4xl flex flex-col items-center">
        <div class="w-full h-[50vh] md:h-[70vh] bg-black/50 rounded-2xl border border-white/10 shadow-2xl flex items-center justify-center relative overflow-hidden">
            <img id="lightbox-img" src="" alt="" class="absolute inset-0 w-full h-full object-contain hidden z-10">
        </div>
        <p id="lightbox-caption" class="text-white text-base md:text-lg font-semibold font-montserrat mt-6 text-center max-w-xl leading-relaxed tracking-tight text-glow"></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
