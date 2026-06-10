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

        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row justify-center gap-4 mb-10">
            <div class="relative flex-1 w-full md:max-w-xl mx-auto">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-3 font-inter transition-colors outline-none shadow-sm placeholder-gray-400" placeholder="Search albums by title...">
            </div>
        </div>

        <!-- Gallery Grid -->
        <div id="albums-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
            
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



<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const albumsGrid = document.getElementById('albums-grid');
    if (searchInput && albumsGrid) {
        const albums = albumsGrid.querySelectorAll('a.group');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            albums.forEach(album => {
                const titleElement = album.querySelector('h3');
                const title = titleElement ? titleElement.innerText.toLowerCase() : '';
                if (title.includes(searchTerm)) {
                    album.style.display = 'block';
                } else {
                    album.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>


