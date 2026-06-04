<?php
// gallery.php
$page_title = 'Gallery';
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            
            <?php
            $galleryItems = [
                [
                    "image" => "assets/img/gallery/gallery-1.webp",
                    "title" => "New Labour Officers Receive Appointment Letters"
                ],
                [
                    "image" => "assets/img/gallery/gallery-2.webp",
                    "title" => "National Labour Advisory Council (NLAC)"
                ],
                [
                    "image" => "assets/img/gallery/gallery-3.webp",
                    "title" => "Cabinet to amend the labour laws"
                ],
                [
                    "image" => "assets/img/gallery/gallery-4.webp",
                    "title" => "The Ministry of Labour also begins work in the new year"
                ],
                [
                    "image" => "assets/img/gallery/gallery-1.webp",
                    "title" => "New Labour Officers Receive Appointment Letters"
                ],
                [
                    "image" => "assets/img/gallery/gallery-2.webp",
                    "title" => "National Labour Advisory Council (NLAC)"
                ],
                [
                    "image" => "assets/img/gallery/gallery-3.webp",
                    "title" => "Cabinet to amend the labour laws"
                ],
                [
                    "image" => "assets/img/gallery/gallery-4.webp",
                    "title" => "The Ministry of Labour also begins work in the new year"
                ]
            ];

            foreach ($galleryItems as $item) {
            ?>
            <!-- Gallery Item -->
            <a href="gallery-single" class="group relative bg-gray-100 rounded-[20px] overflow-hidden aspect-[4/5] sm:aspect-[3/4] md:aspect-[4/5] lg:aspect-auto lg:h-[320px] shadow-[0_4px_20px_rgb(0,0,0,0.04)] cursor-pointer block">
                <img src="<?php echo $item['image']; ?>"
                    alt="<?php echo htmlspecialchars($item['title']); ?>"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(102,102,102,0)_0%,rgba(10,10,10,0.8)_100%)] opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Text Content -->
                <div class="absolute inset-x-0 bottom-0 p-6">
                    <h3 class="text-white text-[15px] font-medium font-inter leading-snug">
                        <?php echo $item['title']; ?>
                    </h3>
                </div>
            </a>
            <?php } ?>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
