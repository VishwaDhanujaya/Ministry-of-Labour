<?php 
http_response_code(404);
$pageTitle = "404 - Page Not Found";
include 'includes/header.php'; 

// Localized Content Arrays
$titleText = [
    'en' => 'Page Not Found',
    'si' => 'පිටුව සොයාගත නොහැක',
    'ta' => 'பக்கம் கண்டறியப்படவில்லை'
];

$descText = [
    'en' => 'Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.',
    'si' => 'ඔබ සොයන පිටුව ඉවත් කර ඇති, නම වෙනස් කර ඇති හෝ තාවකාලිකව අක්‍රිය කර තිබිය හැක.',
    'ta' => 'நீங்கள் தேடும் பக்கம் நீக்கப்பட்டிருக்கலாம், பெயர் மாற்றப்பட்டிருக்கலாம் அல்லது தற்காலிகமாக கிடைக்காமல் போகலாம்.'
];

$btnHomeText = [
    'en' => 'Return to Homepage',
    'si' => 'ප්‍රධාන පිටුවට',
    'ta' => 'முகப்புப் பக்கத்திற்கு'
];

$btnContactText = [
    'en' => 'Contact Support',
    'si' => 'සහාය අමතන්න',
    'ta' => 'உதவிக்கு தொடர்பு கொள்ளவும்'
];
?>

<main class="min-h-[75vh] flex items-center justify-center bg-gradient-to-br from-primary/5 via-[#F9FAFB] to-secondary/5 py-16 px-4 relative overflow-hidden">
    <!-- Decorative Ambient Blur Orbs -->
    <div class="absolute w-96 h-96 rounded-full bg-primary/5 blur-3xl -top-20 -left-20 pointer-events-none animate-pulse"></div>
    <div class="absolute w-96 h-96 rounded-full bg-secondary/5 blur-3xl -bottom-20 -right-20 pointer-events-none animate-pulse" style="animation-delay: 2s;"></div>

    <div class="max-w-xl w-full text-center relative z-10" data-aos="fade-up" data-aos-duration="800">
        <!-- Floating Animated Card -->
        <div class="bg-white rounded-[32px] shadow-xl border border-gray-100 p-8 md:p-12 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
            
            <!-- Icon with Glow and Floating Animation -->
            <div class="mb-6 flex justify-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-secondary/10 to-primary/10 flex items-center justify-center shadow-inner relative animate-float">
                    <svg class="w-12 h-12 text-secondary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                    <span class="absolute inset-0 rounded-full border border-secondary/20 animate-ping opacity-25"></span>
                </div>
            </div>
            
            <h1 class="text-8xl font-black bg-clip-text text-transparent bg-gradient-to-r from-secondary via-primary to-secondary font-montserrat tracking-tight mb-2 select-none animate-pulse">404</h1>
            
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 font-montserrat mb-4 tracking-wide uppercase">
                <?= htmlspecialchars($titleText[$current_lang]) ?>
            </h2>
            
            <p class="text-gray-500 mb-10 font-inter text-sm md:text-[14.5px] max-w-sm mx-auto leading-relaxed">
                <?= htmlspecialchars($descText[$current_lang]) ?>
            </p>
            
            <!-- Modern CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="home" class="w-full sm:w-auto inline-flex items-center justify-center bg-gradient-to-r from-primary to-[#1e3d62] text-white font-bold px-8 py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary/20 active:scale-95 transition-all duration-300 text-xs tracking-wider uppercase font-montserrat">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
                    <?= htmlspecialchars($btnHomeText[$current_lang]) ?>
                </a>
                <a href="contact-us" class="w-full sm:w-auto inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-700 font-bold px-8 py-3 rounded-xl hover:border-secondary hover:text-secondary active:scale-95 transition-all duration-300 text-xs tracking-wider uppercase font-montserrat">
                    <?= htmlspecialchars($btnContactText[$current_lang]) ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
