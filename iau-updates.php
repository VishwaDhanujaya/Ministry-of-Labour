<?php
require_once 'admin/includes/db.php';

$page_title = 'IAU Updates';
$pageTitle = 'IAU Updates - Ministry of Labour - Sri Lanka';
$metaDescription = 'View latest gallery updates from the Internal Affairs Unit (IAU) of the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'IAU, Internal Affairs Unit, Updates, Gallery, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
$breadcrumbs = [
    ['label' => 'IAU', 'url' => 'iau'],
    ['label' => 'IAU Updates']
];
include 'includes/sub-hero.php';

// Fetch active gallery albums from the database
$stmt = $pdo->prepare("SELECT * FROM iau_updates WHERE is_active = 1 ORDER BY created_at DESC");
$stmt->execute();
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

$gallery_items = [];
foreach ($albums as $album) {
    // Fetch associated gallery images
    $imgStmt = $pdo->prepare("SELECT image_path FROM iau_update_images WHERE update_id = ? ORDER BY sort_order ASC, id ASC");
    $imgStmt->execute([$album['id']]);
    $images = $imgStmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Build full slide images array starting with cover image
    $album_images = $images;
    if (!empty($album['cover_image']) && !in_array($album['cover_image'], $album_images)) {
        array_unshift($album_images, $album['cover_image']);
    }
    
    // Fallback if no images are attached
    if (empty($album_images)) {
        $album_images[] = 'assets/img/placeholder.jpg';
    }
    
    $gallery_items[] = [
        'id' => $album['id'],
        'title_en' => $album['title_en'],
        'title_si' => $album['title_si'],
        'title_ta' => $album['title_ta'],
        'cover_image' => !empty($album['cover_image']) ? $album['cover_image'] : 'assets/img/placeholder.jpg',
        'images' => $album_images,
        'date' => $album['created_at']
    ];
}
?>

<section class="py-12 md:py-16 px-4 md:px-16 bg-[#F9FAFB] min-h-[75vh]">
    <div class="container mx-auto max-w-6xl">
        
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-bold text-primary font-montserrat tracking-tight uppercase"><?= t('iau_updates', 'IAU Updates') ?></h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto"><?= t('iau_gallery_desc', 'Explore our latest activities and engagements promoting integrity and transparency within the Ministry.') ?></p>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($gallery_items as $index => $item): 
                $item_title = $item['title_en'];
                if ($current_lang === 'si' && !empty($item['title_si'])) $item_title = $item['title_si'];
                elseif ($current_lang === 'ta' && !empty($item['title_ta'])) $item_title = $item['title_ta'];
            ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col cursor-pointer" onclick="openGalleryModal(<?= $index ?>)">
                <div class="relative h-60 w-full overflow-hidden bg-gray-100">
                    <img src="<?= htmlspecialchars($item['cover_image']) ?>" alt="<?= htmlspecialchars($item_title) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 fallback-img">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors duration-300"></div>
                    <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm rounded-full p-2.5 text-primary opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800 text-[17px] leading-snug mb-3 group-hover:text-secondary transition-colors"><?= htmlspecialchars($item_title) ?></h3>
                    </div>
                    <div class="flex items-center text-xs text-gray-500 font-medium font-inter">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <?= date('M d, Y', strtotime($item['date'])) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Full Image Slider / Carousel Modal -->
<div id="galleryModal" class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300 flex-col justify-between bg-black/95 select-none p-4 md:p-8">
    
    <!-- Backdrop overlay for click-to-close on blank spaces -->
    <div class="absolute inset-0 z-0" onclick="closeGalleryModal()"></div>

    <!-- Top Bar: Title & Close Button -->
    <div class="relative z-10 flex items-center justify-between w-full max-w-7xl mx-auto pb-4 border-b border-white/10">
        <h3 id="galleryModalTitle" class="text-lg sm:text-xl font-bold text-white font-montserrat truncate pr-8"></h3>
        <button onclick="closeGalleryModal()" class="text-white/80 hover:text-white hover:bg-white/10 transition-all rounded-full p-2.5 focus:outline-none shrink-0" title="Close Gallery">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Main Image & Navigation Area (Flex Grow) -->
    <div id="galleryModalSliderContainer" class="relative z-10 flex-1 flex items-center justify-center w-full max-w-7xl mx-auto py-6">
        
        <!-- Prev Button -->
        <button onclick="prevSlide()" class="absolute left-2 md:left-4 z-20 bg-white/10 hover:bg-white text-white hover:text-primary p-3 rounded-full transition-all focus:outline-none flex items-center justify-center cursor-pointer shadow-lg" title="Previous Image">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Image Wrapper -->
        <div class="relative flex items-center justify-center w-full h-full max-h-[55vh] md:max-h-[65vh]">
            <img id="galleryModalImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain transition-all duration-300 select-none shadow-2xl rounded-lg">
        </div>

        <!-- Next Button -->
        <button onclick="nextSlide()" class="absolute right-2 md:right-4 z-20 bg-white/10 hover:bg-white text-white hover:text-primary p-3 rounded-full transition-all focus:outline-none flex items-center justify-center cursor-pointer shadow-lg" title="Next Image">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Current / Total Index Badge -->
        <div class="absolute bottom-2 right-4 bg-white/10 backdrop-blur-md text-white px-3.5 py-1 rounded-full text-xs font-bold font-inter tracking-wider">
            <span id="galleryCurrentIndex">1</span> / <span id="galleryTotalCount">1</span>
        </div>
    </div>

    <!-- Bottom Thumbnails Strip -->
    <div class="relative z-10 w-full max-w-7xl mx-auto pt-4 border-t border-white/10 overflow-x-auto">
        <div id="galleryThumbnailsContainer" class="flex gap-3 justify-center items-center overflow-x-auto min-w-max pb-1">
            <!-- Thumbnail images will be dynamically generated by JS -->
        </div>
    </div>

</div>

<script>
    // Embed the items list into Javascript
    const galleryItems = <?php echo json_encode($gallery_items); ?>;
    const currentLang = '<?= $current_lang ?>';
    
    let activeItemIndex = 0;
    let activeSlideIndex = 0;
    let touchstartX = 0;
    let touchendX = 0;

    function handleTouchStart(e) {
        touchstartX = e.changedTouches[0].screenX;
    }

    function handleTouchEnd(e) {
        touchendX = e.changedTouches[0].screenX;
        handleGesture();
    }

    function handleGesture() {
        if (touchendX < touchstartX - 50) {
            nextSlide();
        }
        if (touchendX > touchstartX + 50) {
            prevSlide();
        }
    }

    function openGalleryModal(itemIndex) {
        activeItemIndex = itemIndex;
        activeSlideIndex = 0;
        
        const item = galleryItems[itemIndex];
        
        // Translate title
        let title = item.title_en;
        if (currentLang === 'si' && item.title_si) {
            title = item.title_si;
        } else if (currentLang === 'ta' && item.title_ta) {
            title = item.title_ta;
        }

        const modal = document.getElementById('galleryModal');
        const modalTitle = document.getElementById('galleryModalTitle');
        const totalCountSpan = document.getElementById('galleryTotalCount');
        
        if (modal) {
            modalTitle.textContent = title;
            totalCountSpan.textContent = item.images.length;
            
            // Build thumbnails
            buildThumbnails();
            
            // Update active slide image
            updateSlide();
            
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
            
            document.body.classList.add('overflow-hidden');
            
            // Keyboard controls listener
            window.addEventListener('keydown', handleKeyNavigation);

            // Mobile touch swipe controls
            const slider = document.getElementById('galleryModalSliderContainer');
            if (slider) {
                slider.addEventListener('touchstart', handleTouchStart, { passive: true });
                slider.addEventListener('touchend', handleTouchEnd, { passive: true });
            }
        }
    }

    function buildThumbnails() {
        const item = galleryItems[activeItemIndex];
        const container = document.getElementById('galleryThumbnailsContainer');
        container.innerHTML = '';
        
        item.images.forEach((imgSrc, index) => {
            const thumbButton = document.createElement('button');
            thumbButton.className = `w-16 h-12 sm:w-20 sm:h-14 rounded-lg overflow-hidden border-2 transition-all cursor-pointer focus:outline-none shrink-0 ${index === activeSlideIndex ? 'border-white scale-105 shadow' : 'border-transparent hover:border-white/30'}`;
            thumbButton.onclick = () => selectSlide(index);
            
            const thumbImg = document.createElement('img');
            thumbImg.src = imgSrc;
            thumbImg.alt = 'Thumbnail';
            thumbImg.className = 'w-full h-full object-cover';
            
            // Fallback for thumbnail image loading error
            thumbImg.onerror = function() {
                this.src = 'assets/img/placeholder.jpg';
            };
            
            thumbButton.appendChild(thumbImg);
            container.appendChild(thumbButton);
        });
    }

    function selectSlide(slideIndex) {
        activeSlideIndex = slideIndex;
        updateSlide();
    }

    function prevSlide() {
        const item = galleryItems[activeItemIndex];
        activeSlideIndex = (activeSlideIndex - 1 + item.images.length) % item.images.length;
        updateSlide();
    }

    function nextSlide() {
        const item = galleryItems[activeItemIndex];
        activeSlideIndex = (activeSlideIndex + 1) % item.images.length;
        updateSlide();
    }

    function updateSlide() {
        const item = galleryItems[activeItemIndex];
        const imgSrc = item.images[activeSlideIndex];
        
        const modalImage = document.getElementById('galleryModalImage');
        const currentIndexSpan = document.getElementById('galleryCurrentIndex');
        
        if (modalImage) {
            // Apply slight fade transition when loading new image
            modalImage.style.opacity = '0.7';
            modalImage.src = imgSrc;
            
            modalImage.onload = () => {
                modalImage.style.opacity = '1';
            };
            
            // Fallback for main image error
            modalImage.onerror = () => {
                modalImage.src = 'assets/img/placeholder.jpg';
                modalImage.style.opacity = '1';
            };
            
            currentIndexSpan.textContent = activeSlideIndex + 1;
            
            // Update active state on thumbnails
            const thumbnails = document.getElementById('galleryThumbnailsContainer').children;
            Array.from(thumbnails).forEach((thumb, idx) => {
                if (idx === activeSlideIndex) {
                    thumb.className = 'w-16 h-12 sm:w-20 sm:h-14 rounded-lg overflow-hidden border-2 transition-all cursor-pointer focus:outline-none shrink-0 border-white scale-105 shadow';
                } else {
                    thumb.className = 'w-16 h-12 sm:w-20 sm:h-14 rounded-lg overflow-hidden border-2 transition-all cursor-pointer focus:outline-none shrink-0 border-transparent hover:border-white/30';
                }
            });
        }
    }

    function closeGalleryModal() {
        const modal = document.getElementById('galleryModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('galleryModalImage').src = '';
            }, 300);
            
            document.body.classList.remove('overflow-hidden');
            window.removeEventListener('keydown', handleKeyNavigation);

            // Remove mobile touch swipe controls
            const slider = document.getElementById('galleryModalSliderContainer');
            if (slider) {
                slider.removeEventListener('touchstart', handleTouchStart);
                slider.removeEventListener('touchend', handleTouchEnd);
            }
        }
    }

    function handleKeyNavigation(e) {
        if (e.key === 'ArrowLeft') {
            prevSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        } else if (e.key === 'Escape') {
            closeGalleryModal();
        }
    }

    // Move modal to body to avoid main stacking context, and handle missing images
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('galleryModal');
        if (modal) {
            document.body.appendChild(modal);
        }

        const images = document.querySelectorAll('.fallback-img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'assets/img/placeholder.jpg';
                this.classList.add('opacity-50');
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
