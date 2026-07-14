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
                        <h3 class="text-lg font-bold font-montserrat text-gray-900">Reservation Details</h3>
                        <p class="text-[11px] text-gray-500 font-inter">Request booking for Ampara Bungalow</p>
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
                            Please fill in your details to submit a reservation request. Grey dates in the calendar are already booked.
                        </p>
                    </div>

                    <!-- Date Range Selection Card -->
                    <div class="bg-gray-50/60 p-4 border border-gray-150 rounded-[16px] space-y-3.5">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Check-in -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Check-In *</label>
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
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Check-Out *</label>
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
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Room Required *</label>
                        <div id="room_type_container"
                            class="space-y-2.5 p-4 border border-gray-200 rounded-[16px] bg-gray-50/50 min-h-[42px] transition-all">
                            <p class="text-[13px] text-gray-400 font-inter m-0 flex items-center justify-center py-2 gap-2">
                                <svg class="w-4 h-4 text-gray-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Please select dates first to see availability
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
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Applicant Name *</label>
                            <div class="relative">
                                <input type="text" name="applicant_name" required
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary bg-white font-inter transition-all"
                                    placeholder="Enter applicant name">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Telephone -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Telephone *</label>
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
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-1.5 font-inter">Email *</label>
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
                        class="px-5 py-2.5 text-[13px] font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 active:scale-95 transition-all font-inter focus:outline-none">Cancel</button>
                    <button type="submit" id="submit-booking-btn"
                        class="px-6 py-2.5 text-[13px] font-bold text-white bg-secondary hover:bg-[#3d0000] rounded-xl active:scale-95 transition-all font-inter shadow-md shadow-red-950/10 focus:outline-none">Submit Booking Request</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <footer class="bg-primary text-white pt-16 relative overflow-hidden">
        <!-- Subtle Background mesh for premium grid texture -->
        <div class="absolute inset-0 bg-mesh-pattern opacity-5 pointer-events-none"></div>
        <div class="container mx-auto px-4 md:px-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-16">
                <!-- Col 1 -->
                <div class="lg:col-span-4 lg:pr-8">
                    <div class="flex items-center mb-6">
                        <?php
                        $logo_path = dirname(__DIR__) . '/assets/img/logo.png';
                        $logo_version = file_exists($logo_path) ? filemtime($logo_path) : time();
                        ?>
                        <img loading="lazy" src="assets/img/logo.png?v=<?= $logo_version ?>" alt="Ministry of Labour - Government of Sri Lanka" class="h-14 w-auto object-contain">
                    </div>
                    <p class="text-gray-300 text-sm font-inter leading-relaxed mb-6">
                        Committed to fostering productive labour relations, safeguarding workers' rights, and promoting decent work for all citizens of Sri Lanka.
                    </p>
                    <p class="text-gray-300 text-sm font-inter leading-relaxed mb-4">
                        Subscribe to receive the latest Ministry news, gazette notifications and policy updates.
                    </p>
                    <div class="mb-4">
                        <form id="newsletter-form" class="flex" onsubmit="event.preventDefault();">
                            <input type="email" required placeholder="Your Email Address" class="bg-[#1B2E42] text-white placeholder-gray-400 px-4 py-2.5 rounded-l-lg w-full focus:outline-none focus:bg-white/10 border border-white/10 border-r-0 text-sm font-inter transition-all duration-300">
                            <button type="submit" class="bg-[#E5E0DB] text-secondary font-bold px-5 py-2.5 rounded-r-lg hover:bg-white transition-colors text-sm font-inter shrink-0 active:scale-[0.98]">Subscribe</button>
                        </form>
                    </div>
                </div>
                
                <!-- Col 2: Quick Links -->
                <div class="hidden md:block lg:flex lg:col-span-3 lg:justify-center">
                    <div>
                        <h3 class="font-semibold text-[17px] mb-6 font-montserrat text-white tracking-wide">Quick Links</h3>
                        <ul class="space-y-3.5 text-[14px] text-gray-300 font-inter">
                            <li><a href="home" class="hover:text-yellow-400 hover:underline transition-all">Home</a></li>
                            <li><a href="about-us" class="hover:text-yellow-400 hover:underline transition-all">About Us</a></li>
                            <li><a href="news" class="hover:text-yellow-400 hover:underline transition-all">News</a></li>
                            <li><a href="special-notices" class="hover:text-yellow-400 hover:underline transition-all">Special Notices</a></li>
                            <li><a href="vacancies" class="hover:text-yellow-400 hover:underline transition-all">Vacancies</a></li>
                            <li><a href="procurements" class="hover:text-yellow-400 hover:underline transition-all">Procurements</a></li>
                            <li><a href="learning-platforms" class="hover:text-yellow-400 hover:underline transition-all">Learning Platforms</a></li>
                            <li><a href="iau" class="hover:text-yellow-400 hover:underline transition-all notranslate">IAU</a></li>
                            <li><a href="iau-updates" class="hover:text-yellow-400 hover:underline transition-all">IAU Updates</a></li>
                            <li><a href="rti" class="hover:text-yellow-400 hover:underline transition-all notranslate">RTI</a></li>
                            <li><a href="downloads" class="hover:text-yellow-400 hover:underline transition-all">Downloads</a></li>
                            <li><a href="nlac" class="hover:text-yellow-400 hover:underline transition-all notranslate">NLAC</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Col 3: Circuit Bungalows -->
                <div class="hidden md:block lg:flex lg:col-span-2 lg:justify-center">
                    <div>
                        <h3 class="font-semibold text-[17px] mb-6 font-montserrat text-white tracking-wide">Circuit Bungalows</h3>
                        <ul class="space-y-3.5 text-[14px] text-gray-300 font-inter">
                            <li>
                                <a href="ampara-circuit-bungalow" class="hover:text-yellow-400 hover:underline transition-all flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ampara Bungalow
                                </a>
                            </li>
                        </ul>
                        <div class="mt-5 p-3 bg-white/5 rounded-lg border border-white/10">
                            <p class="text-[12px] text-gray-400 font-inter leading-relaxed">Book Ministry circuit bungalows for official stays. Subject to admin approval.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Col 4: Contact -->
                <div class="hidden md:block lg:flex lg:col-span-3 lg:justify-end">
                    <div>
                        <h3 class="font-semibold text-[17px] mb-6 font-montserrat text-white tracking-wide">Contact</h3>
                        <div class="space-y-4 text-[14px] text-gray-300 font-inter leading-relaxed">
                            <p>6th floor,Mehewara Piyasa, Narahenpita,<br>Colombo 05, Sri Lanka.</p>
                            <p class="notranslate">(+94) 11 2581991</p>
                            <p class="notranslate">(+94) 11 2368165</p>
                            <p><a href="mailto:info@labourmin.gov.lk" class="hover:underline hover:text-white transition-colors">info@labourmin.gov.lk</a></p>
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
        <div class="bg-[#090F16] text-gray-400 py-6 border-t border-white/5 font-inter text-[13px] relative z-10">
            <div class="container mx-auto px-4 md:px-16 flex flex-col md:flex-row justify-between items-center gap-4">
                <p>&copy; 2026 SLT Digital. All rights reserved.</p>
                <p>Last Updated: <?php
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
                                "SELECT MAX(created_at) FROM news WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM special_notices WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM learning_platforms_local WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM learning_platforms_foreign WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM vacancies WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM procurements WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM acts_amendments WHERE status = 'Published'",
                                "SELECT MAX(created_at) FROM iau_updates WHERE status = 'Published'"
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
                                $last_updated_date = date('j M, Y', max($dates));
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
                    <span id="modal-badge" class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold border whitespace-nowrap uppercase tracking-wider bg-secondary/5 text-secondary border-secondary/10">Category</span>
                    <h3 id="modal-title" class="text-[17px] font-bold font-montserrat text-gray-900 mt-2 truncate"></h3>
                </div>
                <button onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-250 text-gray-500 hover:text-gray-700 flex items-center justify-center transition-colors focus:outline-none shrink-0 cursor-pointer">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Content Container -->
            <div class="overflow-y-auto p-6 md:p-8 flex-grow">
                <!-- Meta Date -->
                <div class="flex items-center gap-1.5 text-xs text-gray-400 font-inter font-medium tracking-wide mb-4 pb-4 border-b border-gray-100 select-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span id="modal-date">Published Date</span>
                </div>
                <!-- Body Text -->
                <div id="modal-body" class="text-[14.5px] text-gray-600 leading-relaxed font-inter prose max-w-none notranslate"></div>
            </div>

            <!-- Footer / Action bar -->
            <div id="modal-footer" class="px-6 py-5 border-t border-gray-100 bg-[#FAFAFA] flex justify-end gap-3 shrink-0">
                <button onclick="closeDetailModal()" class="px-5 py-2.5 text-[13px] font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors focus:outline-none cursor-pointer">Close</button>
                <a id="modal-pdf-link" href="#" target="_blank" class="px-5 py-2.5 text-[13px] font-bold text-white bg-secondary hover:bg-[#3d0000] rounded-xl transition-all shadow-md flex items-center gap-1.5 focus:outline-none cursor-pointer">
                    <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                    View PDF Document
                </a>
            </div>
        </div>
    </div>

    <script>
    function openDetailModal(data) {
        const modal = document.getElementById('detail-modal');
        document.getElementById('modal-title').textContent = data.title;
        document.getElementById('modal-badge').textContent = data.category;
        document.getElementById('modal-date').textContent = 'Published: ' + data.date;
        document.getElementById('modal-body').innerHTML = data.content || '<p class="text-gray-400 italic">No description provided.</p>';
        
        const pdfLink = document.getElementById('modal-pdf-link');
        if (data.pdf_path) {
            pdfLink.href = data.pdf_path;
            pdfLink.style.display = 'inline-flex';
        } else {
            pdfLink.style.display = 'none';
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
