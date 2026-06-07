<?php 
http_response_code(404);
$pageTitle = "404 - Page Not Found";
include 'includes/header.php'; 
?>

<main class="min-h-[60vh] flex flex-col items-center justify-center bg-[#F9FAFB] py-20 px-4">
    <div class="max-w-xl w-full text-center">
        <!-- SVG Illustration -->
        <div class="mb-8 flex justify-center">
            <svg class="w-40 h-40 text-[#4E0000]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-7xl md:text-9xl font-bold text-[#4E0000] font-montserrat mb-4 tracking-tight">404</h1>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-montserrat mb-6">Page Not Found</h2>
        
        <p class="text-gray-600 mb-10 font-inter text-base md:text-lg max-w-md mx-auto leading-relaxed">
            Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="index.php" class="w-full sm:w-auto inline-flex items-center justify-center bg-[#B08920] text-white font-bold px-8 py-3.5 rounded-lg hover:bg-[#8e6e19] transition-colors shadow-md text-sm tracking-wide">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Return to Homepage
            </a>
            <a href="contact-us.php" class="w-full sm:w-auto inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-700 font-bold px-8 py-3 rounded-lg hover:border-gray-300 hover:bg-gray-50 transition-colors shadow-sm text-sm tracking-wide">
                Contact Support
            </a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
