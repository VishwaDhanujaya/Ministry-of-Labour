<!-- Hero Section -->
<section class="relative h-[300px] md:h-[400px] flex items-center bg-primary overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/sub-hero.webp');"></div>
    <div class="absolute inset-0 opacity-70 bg-sub-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold font-montserrat mb-4 leading-none tracking-tighter <?php echo isset($title_classes) ? $title_classes : ''; ?>">
            <?php echo isset($page_title) ? $page_title : 'Ministry of Labour'; ?>
        </h1>
        <div class="flex items-center text-[13px] md:text-sm font-inter text-gray-300">
            <a href="index" class="hover:text-white transition-colors">Home</a>
            <?php
            if (isset($breadcrumbs) && is_array($breadcrumbs)) {
                foreach ($breadcrumbs as $index => $crumb) {
                    echo '<span class="mx-2">/</span>';
                    echo "\n            ";
                    if ($index === count($breadcrumbs) - 1) {
                        // Last item is always plain white text
                        echo '<span class="text-white">' . htmlspecialchars($crumb['label']) . '</span>';
                    } else {
                        // Intermediate items
                        if (isset($crumb['url'])) {
                            echo '<a href="' . htmlspecialchars($crumb['url']) . '" class="hover:text-white transition-colors">' . htmlspecialchars($crumb['label']) . '</a>';
                        } else {
                            echo '<span class="hover:text-white transition-colors cursor-pointer">' . htmlspecialchars($crumb['label']) . '</span>';
                        }
                    }
                }
                echo "\n";
            } else if (isset($page_title)) {
                 // Fallback if no breadcrumbs array is passed but title is
                 echo '<span class="mx-2">/</span>';
                 echo "\n            ";
                 echo '<span class="text-white">' . htmlspecialchars($page_title) . '</span>';
                 echo "\n";
            }
            ?>
        </div>
    </div>
</section>
