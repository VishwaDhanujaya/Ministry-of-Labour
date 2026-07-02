<?php
// contact-us.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'admin/includes/db.php';
require_once 'includes/officials-service.php';

$contact_departments = buildContactDepartments($pdo);

$page_title = 'Contact Us';
$pageTitle = 'Contact Us - Ministry of Labour - Sri Lanka';
$metaDescription = 'Get in touch with the Ministry of Labour, Sri Lanka. Find contact details for our officials, departments, and leave us a message.';
$metaKeywords = 'Contact Us, Ministry of Labour, Sri Lanka, Phone, Email, Address, Inquiry';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Get In Touch Title -->
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter">Get In Touch</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Stay updated with Ministry of Labour</h2>
        </div>

        <!-- Info Boxes -->
        <div class="flex flex-col lg:flex-row rounded-2xl overflow-hidden border border-gray-200 mb-16 md:mb-20 shadow-sm" data-aos="fade-up" data-aos-delay="100">
            <!-- Address -->
            <a href="https://maps.app.goo.gl/uXfX4g7XWw9AFTLd8" target="_blank" rel="noopener noreferrer" class="flex-1 bg-secondary text-white p-6 sm:p-8 lg:p-10 flex flex-col items-start justify-center hover:bg-secondary/90 transition-colors group cursor-pointer">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-white rounded-full flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-medium font-montserrat">Address</h3>
                </div>
                <p class="text-xs md:text-[13px] font-inter text-gray-200 leading-relaxed">
                    6th floor, Mehewara Piyasa,<br>Narahenpita, Colombo 05, Sri Lanka.
                </p>
            </a>
            
            <!-- Phone -->
            <a href="tel:+94112581991" class="flex-1 bg-[#FAFAFA] p-6 sm:p-8 lg:p-10 flex flex-col items-start justify-center border-b lg:border-b-0 lg:border-r border-gray-200 hover:bg-gray-50 transition-colors group cursor-pointer notranslate">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-secondary rounded-full flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-medium font-montserrat text-gray-900">Phone number</h3>
                </div>
                <p class="text-xs md:text-[13px] font-inter text-gray-600">
                    (+94) 11 2581991
                </p>
            </a>

            <!-- Fax -->
            <a href="tel:+94112368165" class="flex-1 bg-[#FAFAFA] p-6 sm:p-8 lg:p-10 flex flex-col items-start justify-center border-b lg:border-b-0 lg:border-r border-gray-200 hover:bg-gray-50 transition-colors group cursor-pointer notranslate">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-secondary rounded-full flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-medium font-montserrat text-gray-900">Fax</h3>
                </div>
                <p class="text-xs md:text-[13px] font-inter text-gray-600">
                    (+94) 11 2368165
                </p>
            </a>

            <!-- Email -->
            <a href="mailto:info@labourmin.gov.lk" class="flex-1 bg-[#FAFAFA] p-6 sm:p-8 lg:p-10 flex flex-col items-start justify-center hover:bg-gray-50 transition-colors group cursor-pointer">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-secondary rounded-full flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-medium font-montserrat text-gray-900">Email Address</h3>
                </div>
                <p class="text-xs md:text-[13px] font-inter text-gray-600 break-all">
                    info@labourmin.gov.lk
                </p>
            </a>
        </div>

        <!-- Form and Map Container -->
        <div class="bg-[#F9F9F9] rounded-[24px] p-6 sm:p-8 md:p-12 flex flex-col lg:flex-row gap-10 lg:gap-16 mb-16 md:mb-20 border border-gray-200" data-aos="fade-up" data-aos-delay="200">
            
            <!-- Form -->
            <div class="flex-1">
                <h3 class="text-[22px] md:text-[26px] font-semibold font-montserrat text-gray-900 mb-6 md:mb-8">Leave Us A Message</h3>
                
                <!-- WhatsApp Complaints Callout -->
                <div class="mb-8 p-5 bg-[#EFF8F6] border border-teal-100 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-up">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center shrink-0 shadow-sm text-white">
                            <!-- Clean simple WhatsApp / Message SVG -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-teal-800/70 font-semibold font-inter uppercase tracking-wider">Complaints Hotline</p>
                            <p class="text-base font-bold text-teal-900 font-inter notranslate mt-0.5">070 722 7877 <span class="text-xs font-normal text-teal-700/80">(WhatsApp Only)</span></p>
                        </div>
                    </div>
                    <a href="https://wa.me/94707227877" target="_blank" rel="noopener noreferrer" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2.5 rounded-lg transition-colors inline-block whitespace-nowrap font-inter shadow-sm active:scale-95">
                        Send Message
                    </a>
                </div>
                
                <form id="contactForm" class="space-y-4 md:space-y-5">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <div>
                        <label for="fullname" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="fullname" name="fullname" required class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="John Doe">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                        <div>
                            <label for="email" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="john@example.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="+94 77 123 4567">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Message <span class="text-red-500">*</span></label>
                        <textarea id="message" name="message" required rows="4" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors resize-none md:rows-5" placeholder="How can we help you?"></textarea>
                    </div>

                    <div class="pt-2 md:pt-4 text-center md:text-left">
                        <button type="submit" id="submitBtn" class="btn-primary w-full md:w-auto font-inter gap-2">
                            <span>Send Message</span>
                            <svg id="submitSpinner" class="hidden w-4 h-4 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Map -->
            <div class="flex-1 rounded-[20px] overflow-hidden min-h-[300px] md:min-h-[400px] lg:min-h-full relative border border-gray-200 mt-6 lg:mt-0">
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
        <h3 class="text-xl md:text-[22px] font-semibold font-montserrat text-gray-900 mb-5 md:mb-6" data-aos="fade-up">Contact Numbers</h3>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200 border border-gray-200 rounded-2xl overflow-hidden font-inter" data-aos="fade-up" data-aos-delay="100">
            <?php foreach($contact_departments as $dept): ?>
            <div onclick="openModal('<?php echo $dept['id']; ?>')" class="bg-[#FAFAFA] cursor-pointer py-6 md:py-8 px-2 sm:px-4 flex items-center justify-center font-medium text-gray-900 text-sm md:text-[15px] hover:bg-gray-100 transition-colors text-center h-full">
                <?php echo $dept['title']; ?>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Department Modals -->
<?php foreach($contact_departments as $dept): ?>
<div id="<?php echo $dept['id']; ?>" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal('<?php echo $dept['id']; ?>')"></div>
    
    <div class="relative w-full max-w-[600px] max-h-[90vh] overflow-y-auto bg-secondary rounded-2xl shadow-2xl p-6 sm:p-8 md:p-12 text-center text-white custom-scrollbar transform scale-95 transition-all duration-300">
        <button onclick="closeModal('<?php echo $dept['id']; ?>')" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/80 hover:text-white transition-all z-10 bg-black/20 hover:bg-black/40 rounded-full p-1.5 active:scale-95 flex items-center justify-center focus:outline-none">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <h3 class="text-xl md:text-[26px] font-semibold font-montserrat mb-4 md:mb-6 sticky top-0 bg-secondary pt-2 pb-4"><?php echo $dept['title']; ?></h3>
        
        <div class="space-y-8 font-inter">
            <?php foreach($dept['people'] as $index => $person): ?>
                <?php if($index > 0): ?>
                    <hr class="border-white/20 w-[60%] mx-auto my-6">
                <?php endif; ?>
                <div>
                    <p class="text-[18px] sm:text-xl md:text-[22px] font-semibold font-montserrat mb-1 md:mb-2 leading-tight"><?php echo $person['name']; ?></p>
                    <?php if($person['designation']): ?>
                    <p class="text-sm md:text-base text-gray-300 pb-1 md:pb-2"><?php echo $person['designation']; ?></p>
                    <?php endif; ?>
                    
                    <div class="space-y-1 mt-3">
                        <?php if($person['phone']): ?>
                        <p class="text-xs md:text-[14px] text-gray-200">Tel: <span class="notranslate"><?php echo $person['phone']; ?></span></p>
                        <?php endif; ?>
                        
                        <?php if($person['fax']): ?>
                        <p class="text-xs md:text-[14px] text-gray-200">Fax: <span class="notranslate"><?php echo $person['fax']; ?></span></p>
                        <?php endif; ?>
                        
                        <?php if($person['email']): ?>
                        <p class="text-xs md:text-[14px] text-gray-200">Email: <a href="mailto:<?php echo $person['email']; ?>" class="hover:text-white transition-colors"><?php echo $person['email']; ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            if (modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const card = modal.querySelector('.transform');
                if(card) { card.classList.remove('scale-95'); card.classList.add('scale-100'); }
            }, 10);
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            const card = modal.querySelector('.transform');
            if(card) { card.classList.remove('scale-100'); card.classList.add('scale-95'); }
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('submitSpinner');
        const btnText = submitBtn.querySelector('span');

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
        spinner.classList.remove('hidden');
        btnText.textContent = 'Sending...';

        // Prepare data
        const formData = new FormData(form);

        // Send AJAX request
        fetch('process-contact', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Restore button
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            spinner.classList.add('hidden');
            btnText.textContent = 'Send Message';

            if (data.success) {
                if (window.showToast) {
                    window.showToast('Message sent successfully!', 'success');
                } else {
                    alert('Message sent successfully!');
                }
                form.reset();
            } else {
                if (window.showToast) {
                    window.showToast(data.message || 'Failed to send message.', 'error');
                } else {
                    alert('Failed to send message: ' + (data.message || 'Unknown error'));
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Restore button
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
            spinner.classList.add('hidden');
            btnText.textContent = 'Send Message';
            if (window.showToast) {
                window.showToast('An error occurred. Please try again later.', 'error');
            } else {
                alert('An error occurred. Please try again later.');
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
