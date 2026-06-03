<?php
// citizen-charter.php
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[300px] md:h-[400px] flex items-center bg-primary overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/sub-hero.webp');"></div>
    <div class="absolute inset-0 opacity-70 bg-sub-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold font-montserrat mb-4 leading-none tracking-tighter">
            Citizen Charter
        </h1>
        <div class="flex items-center text-[13px] md:text-sm font-inter text-gray-300">
            <a href="index" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Citizen Charter</span>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16">
        
        <!-- Left Side: Main Text -->
        <div class="w-full lg:w-[45%]">
            <h2 class="text-3xl md:text-4xl font-semibold font-montserrat mb-8 text-gray-900 leading-tight">
                Our Commitment to Public<br>Service Excellence
            </h2>
            <div class="space-y-6 text-gray-700 font-inter text-[15px] leading-relaxed pr-0 md:pr-4">
                <p>
                    The Citizen Charter reflects the Ministry's dedication to delivering reliable, timely, and high-quality services to all citizens. It clearly defines our service standards, responsibilities, and the rights of the public, ensuring transparency and accountability in every interaction.
                </p>
                <p>
                    Through this charter, we aim to build trust, improve service delivery, and create a responsive system that prioritizes the needs and expectations of the people we serve.
                </p>
            </div>
        </div>

        <!-- Right Side: PDF Viewer -->
        <div class="w-full lg:w-[55%] flex justify-center items-start">
            <?php 
                $pdfId = 'citizen-charter-doc';
                $pdfUrl = 'assets/img/citizen-charter/citizen-charter.pdf';
                $pdfTitle = 'Citizen Charter';
                include 'includes/pdf-viewer.php'; 
            ?>
        </div>

    </div>
</section>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
