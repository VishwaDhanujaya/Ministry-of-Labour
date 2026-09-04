    </main>

    <?php if (basename($_SERVER['PHP_SELF'], '.php') === 'ampara-circuit-bungalow'): ?>
    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 bg-transparent">
        <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out border border-gray-100" id="booking-modal-card">
            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-[#FAFAFA]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold font-montserrat text-gray-900 notranslate"><?= t('reservation_details', 'Reservation Details') ?></h3>
                        <p class="text-[11px] text-gray-500 font-inter notranslate"><?= t('booking_request_subtitle', 'Request booking for Ampara Bungalow') ?></p>
                    </div>
                </div>
                <button type="button"
                    onclick="closeBookingModal()"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-700 flex items-center justify-center transition-colors focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="booking-form" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                    <div class="p-3.5 bg-amber-50/60 border border-amber-200/50 rounded-xl flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-[11.5px] text-amber-800 font-inter leading-relaxed">
                            <?= t('booking_modal_instructions', 'Please fill in your details to submit a reservation request. Grey dates in the calendar are already booked.') ?>
                        </p>
                    </div>

                    <!-- Date Range Selection Card -->
                    <div class="bg-gray-50/60 p-4 border border-gray-150 rounded-[16px] space-y-3.5">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Check-in -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('check_in', 'Check-In') ?> *</label>
                                <div class="relative">
                                    <input type="text" id="modal-check-in" name="start_date" required
                                        class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                        placeholder="YYYY-MM-DD">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Check-out -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('check_out', 'Check-Out') ?> *</label>
                                <div class="relative">
                                    <input type="text" id="modal-check-out" name="end_date" required
                                        class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                        placeholder="YYYY-MM-DD">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Required -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('room_required', 'Room Required') ?> *</label>
                        <div id="room_type_container"
                            class="space-y-2.5 p-4 border border-gray-200 rounded-[16px] bg-gray-50/50 min-h-[42px] transition-all">
                            <p class="text-[13px] text-gray-400 font-inter m-0 flex items-center justify-center py-2 gap-2">
                                <svg class="w-4 h-4 text-gray-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?= t('booking_select_dates_first', 'Please select dates first to see availability') ?>
                            </p>
                        </div>
                        <p id="room-availability-msg" class="text-[11px] text-red-600 mt-1.5 hidden font-inter font-medium items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Personal Info Fields -->
                    <div class="space-y-4">
                        <!-- Applicant Name -->
                        <div class="relative">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('applicant_name', 'Applicant Name') ?> *</label>
                            <div class="relative">
                                <input type="text" name="applicant_name" required
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                    placeholder="<?= t('ph_applicant_name', 'Enter applicant name') ?>">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Telephone -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('phone', 'Telephone') ?> *</label>
                                <div class="relative">
                                    <input type="text" name="telephone" required
                                        class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                        placeholder="07XXXXXXXX">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter notranslate"><?= t('email', 'Email') ?> *</label>
                                <div class="relative">
                                    <input type="email" name="email" required
                                        class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                        placeholder="example@mail.com">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-5 bg-[#FAFAFA] border-t border-gray-100 flex justify-end gap-3">
                    <button type="button"
                        onclick="closeBookingModal()"
                        class="px-5 py-2.5 text-[13px] font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 active:scale-95 transition-all font-inter focus:outline-none notranslate"><?= t('cancel', 'Cancel') ?></button>
                    <button type="submit" id="submit-booking-btn"
                        class="px-6 py-2.5 text-[13px] font-bold text-white bg-secondary hover:bg-[#3d0000] rounded-xl active:scale-95 transition-all font-inter shadow-md shadow-red-950/10 focus:outline-none notranslate"><?= t('submit_booking_request', 'Submit Booking Request') ?></button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Back to Top Floating Circular Progress Button -->

    <button id="back-to-top" aria-label="Back to top" onclick="scrollToTop()" class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-primary/90 text-white shadow-xl hover:bg-secondary transition-all duration-300 opacity-0 pointer-events-none flex items-center justify-center group focus:outline-none">
        <svg class="w-12 h-12 absolute inset-0 transform -rotate-90 pointer-events-none" viewBox="0 0 36 36">
            <path class="text-white/10" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            <path id="scroll-progress-circle" class="text-yellow-400 transition-all duration-150" stroke-dasharray="100, 100" stroke-dashoffset="100" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
        </svg>
        <svg class="w-5 h-5 text-white group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
        </svg>
    </button>

    <footer class="bg-primary text-white pt-16 relative overflow-hidden">
        <!-- Top accent line -->
        <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-secondary via-white/10 to-secondary z-20"></div>

        <!-- Subtle Background mesh for premium grid texture -->
        <div class="absolute inset-0 bg-mesh-pattern opacity-5 pointer-events-none"></div>
        <div class="container mx-auto px-4 md:px-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-10 mb-16">
                <!-- Col 1 -->
                <div class="md:col-span-12 lg:col-span-4 lg:pr-8 notranslate">
                    <div class="flex items-center mb-6">
                        <?php
                        $logo_path = dirname(__DIR__) . '/assets/img/logo.png';
                        $logo_version = file_exists($logo_path) ? filemtime($logo_path) : time();
                        ?>
                        <img loading="lazy" src="assets/img/logo.png?v=<?= $logo_version ?>" alt="Ministry of Labour - Government of Sri Lanka" class="h-14 w-auto object-contain">
                    </div>
                    <p class="text-gray-300 text-sm font-inter leading-relaxed mb-6">
                        <?= t('footer_motto') ?>
                    </p>
                    <div class="mb-4">
                        <form id="newsletter-form" class="flex" data-subscribed-msg="<?= htmlspecialchars(t('subscribed_success', 'Successfully subscribed!')) ?>">
                            <input type="email" required placeholder="<?= htmlspecialchars(t('email_placeholder')) ?>" class="bg-[#1B2E42] text-white placeholder-gray-400 px-3 sm:px-4 py-2.5 rounded-l-lg w-full min-w-0 focus:outline-none focus:bg-white/10 border border-white/10 border-r-0 text-xs sm:text-sm font-inter transition-all duration-300">
                            <button type="submit" class="bg-[#E5E0DB] text-secondary font-bold px-3 sm:px-5 py-2.5 rounded-r-lg hover:bg-white transition-colors text-xs sm:text-sm font-inter shrink-0 active:scale-[0.98]"><?= t('subscribe_btn') ?></button>
                        </form>
                        <p class="text-gray-400 text-[11px] sm:text-xs font-inter leading-relaxed mt-2.5 opacity-85">
                            <?= t('subscribe_title') ?>
                        </p>
                    </div>
                </div>
                
                <!-- Col 2: Quick Links -->
                <div class="md:col-span-6 lg:col-span-4 lg:pl-12 notranslate">
                    <div>
                        <h3 class="font-semibold text-[17px] mb-6 font-montserrat text-white tracking-wide border-b border-white/10 pb-2 flex items-center justify-between"><?= t('quick_links') ?></h3>
                        <ul class="space-y-3.5 text-[14px] text-gray-300 font-inter leading-relaxed">
                            <li><a href="<?= navUrl('nlac') ?>" class="hover:text-yellow-400 hover:underline transition-all">NLAC</a></li>
                            <li><a href="<?= navUrl('ampara-circuit-bungalow') ?>" class="hover:text-yellow-400 hover:underline transition-all"><?= t('ql_ampara') ?></a></li>
                            <li><a href="<?= navUrl('learning-platforms') ?>" class="hover:text-yellow-400 hover:underline transition-all"><?= t('learning_platforms') ?></a></li>
                            <li><a href="<?= navUrl('news') ?>" class="hover:text-yellow-400 hover:underline transition-all"><?= t('ql_news_updates') ?></a></li>
                            <li><a href="<?= navUrl('rti') ?>" class="hover:text-yellow-400 hover:underline transition-all"><?= t('rti') ?></a></li>
                            <li><a href="<?= navUrl('complaints') ?>" class="hover:text-yellow-400 hover:underline transition-all"><?= t('ql_complaints') ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Col 3: Contact -->
                <div class="md:col-span-6 lg:col-span-4 lg:pl-12 notranslate">
                    <div>
                        <h3 class="font-semibold text-[17px] mb-6 font-montserrat text-white tracking-wide border-b border-white/10 pb-2 flex items-center justify-between"><?= t('contact_heading') ?></h3>
                        <div class="space-y-4 text-[14px] text-gray-300 font-inter leading-relaxed">
                            <div>
                                <p><?= t('ministry_address') ?></p>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=Ministry+of+Labour,+Mehewara+Piyasa,+Narahenpita,+Colombo" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 mt-3 px-3.5 py-1.5 bg-white/10 hover:bg-white text-white hover:text-primary rounded-lg text-xs font-semibold font-inter transition-all duration-300 border border-white/15 hover:border-white shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"/></svg>
                                    <?= t('get_directions') ?>
                                </a>
                            </div>
                            <p class="notranslate">(+94) 11 2581991</p>
                            <p class="notranslate">(+94) 11 2368165</p>
                            <p class="notranslate" translate="no"><a href="mailto:info@labourmin.gov.lk" class="hover:underline hover:text-white transition-colors notranslate" translate="no">info@labourmin.gov.lk</a></p>
                        </div>
                        <div class="flex space-x-2 mt-6">
                            <a href="https://www.facebook.com/labourmin" aria-label="Facebook Social" target="_blank" class="w-8 h-8 rounded border border-white/10 flex items-center justify-center bg-white/5 hover:bg-[#1877F2] transition-all group"><svg class="w-4 h-4 fill-white transition-colors" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
                            <a href="https://web.whatsapp.com/send?phone=94777123456&amp;text=" aria-label="WhatsApp Social" target="_blank" class="w-8 h-8 rounded border border-white/10 flex items-center justify-center bg-white/5 hover:bg-[#25D366] transition-all group"><svg class="w-4 h-4 fill-white transition-colors" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                            <a href="https://youtube.com/@ministryoflabourandforeign191?si=9CZRGi72hNk2wGIz" aria-label="YouTube Social" target="_blank" class="w-8 h-8 rounded border border-white/10 flex items-center justify-center bg-white/5 hover:bg-[#FF0000] transition-all group"><svg class="w-4 h-4 fill-white transition-colors" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                        </div>
                        <div class="mt-6">
                            <img loading="lazy" src="assets/img/1919.png" alt="GIC Sri Lanka 1919" class="h-10 w-auto object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-[#090F16] text-gray-400 py-6 border-t border-white/5 font-inter text-[13px] relative z-10 notranslate">
            <div class="container mx-auto px-4 md:px-16 flex flex-col md:flex-row justify-between items-center gap-4">
                <p>&copy; 2026 SLT Digital. <?= t('rights_reserved') ?></p>
                <p><?= t('last_updated') ?>: <?php
                    $last_updated_date = '18 Mar, 2026';
                    if (!isset($pdo)) {
                        $db_path = __DIR__ . '/../admin/includes/db.php';
                        if (file_exists($db_path)) {
                            try {
                                require_once $db_path;
                            } catch (Exception $e) {
                                // ignore
                            }
                        }
                    }
                    if (isset($pdo)) {
                        try {
                            $queries = [
                                "SELECT MAX(created_at) FROM news WHERE status = 'Published' AND visibility = 'public'",
                                "SELECT MAX(created_at) FROM special_notices WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM learning_platforms_local WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM learning_platforms_foreign WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM vacancies WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM procurements WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM acts_amendments WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM iau_downloads WHERE status = 'Published'"
                            ];
                            $dates = [];
                            foreach ($queries as $q) {
                                $stmt = $pdo->query($q);
                                $d = $stmt->fetchColumn();
                                if ($d) {
                                    $dates[] = strtotime($d);
                                }
                            }
                            if (!empty($dates)) {
                                $last_updated_date = format_date_trilingual(max($dates));
                            }
                        } catch (PDOException $e) {
                            // ignore
                        }
                    }
                    echo $last_updated_date;
                ?></p>
            </div>
        </div>
    </footer>

    <!-- Floating Accessibility Menu Widget (Fixed Top Left) -->
    <div class="relative notranslate" id="accessibility-menu-container">
        <!-- Floating Action Button (Positioned at a comfortable static height below the navbar) -->
        <button id="accessibility-menu-btn" 
            type="button" 
            aria-expanded="false" 
            aria-haspopup="true" 
            aria-label="<?= htmlspecialchars($lang_dict['accessibility'][$current_lang] ?? 'Accessibility') ?>"
            title="<?= htmlspecialchars($lang_dict['accessibility'][$current_lang] ?? 'Accessibility') ?>"
            class="fixed top-36 sm:top-40 left-4 sm:left-6 w-11 h-11 bg-primary hover:bg-[#1B2E42] text-white rounded-full flex items-center justify-center border-2 border-white shadow-[0_10px_25px_rgba(0,0,0,0.35)] ring-1 ring-black/15 hover:scale-110 hover:shadow-[0_15px_35px_rgba(0,0,0,0.45)] transition-all duration-200 z-50 focus:outline-none cursor-pointer group active:scale-95">
            <!-- Man in Wheelchair Universal Accessibility Icon -->
            <svg class="w-5 h-5 text-yellow-400 group-hover:scale-110 transition-transform shrink-0 drop-shadow-xs" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="4" r="2"/>
                <path d="M19 13v-2c-1.54.02-3.09-.75-4.07-1.83l-1.29-1.43c-.17-.19-.38-.34-.61-.45-.01 0-.01-.01-.02-.01H13c-.35-.2-.75-.3-1.19-.26C10.76 7.11 10 8.04 10 9.1V15c0 1.1.9 2 2 2h5v5h2v-5.5c0-1.1-.9-2-2-2h-3v-3.45c1.29 1.07 3.25 1.95 5 1.95z"/>
                <path d="M10 18c-2.21 0-4-1.79-4-4 0-1.53.86-2.86 2.12-3.53l.71-1.89C6.83 9.4 5 11.49 5 14c0 3.31 2.69 6 6 6 1.48 0 2.84-.54 3.89-1.44l-1.44-1.44C12.63 17.67 11.39 18 10 18z"/>
            </svg>
        </button>

        <!-- Accessibility Dropdown Panel (Opens downward from top-left) -->
        <div id="accessibility-dropdown" class="fixed top-48 sm:top-52 left-4 sm:left-6 w-[calc(100vw-2rem)] sm:w-84 md:w-88 max-w-sm bg-white rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.45)] border-2 border-gray-200 p-4 sm:p-5 z-[99999] transform opacity-0 -translate-y-2 pointer-events-none transition-all duration-200 ease-out origin-top-left text-gray-800 max-h-[75vh] overflow-y-auto overscroll-contain">
            <!-- Dropdown Header -->
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-xl bg-primary text-white flex items-center justify-center shadow-xs">
                        <svg class="w-4.5 h-4.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="4" r="2"/>
                            <path d="M19 13v-2c-1.54.02-3.09-.75-4.07-1.83l-1.29-1.43c-.17-.19-.38-.34-.61-.45-.01 0-.01-.01-.02-.01H13c-.35-.2-.75-.3-1.19-.26C10.76 7.11 10 8.04 10 9.1V15c0 1.1.9 2 2 2h5v5h2v-5.5c0-1.1-.9-2-2-2h-3v-3.45c1.29 1.07 3.25 1.95 5 1.95z"/>
                            <path d="M10 18c-2.21 0-4-1.79-4-4 0-1.53.86-2.86 2.12-3.53l.71-1.89C6.83 9.4 5 11.49 5 14c0 3.31 2.69 6 6 6 1.48 0 2.84-.54 3.89-1.44l-1.44-1.44C12.63 17.67 11.39 18 10 18z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block font-bold text-xs font-montserrat text-primary uppercase tracking-wider leading-tight"><?= htmlspecialchars($lang_dict['accessibility'][$current_lang] ?? 'Accessibility') ?></span>
                        <span class="block text-[10px] text-gray-500 font-inter font-medium"><?= htmlspecialchars($lang_dict['personalize_view'][$current_lang] ?? 'Personalize View') ?></span>
                    </div>
                </div>
                <div class="flex items-center space-x-1.5">
                    <button type="button" id="a11y-reset-btn" class="group/rst text-[10.5px] text-gray-500 hover:text-secondary font-semibold uppercase tracking-wider transition-colors flex items-center space-x-1 px-2 py-1 rounded-lg hover:bg-gray-100 cursor-pointer" title="<?= htmlspecialchars($lang_dict['reset_accessibility'][$current_lang] ?? 'Reset') ?>">
                        <svg class="w-3.5 h-3.5 group-hover/rst:-rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span><?= htmlspecialchars($lang_dict['reset_accessibility'][$current_lang] ?? 'Reset') ?></span>
                    </button>
                    <button type="button" id="a11y-close-btn" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer" aria-label="Close Accessibility Menu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Section 1: Font Size -->
            <div class="mb-3.5">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[11px] font-bold text-gray-600 uppercase tracking-wider font-inter flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
                        <?= htmlspecialchars($lang_dict['text_size'][$current_lang] ?? 'Text Size') ?>
                    </span>
                </div>
                <div class="grid grid-cols-4 gap-1.5 bg-gray-100 p-1 rounded-xl border border-gray-200">
                    <button type="button" data-a11y-size="sm" class="a11y-size-btn py-1.5 text-xs font-semibold rounded-lg text-gray-700 hover:text-primary hover:bg-white transition-all text-center cursor-pointer">A-</button>
                    <button type="button" data-a11y-size="md" class="a11y-size-btn py-1.5 text-xs font-semibold rounded-lg text-gray-700 hover:text-primary hover:bg-white transition-all text-center cursor-pointer">A</button>
                    <button type="button" data-a11y-size="lg" class="a11y-size-btn py-1.5 text-sm font-semibold rounded-lg text-gray-700 hover:text-primary hover:bg-white transition-all text-center cursor-pointer">A+</button>
                    <button type="button" data-a11y-size="xl" class="a11y-size-btn py-1.5 text-base font-bold rounded-lg text-gray-700 hover:text-primary hover:bg-white transition-all text-center cursor-pointer">A++</button>
                </div>
            </div>

            <!-- Section 2: Color Mode -->
            <div class="mb-3.5">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[11px] font-bold text-gray-600 uppercase tracking-wider font-inter flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 5 5 0 013-4.5 4 4 0 014-4 4 4 0 014 4 5 5 0 013 4.5 4 4 0 01-4 4H7z"></path></svg>
                        <?= htmlspecialchars($lang_dict['color_mode'][$current_lang] ?? 'Color Mode') ?>
                    </span>
                </div>
                <div class="space-y-1">
                    <button type="button" data-a11y-color="normal" class="a11y-color-btn w-full flex items-center justify-between px-3 py-2 text-xs font-medium rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-gray-50 text-gray-700 bg-white transition-all cursor-pointer group shadow-xs">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-tr from-blue-500 via-emerald-500 to-rose-500 border border-black/10 shrink-0 shadow-xs"></span>
                            <span class="group-hover:text-primary transition-colors"><?= htmlspecialchars($lang_dict['normal_colors'][$current_lang] ?? 'Normal Colors') ?></span>
                        </span>
                        <span class="a11y-color-check w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                        </span>
                    </button>
                    <button type="button" data-a11y-color="grayscale" class="a11y-color-btn w-full flex items-center justify-between px-3 py-2 text-xs font-medium rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-gray-50 text-gray-700 bg-white transition-all cursor-pointer group shadow-xs">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-gray-500 border border-black/10 shrink-0 shadow-xs"></span>
                            <span class="group-hover:text-primary transition-colors"><?= htmlspecialchars($lang_dict['grayscale'][$current_lang] ?? 'Grayscale') ?></span>
                        </span>
                        <span class="a11y-color-check w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                        </span>
                    </button>
                    <button type="button" data-a11y-color="protanopia" class="a11y-color-btn w-full flex items-center justify-between px-3 py-2 text-xs font-medium rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-gray-50 text-gray-700 bg-white transition-all cursor-pointer group shadow-xs">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-amber-600 border border-black/10 shrink-0 shadow-xs"></span>
                            <span class="group-hover:text-primary transition-colors"><?= htmlspecialchars($lang_dict['protanopia'][$current_lang] ?? 'Protanopia (Red-blind)') ?></span>
                        </span>
                        <span class="a11y-color-check w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                        </span>
                    </button>
                    <button type="button" data-a11y-color="deuteranopia" class="a11y-color-btn w-full flex items-center justify-between px-3 py-2 text-xs font-medium rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-gray-50 text-gray-700 bg-white transition-all cursor-pointer group shadow-xs">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-teal-600 border border-black/10 shrink-0 shadow-xs"></span>
                            <span class="group-hover:text-primary transition-colors"><?= htmlspecialchars($lang_dict['deuteranopia'][$current_lang] ?? 'Deuteranopia (Green-blind)') ?></span>
                        </span>
                        <span class="a11y-color-check w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                        </span>
                    </button>
                    <button type="button" data-a11y-color="tritanopia" class="a11y-color-btn w-full flex items-center justify-between px-3 py-2 text-xs font-medium rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-gray-50 text-gray-700 bg-white transition-all cursor-pointer group shadow-xs">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-rose-600 border border-black/10 shrink-0 shadow-xs"></span>
                            <span class="group-hover:text-primary transition-colors"><?= htmlspecialchars($lang_dict['tritanopia'][$current_lang] ?? 'Tritanopia (Blue-blind)') ?></span>
                        </span>
                        <span class="a11y-color-check w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Section 3: Text-to-Speech (Granular Controls) -->
            <div class="mb-3.5 pt-3 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold text-gray-600 uppercase tracking-wider font-inter flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                        <?= htmlspecialchars($lang_dict['text_to_speech'][$current_lang] ?? 'Text-to-Speech') ?>
                    </span>
                    <!-- Live Speaking Indicator -->
                    <span id="a11y-tts-live-wave" class="hidden items-center space-x-0.5 px-2 py-0.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-bold">
                        <span class="w-0.5 h-2.5 bg-primary animate-bounce"></span>
                        <span class="w-0.5 h-3.5 bg-primary animate-bounce" style="animation-delay: 0.15s"></span>
                        <span class="w-0.5 h-2 bg-primary animate-bounce" style="animation-delay: 0.3s"></span>
                        <span class="ml-1"><?= htmlspecialchars($lang_dict['reading_aloud'][$current_lang] ?? 'Reading...') ?></span>
                    </span>
                </div>

                <!-- TTS Container Card (Solid non-transparent) -->
                <div class="bg-gray-50 rounded-xl p-2.5 border border-gray-200 space-y-2">
                    <!-- Master Toggle: Enable Text-to-Speech -->
                    <button type="button" id="a11y-tts-master-btn" class="w-full flex items-center justify-between py-1.5 px-2 rounded-lg bg-white border border-gray-200/80 hover:border-primary/40 transition-all cursor-pointer text-left shadow-xs">
                        <span class="text-xs font-semibold text-gray-700"><?= htmlspecialchars($lang_dict['enable_tts'][$current_lang] ?? 'Enable Text-to-Speech') ?></span>
                        <span id="a11y-tts-master-switch" class="w-8 h-4.5 bg-gray-300 rounded-full p-0.5 transition-colors duration-200 ease-in-out flex items-center">
                            <span class="w-3.5 h-3.5 bg-white rounded-full shadow-md transform transition-transform duration-200 ease-in-out translate-x-0"></span>
                        </span>
                    </button>

                    <!-- TTS Sub-Options (Expanded ONLY when Master Toggle is Enabled) -->
                    <div id="a11y-tts-options" class="hidden space-y-2 pt-2 border-t border-gray-200 transition-all duration-300">
                        <!-- Primary Actions: Read Page & Stop -->
                        <div class="grid grid-cols-2 gap-1.5">
                            <button type="button" id="a11y-tts-read-page-btn" class="flex items-center justify-center space-x-1.5 py-1.5 px-2.5 rounded-lg bg-primary text-white hover:bg-primary/90 active:scale-95 transition-all text-xs font-semibold shadow-xs cursor-pointer">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span><?= htmlspecialchars($lang_dict['read_page'][$current_lang] ?? 'Read Page') ?></span>
                            </button>
                            <button type="button" id="a11y-tts-stop-btn" class="flex items-center justify-center space-x-1.5 py-1.5 px-2.5 rounded-lg bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 active:scale-95 transition-all text-xs font-semibold shadow-xs cursor-pointer">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
                                <span><?= htmlspecialchars($lang_dict['stop'][$current_lang] ?? 'Stop') ?></span>
                            </button>
                        </div>

                        <!-- Granular Feature Options (Hover & Selection) -->
                        <div class="space-y-1 pt-1 border-t border-gray-200/70">
                            <button type="button" id="a11y-tts-hover-btn" class="w-full flex items-center justify-between py-1.5 px-2 rounded-lg bg-white border border-gray-200/80 hover:border-primary/40 transition-colors cursor-pointer text-left group shadow-xs">
                                <span class="text-[11.5px] font-medium text-gray-700 group-hover:text-primary transition-colors flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                    <?= htmlspecialchars($lang_dict['read_on_hover'][$current_lang] ?? 'Read on Hover') ?>
                                </span>
                                <span id="a11y-tts-hover-switch" class="w-7 h-4 bg-gray-300 rounded-full p-0.5 transition-colors duration-200 ease-in-out flex items-center">
                                    <span class="w-3 h-3 bg-white rounded-full shadow-xs transform transition-transform duration-200 ease-in-out translate-x-0"></span>
                                </span>
                            </button>

                            <button type="button" id="a11y-tts-selection-btn" class="w-full flex items-center justify-between py-1.5 px-2 rounded-lg bg-white border border-gray-200/80 hover:border-primary/40 transition-colors cursor-pointer text-left group shadow-xs">
                                <span class="text-[11.5px] font-medium text-gray-700 group-hover:text-primary transition-colors flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <?= htmlspecialchars($lang_dict['read_on_selection'][$current_lang] ?? 'Read on Selection') ?>
                                </span>
                                <span id="a11y-tts-selection-switch" class="w-7 h-4 bg-gray-300 rounded-full p-0.5 transition-colors duration-200 ease-in-out flex items-center">
                                    <span class="w-3 h-3 bg-white rounded-full shadow-xs transform transition-transform duration-200 ease-in-out translate-x-0"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Visual Aids (Toggles) -->
            <div class="pt-2 border-t border-gray-100">
                <button type="button" id="a11y-toggle-links" class="w-full flex items-center justify-between p-2 rounded-xl bg-gray-50 hover:bg-primary/[0.04] hover:border-primary/40 border border-gray-200 text-left transition-all cursor-pointer group shadow-xs">
                    <span class="flex items-center space-x-2 text-xs font-semibold text-gray-700 group-hover:text-primary">
                        <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <span><?= htmlspecialchars($lang_dict['highlight_links'][$current_lang] ?? 'Highlight Links') ?></span>
                    </span>
                    <span id="a11y-links-indicator" class="w-4 h-4 rounded-full border border-gray-300 bg-white flex items-center justify-center transition-colors">
                        <span class="w-2 h-2 rounded-full bg-primary opacity-0 transition-opacity"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" aria-label="Back to Top" class="fixed bottom-6 right-6 w-11 h-11 bg-secondary text-white rounded-full flex items-center justify-center shadow-xl opacity-0 pointer-events-none transition-all duration-300 transform translate-y-3 hover:-translate-y-0.5 hover:bg-[#320000] z-50 focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
    </button>

    <!-- Detail Preview Modal -->
    <div id="detail-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0 bg-black/60 backdrop-blur-sm">
        <div class="absolute inset-0" onclick="closeDetailModal()"></div>
        <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-2xl p-0 transform scale-95 transition-all duration-300 relative z-10 max-h-[85vh] flex flex-col overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-[#FAFAFA] shrink-0">
                <div class="flex-1 min-w-0 pr-4">
                    <span id="modal-badge" class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold border whitespace-nowrap uppercase tracking-wider bg-secondary/5 text-secondary border-secondary/10 notranslate"><?= t('category', 'Category') ?></span>
                    <h3 id="modal-title" class="text-[17px] font-bold font-montserrat text-gray-900 mt-2 truncate notranslate"></h3>
                </div>
                <button onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-250 text-gray-500 hover:text-gray-700 flex items-center justify-center transition-colors focus:outline-none shrink-0 cursor-pointer">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Content Container -->
            <div class="overflow-y-auto p-6 md:p-8 flex-grow">
                <!-- Meta Date -->
                <div class="flex items-center gap-1.5 text-xs text-gray-400 font-inter font-medium tracking-wide mb-4 pb-4 border-b border-gray-100 select-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span id="modal-date" class="notranslate"><?= t('published_date', 'Published Date') ?></span>
                </div>
                <!-- Body Text -->
                <div id="modal-body" class="text-[14.5px] text-gray-600 leading-relaxed font-inter prose max-w-none notranslate"></div>

                <!-- Trilingual Download Language Selection -->
                <div id="modal-pdf-section" class="mt-8 pt-6 border-t border-gray-100 space-y-3 hidden">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 font-inter mb-2 notranslate"><?= t('select_pdf_version', 'Select Language PDF Version') ?></p>
                    
                    <!-- English PDF Button -->
                    <a id="modal-pdf-link-en" href="#" target="_blank" class="hidden items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">EN</span>
                            <div class="text-left">
                                <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors"><?= t('pdf_english', 'English PDF') ?></p>
                                <p class="text-[11px] text-gray-400"><?= t('pdf_english_desc', 'Official English Document') ?></p>
                            </div>
                        </div>
                        <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm">
                            <?= t('download', 'Download') ?>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </span>
                    </a>
                    
                    <!-- Sinhala PDF Button -->
                    <a id="modal-pdf-link-si" href="#" target="_blank" class="hidden items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs font-noto">සිං</span>
                            <div class="text-left">
                                <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors font-noto"><?= t('pdf_sinhala', 'සිංහල PDF (Sinhala)') ?></p>
                                <p class="text-[11px] text-gray-400 font-noto"><?= t('pdf_sinhala_desc', 'සිංහල මාධ්‍ය නිල ලේඛනය') ?></p>
                            </div>
                        </div>
                        <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm font-noto">
                            <?= t('download', 'බාගත කරන්න') ?>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </span>
                    </a>
                    
                    <!-- Tamil PDF Button -->
                    <a id="modal-pdf-link-ta" href="#" target="_blank" class="hidden items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs font-noto">த</span>
                            <div class="text-left">
                                <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors font-noto"><?= t('pdf_tamil', 'தமிழ் PDF (Tamil)') ?></p>
                                <p class="text-[11px] text-gray-400 font-noto"><?= t('pdf_tamil_desc', 'தமிழ் மொழி அதிகாரப்பூர்ව ஆவணம்') ?></p>
                            </div>
                        </div>
                        <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm font-noto">
                            <?= t('download', 'பதிவிறக்கம்') ?>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </span>
                    </a>
                </div>
            </div>
            
            <!-- Footer / Action bar -->
            <div id="modal-footer" class="px-6 py-5 border-t border-gray-100 bg-[#FAFAFA] flex justify-end gap-3 shrink-0 flex-wrap">
                <button onclick="closeDetailModal()" class="px-5 py-2.5 text-[13px] font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors focus:outline-none cursor-pointer"><?= t('close_btn', 'Close') ?></button>
            </div>
        </div>
    </div>

    <script>
    function openDetailModal(data) {
        const modal = document.getElementById('detail-modal');
        document.getElementById('modal-title').textContent = data.title;
        document.getElementById('modal-badge').textContent = data.category;
        document.getElementById('modal-date').textContent = '<?= t("published_prefix", "Published: ") ?>' + data.date;
        document.getElementById('modal-body').innerHTML = data.content || '<p class="text-gray-400 italic"><?= t("no_desc_provided", "No description provided.") ?></p>';
        
        const pdfLinkEn = document.getElementById('modal-pdf-link-en');
        const pdfLinkSi = document.getElementById('modal-pdf-link-si');
        const pdfLinkTa = document.getElementById('modal-pdf-link-ta');
        
        pdfLinkEn.classList.add('hidden');
        pdfLinkEn.classList.remove('flex');
        pdfLinkSi.classList.add('hidden');
        pdfLinkSi.classList.remove('flex');
        pdfLinkTa.classList.add('hidden');
        pdfLinkTa.classList.remove('flex');

        let hasPdf = false;
        if (data.pdf_path) {
            pdfLinkEn.href = data.pdf_path;
            pdfLinkEn.classList.remove('hidden');
            pdfLinkEn.classList.add('flex');
            hasPdf = true;
        }
        if (data.pdf_path_si) {
            pdfLinkSi.href = data.pdf_path_si;
            pdfLinkSi.classList.remove('hidden');
            pdfLinkSi.classList.add('flex');
            hasPdf = true;
        }
        if (data.pdf_path_ta) {
            pdfLinkTa.href = data.pdf_path_ta;
            pdfLinkTa.classList.remove('hidden');
            pdfLinkTa.classList.add('flex');
            hasPdf = true;
        }
        
        const pdfSection = document.getElementById('modal-pdf-section');
        if (hasPdf) {
            pdfSection.classList.remove('hidden');
        } else {
            pdfSection.classList.add('hidden');
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeDetailModal() {
        const modal = document.getElementById('detail-modal');
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
        document.body.classList.remove('overflow-hidden');
    }
    </script>

    <!-- Interactive JS assets -->
    <?php
    $js_path = dirname(__DIR__) . '/assets/js/main.js';
    $js_version = file_exists($js_path) ? filemtime($js_path) : time();
    ?>
    <script src="assets/js/main.js?v=<?= $js_version ?>"></script>
    <!-- Lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
    <!-- AOS JS for smooth scroll animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamically add data-aos to all sections to ensure animations are "everywhere"
            document.querySelectorAll('section').forEach(function(section) {
                if (!section.hasAttribute('data-aos') && !section.querySelector('[data-aos]')) {
                    section.setAttribute('data-aos', 'fade-up');
                }
            });
            
            // Stagger animations for cards
            document.querySelectorAll('.news-card, .service-card, .focus-card').forEach(function(card, index) {
                if (!card.hasAttribute('data-aos')) {
                    card.setAttribute('data-aos', 'fade-up');
                    card.setAttribute('data-aos-delay', (index % 4) * 100);
                }
            });

            AOS.init({
                duration: 500,
                once: true,
                offset: 20,
                easing: 'ease-out'
            });
        });
    </script>
</body>
</html>
