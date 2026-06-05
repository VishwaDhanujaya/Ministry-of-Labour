<?php
// contact-us.php

$contact_departments = [
    [
        'id' => 'minister-modal',
        'title' => 'Minister',
        'people' => [
            [
                'name' => 'Hon. Minister Anil Jayantha Fernando',
                'designation' => 'Minister of Labour',
                'phone' => '+9411 236 8175',
                'fax' => '+9411 258 8950',
                'email' => 'minister@labourmin.gov.lk'
            ]
        ]
    ],
    [
        'id' => 'deputy-minister-modal',
        'title' => 'Deputy Minister',
        'people' => [
            [
                'name' => 'Hon. Deputy Minister of Labour - Mr. Mahinda Jayasinghe',
                'designation' => '',
                'phone' => '0112368526',
                'fax' => '0112369340',
                'email' => 'majayasinghe@gmail.com'
            ]
        ]
    ],
    [
        'id' => 'secretary-modal',
        'title' => 'Secretary',
        'people' => [
            [
                'name' => 'Mr. S.M.Piyatissa',
                'designation' => 'Secretary',
                'phone' => '+94 (0)112 368164',
                'fax' => '+94 (0)112 582938',
                'email' => 'slmol@slt.lk'
            ]
        ]
    ],
    [
        'id' => 'admin-modal',
        'title' => 'Administration Division',
        'people' => [
            [
                'name' => 'Ms. T P Muditha Pathmajay',
                'designation' => 'Additional Secretary (Administration)',
                'phone' => '+94 (0)112 368938',
                'fax' => '+94 (0)112 368165',
                'email' => 'adsec.admin@labourmin.gov.lk'
            ],
            [
                'name' => 'Mr. L.T.G.D Darshana',
                'designation' => 'Senior Assistant Secretary (Administration)',
                'phone' => '+94 (0)112 368304',
                'fax' => '+94 (0)112 368200',
                'email' => 'sas.admin@labourmin.gov.lk'
            ],
            [
                'name' => 'Ms. S Luxiga',
                'designation' => 'Assistant Secretary (Procurement)',
                'phone' => '+94 (0)112 368136',
                'fax' => '',
                'email' => ''
            ],
            [
                'name' => 'Ms. Yashoda Thissera',
                'designation' => 'Assistant Secretary (Establishment)',
                'phone' => '+94 (0) 112 368264',
                'fax' => '',
                'email' => 'as.est@labourmin.gov.lk'
            ],
            [
                'name' => 'Ms. W P A G Wijesooriya',
                'designation' => 'Legal Officer',
                'phone' => '+94 (0)112 582046',
                'fax' => '',
                'email' => 'labourminlegal@gmail.com'
            ]
        ]
    ],
    [
        'id' => 'development-modal',
        'title' => 'Development Division',
        'people' => [
            [
                'name' => 'Mr. Lal Samarasekara',
                'designation' => 'Additional Secretary (Development)',
                'phone' => '+94 (0)112 586337',
                'fax' => '+94 (0)112 589267',
                'email' => 'adsec.dev@labourmin.gov.lk'
            ],
            [
                'name' => 'Mr. P D Chandana Pathirage',
                'designation' => 'Director (Development)',
                'phone' => '+94 (0)11 2502807',
                'fax' => '',
                'email' => 'dir.dev@labourmin.gov.lk'
            ]
        ]
    ],
    [
        'id' => 'planning-modal',
        'title' => 'Planning Division',
        'people' => [
            [
                'name' => 'Ms.I V N Preethika Kumuduni',
                'designation' => 'Director General (Planning)',
                'phone' => '+94 (0)112 368594',
                'fax' => '',
                'email' => ''
            ],
            [
                'name' => 'Ms.M.P.D.C.W.Kumari',
                'designation' => 'Deputy Director (Planning)',
                'phone' => '+94 (0) 1125 82171',
                'fax' => '',
                'email' => ''
            ]
        ]
    ],
    [
        'id' => 'finance-modal',
        'title' => 'Finance Division',
        'people' => [
            [
                'name' => 'Mrs. G.C.N. Fonseka',
                'designation' => 'Chief Finance Officer',
                'phone' => '+94 (0)112 505161',
                'fax' => '',
                'email' => ''
            ],
            [
                'name' => 'Ms.S S Shiroma Nandani',
                'designation' => 'Chief Accountant',
                'phone' => '+94 (0)112 368204',
                'fax' => '+94 (0)112 368204',
                'email' => 'ca@labourmin.gov.lk'
            ]
        ]
    ],
    [
        'id' => 'audit-modal',
        'title' => 'Internal Audit',
        'people' => [
            [
                'name' => 'Mrs. A.M.M.K. Abeysinghe',
                'designation' => 'Chief Internal Auditor',
                'phone' => '+94 (0)112 369422',
                'fax' => '',
                'email' => 'cia@labourmin.gov.lk'
            ]
        ]
    ],
    [
        'id' => 'foreign-relations-modal',
        'title' => 'Foreign Relations Division',
        'people' => [
            [
                'name' => 'Mr. B Vasanthan',
                'designation' => 'Senior Assistant Secretary (Foreign Relations)',
                'phone' => '+94 (0)112 368609',
                'fax' => '+94 (0)112 368609',
                'email' => 'sas.fr@labourmin.gov.lk'
            ],
            [
                'name' => 'Mrs. M.N.H.Peiris',
                'designation' => 'Assistant Secretary (FR)',
                'phone' => '+94 (0)112 504478',
                'fax' => '',
                'email' => 'as.fr@labourmin.gov.lk'
            ]
        ]
    ]
];

$page_title = 'Contact Us';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Get In Touch Title -->
        <div class="text-center mb-12">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter">Get In Touch</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Stay updated with Ministry of Labour</h2>
        </div>

        <!-- Info Boxes -->
        <div class="flex flex-col lg:flex-row rounded-2xl overflow-hidden border border-gray-200 mb-16 md:mb-20 shadow-sm">
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
        <div class="bg-[#F9F9F9] rounded-[24px] p-6 sm:p-8 md:p-12 flex flex-col lg:flex-row gap-10 lg:gap-16 mb-16 md:mb-20 border border-gray-200">
            
            <!-- Form -->
            <div class="flex-1">
                <h3 class="text-[22px] md:text-[26px] font-semibold font-montserrat text-gray-900 mb-6 md:mb-8">Leave Us A Message</h3>
                
                <form class="space-y-4 md:space-y-5">
                    <div>
                        <label for="fullname" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Full Name</label>
                        <input type="text" id="fullname" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                        <div>
                            <label for="email" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Email Address</label>
                            <input type="email" id="email" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Phone Number</label>
                            <input type="tel" id="phone" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="">
                        </div>
                    </div>

                    <div>
                        <label for="department" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Department</label>
                        <input type="text" id="department" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors" placeholder="">
                    </div>

                    <div>
                        <label for="message" class="block text-xs md:text-[13px] font-medium text-gray-500 font-inter mb-1.5 md:mb-2">Message</label>
                        <textarea id="message" rows="4" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5 md:p-3 outline-none transition-colors resize-none md:rows-5" placeholder=""></textarea>
                    </div>

                    <div class="pt-2 md:pt-4 text-center md:text-left">
                        <button type="button" class="w-full md:w-auto bg-secondary text-white font-medium rounded-lg text-[13px] px-8 py-3 hover:bg-secondary/90 transition-colors font-inter inline-flex justify-center items-center gap-2">
                            Send Message
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
        <h3 class="text-xl md:text-[22px] font-semibold font-montserrat text-gray-900 mb-5 md:mb-6">Contact Numbers</h3>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200 border border-gray-200 rounded-2xl overflow-hidden font-inter">
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
<div id="<?php echo $dept['id']; ?>" class="fixed inset-0 z-[110] hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('<?php echo $dept['id']; ?>')"></div>
    
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[600px] max-h-[90vh] overflow-y-auto bg-secondary rounded-2xl shadow-2xl p-6 sm:p-8 md:p-12 text-center text-white custom-scrollbar">
        <button onclick="closeModal('<?php echo $dept['id']; ?>')" class="absolute top-4 right-4 md:top-6 md:right-6 text-white hover:text-gray-300 transition-colors z-10 bg-secondary rounded-full p-1">
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
