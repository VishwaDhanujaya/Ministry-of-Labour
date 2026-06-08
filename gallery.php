<?php
// gallery.php
require_once 'admin/includes/db.php';

$galleryAlbums = $pdo->query("SELECT * FROM gallery WHERE status = 'Public' ORDER BY created_at DESC")->fetchAll();

$page_title = 'Gallery Albums';
$pageTitle = 'Gallery - Ministry of Labour - Sri Lanka';
$metaDescription = 'Explore the visual highlights and recent events of the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Gallery, Photos, Events, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-[1400px]">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter uppercase">Our Gallery</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Visual Highlights</h2>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
            
            <?php if(empty($galleryAlbums)): ?>
                <div class="col-span-2 lg:col-span-4 text-center text-gray-500 py-10">No gallery albums available yet.</div>
            <?php else: ?>
                <?php foreach ($galleryAlbums as $album): ?>
                <!-- Gallery Album Item -->
                <a href="gallery-album/<?= $album['id'] ?>" class="group relative bg-gray-100 rounded-[20px] overflow-hidden aspect-[4/5] sm:aspect-[3/4] md:aspect-[4/5] lg:aspect-auto lg:h-[320px] shadow-[0_4px_20px_rgb(0,0,0,0.04)] cursor-pointer block">
                    <img loading="lazy" src="admin/<?= htmlspecialchars($album['cover_image']) ?>"
                        alt="<?= htmlspecialchars($album['title']); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(102,102,102,0)_0%,rgba(10,10,10,0.8)_100%)] opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Text Content -->
                    <div class="absolute inset-x-0 bottom-0 p-4 sm:p-6 flex justify-between items-end">
                        <h3 class="text-white text-[13px] sm:text-[15px] font-medium font-inter leading-snug max-w-[80%]">
                            <?= htmlspecialchars($album['title']); ?>
                        </h3>
                        <div class="bg-white/20 backdrop-blur-md rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Lightbox Modal container for Media Gallery -->
<div id="lightbox-modal"
    class="fixed inset-0 bg-[#070e17]/95 backdrop-blur-md z-[120] opacity-0 pointer-events-none transition-all duration-500 flex flex-col justify-center items-center p-4">
    <!-- Close button -->
    <button id="lightbox-close" aria-label="Close Lightbox"
        class="absolute top-6 right-6 w-11 h-11 bg-black/60 hover:bg-black/80 border border-white/20 rounded-full flex items-center justify-center text-white active:scale-95 transition-all focus:outline-none shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <!-- Content -->
    <div class="w-full max-w-4xl flex flex-col items-center">
        <div
            class="w-full h-[50vh] md:h-[60vh] bg-premium-card-fallback rounded-2xl border border-white/10 shadow-2xl flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-mesh-pattern opacity-10 animate-pulse-slow"></div>
            <img loading="lazy" id="lightbox-img" src="" alt="" class="absolute inset-0 w-full h-full object-contain hidden z-10">
            <div id="lightbox-placeholder" class="flex flex-col items-center justify-center">
                <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" stroke-width="1.2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                    </path>
                </svg>
            </div>
        </div>
        <p id="lightbox-caption"
            class="text-white text-base md:text-lg font-semibold font-montserrat mt-6 text-center max-w-xl leading-relaxed tracking-tight text-glow">
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
