<?php
// contact-us.php
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
            Contact Us
        </h1>
        <div class="flex items-center text-[13px] md:text-sm font-inter text-gray-300">
            <a href="index" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Contact Us</span>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Get In Touch Title -->
        <div class="text-center mb-12">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter">Get In Touch</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Stay updated with Ministry of Labour</h2>
        </div>

        <!-- Info Boxes -->
        <div class="flex flex-col md:flex-row rounded-2xl overflow-hidden border border-gray-200 mb-20 shadow-sm">
            <!-- Address -->
            <div class="flex-1 bg-secondary text-white p-8 lg:p-10 flex flex-col items-start justify-center">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium font-montserrat">Address</h3>
                </div>
                <p class="text-[13px] font-inter text-gray-200 leading-relaxed">
                    6th floor, Mehewara Piyasa,<br>Narahenpita, Colombo 05, Sri Lanka.
                </p>
            </div>
            
            <!-- Phone -->
            <div class="flex-1 bg-[#FAFAFA] p-8 lg:p-10 flex flex-col items-start justify-center border-b md:border-b-0 md:border-r border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 bg-secondary rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium font-montserrat text-gray-900">Phone number</h3>
                </div>
                <p class="text-[13px] font-inter text-gray-600">
                    (+94) 11 2581991
                </p>
            </div>

            <!-- Fax -->
            <div class="flex-1 bg-[#FAFAFA] p-8 lg:p-10 flex flex-col items-start justify-center border-b md:border-b-0 md:border-r border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 bg-secondary rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium font-montserrat text-gray-900">Fax</h3>
                </div>
                <p class="text-[13px] font-inter text-gray-600">
                    (+94) 11 2368165
                </p>
            </div>

            <!-- Email -->
            <div class="flex-1 bg-[#FAFAFA] p-8 lg:p-10 flex flex-col items-start justify-center">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-11 h-11 bg-secondary rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium font-montserrat text-gray-900">Email Address</h3>
                </div>
                <p class="text-[13px] font-inter text-gray-600">
                    info@labourmin.gov.lk
                </p>
            </div>
        </div>

        <!-- Form and Map Container -->
        <div class="bg-[#F9F9F9] rounded-[24px] p-8 md:p-12 flex flex-col lg:flex-row gap-12 lg:gap-16 mb-20 border border-gray-200">
            
            <!-- Form -->
            <div class="flex-1">
                <h3 class="text-[26px] font-semibold font-montserrat text-gray-900 mb-8">Leave Us A Message</h3>
                
                <form class="space-y-5">
                    <div>
                        <label for="fullname" class="block text-[13px] font-medium text-gray-500 font-inter mb-2">Full Name</label>
                        <input type="text" id="fullname" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-3 outline-none transition-colors" placeholder="">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block text-[13px] font-medium text-gray-500 font-inter mb-2">Email Address</label>
                            <input type="email" id="email" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-3 outline-none transition-colors" placeholder="">
                        </div>
                        <div>
                            <label for="phone" class="block text-[13px] font-medium text-gray-500 font-inter mb-2">Phone Number</label>
                            <input type="tel" id="phone" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-3 outline-none transition-colors" placeholder="">
                        </div>
                    </div>

                    <div>
                        <label for="department" class="block text-[13px] font-medium text-gray-500 font-inter mb-2">Department</label>
                        <input type="text" id="department" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-3 outline-none transition-colors" placeholder="">
                    </div>

                    <div>
                        <label for="message" class="block text-[13px] font-medium text-gray-500 font-inter mb-2">Message</label>
                        <textarea id="message" rows="5" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-3 outline-none transition-colors resize-none" placeholder=""></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="button" class="bg-secondary text-white font-medium rounded-lg text-[13px] px-8 py-3 hover:bg-secondary/90 transition-colors font-inter inline-flex items-center gap-2">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Map -->
            <div class="flex-1 rounded-[20px] overflow-hidden min-h-[400px] lg:min-h-full relative border border-gray-200">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9702243834064!2d79.87326847590506!3d6.894165993105747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a2e3795b501%3A0xc3ec5bc1eb657736!2sMehewara%20Piyasa!5e0!3m2!1sen!2slk!4v1707297383610!5m2!1sen!2slk" 
                    class="absolute inset-0 w-full h-full border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>

        <!-- Contact Numbers -->
        <h3 class="text-[22px] font-semibold font-montserrat text-gray-900 mb-6">Contact Numbers</h3>
        <div class="bg-[#FAFAFA] rounded-2xl border border-gray-200 overflow-hidden font-inter">
            <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200 border-b border-gray-200">
                <!-- Row 1 -->
                <div onclick="openModal('minister-modal')" class="cursor-pointer py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Minister</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Deputy Minister</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Secretary</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Administration Division</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                <!-- Row 2 -->
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Development Division</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Planning Division</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Finance Division</div>
                <div class="py-8 px-4 flex items-center justify-center font-medium text-gray-900 text-[15px] hover:bg-gray-100/50 transition-colors text-center">Internal Audit</div>
            </div>
        </div>

    </div>
</section>

<!-- Minister Modal -->
<div id="minister-modal" class="fixed inset-0 z-[110] hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('minister-modal')"></div>
    
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[600px] bg-secondary rounded-2xl shadow-2xl p-8 md:p-12 text-center text-white">
        <button onclick="closeModal('minister-modal')" class="absolute top-6 right-6 text-white hover:text-gray-300 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <h3 class="text-[26px] font-semibold font-montserrat mb-6">Minister</h3>
        
        <hr class="border-white/50 w-[85%] mx-auto mb-8">
        
        <div class="space-y-3 font-inter">
            <p class="text-2xl md:text-[28px] font-semibold font-montserrat mb-2 leading-tight">Hon. Minister Anil Jayantha Fernando</p>
            <p class="text-lg pb-2">Minister of Labour</p>
            <p class="text-[15px]">Tel: +9411 236 8175</p>
            <p class="text-[15px]">Fax: +9411 258 8950</p>
            <p class="text-[15px]">Email: minister@labourmin.gov.lk</p>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
