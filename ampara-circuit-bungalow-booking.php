<?php
// ampara-circuit-bungalow-booking.php
require_once 'admin/includes/db.php';
include 'includes/header.php';

$page_title = t('ampara_booking_title', 'Ampara Circuit Bungalow Booking');
$is_success = isset($_GET['success']) && $_GET['success'] == '1';
$pageTitle = t('ampara_booking_title', 'Ampara Circuit Bungalow Booking') . ' - ' . t('ministry_of_labour', 'Ministry of Labour') . ' - Sri Lanka';
$metaDescription = t('ampara_booking_meta_desc', 'Book the Ampara Circuit Bungalow online. Fill in your reservation details, applicant information, and submit your request.');
$metaKeywords = t('ampara_booking_meta_kw', 'Ampara Circuit Bungalow, Booking, Accommodation, Ministry of Labour, Sri Lanka');

$breadcrumbs = [
    ['label' => t('circuit_bungalows', 'Circuit Bungalows'), 'url' => 'ampara-circuit-bungalow'],
    ['label' => t('ampara', 'Ampara'), 'url' => 'ampara-circuit-bungalow'],
    ['label' => t('book_now', 'Book Now')]
];

include 'includes/sub-hero.php';
?>

<section class="py-12 md:py-16 px-4 md:px-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden notranslate" translate="no">
            <?php if ($is_success): ?>
                <div class="text-center py-12 px-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-montserrat font-bold text-gray-900 mb-4 notranslate"><?= t('booking_submitted_title', 'Application Submitted!') ?></h3>
                    <p class="text-gray-600 max-w-md mx-auto mb-8 leading-relaxed notranslate">
                        <?= t('booking_submitted_desc', 'Your booking application has been received and is currently <strong>Pending Approval</strong>. Once the Ministry confirms your booking, you may proceed with the payment.') ?>
                    </p>
                    <a href="ampara-circuit-bungalow" class="inline-flex px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition shadow-md notranslate">
                        <?= t('return_to_details', 'Return to Details') ?>
                    </a>
                </div>
            <?php else: ?>
            <!-- Form Header & Stepper -->
            <div class="bg-primary px-8 py-6 text-white">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-montserrat text-white uppercase tracking-tight mb-6 notranslate"><?= t('ampara_form_title', 'Ampara Circuit Bungalow Reservation Form') ?></h2>
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-white/20 z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-white z-0 transition-all duration-500" id="progress-bar" style="width: 0%;"></div>
                    
                    <!-- Steps -->
                    <div class="step-indicator active relative z-10 flex flex-col items-center gap-2" data-step="1">
                        <div class="w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm shadow-md transition-colors">1</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium hidden sm:block notranslate"><?= t('booking_step_reservation', 'Reservation') ?></span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="2">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">2</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block notranslate"><?= t('booking_step_applicant', 'Applicant') ?></span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="3">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">3</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block notranslate"><?= t('booking_step_guests', 'Guests') ?></span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="4">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">4</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block notranslate"><?= t('booking_step_confirm', 'Confirm') ?></span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form id="bookingForm" action="process-ampara-booking" method="POST" class="p-8" enctype="multipart/form-data">
                <?php if (isset($_GET['error'])): ?>
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl mb-6 font-inter text-sm font-semibold flex items-center gap-2 notranslate">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>
                            <?php
                            $errCode = $_GET['error'];
                            if ($errCode === 'submission_failed') {
                                echo t('booking_err_failed', 'Booking submission failed. Please try again.');
                            } elseif (strpos($errCode, 'upload_failed:') === 0) {
                                echo htmlspecialchars(substr($errCode, 14));
                            } else {
                                echo t('booking_err_generic', 'An error occurred during booking. Please try again.');
                            }
                            ?>
                        </span>
                    </div>
                <?php endif; ?>
                
                <!-- Step 1: Reservation Details -->
                <div class="form-step active" id="step-1">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b notranslate"><?= t('step_1_title', '1. Reservation Details') ?></h3>
                    
                    <!-- Interactive Visual Calendar Widget -->
                    <div class="mb-6 p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 shadow-xs">
                        <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider font-montserrat flex items-center gap-1.5 select-none notranslate">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path></svg>
                                <span><?= t('cal_grid_title', 'Live Availability Calendar Grid') ?></span>
                            </h4>
                            <div class="flex items-center gap-3 text-[11px] font-semibold select-none notranslate">
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> <?= t('cal_status_available', 'Available') ?></span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> <?= t('cal_status_pending', 'Pending') ?></span>
                                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> <?= t('cal_status_booked', 'Booked') ?></span>
                            </div>
                        </div>
                        <div id="visual-calendar-grid" class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                            <div class="flex justify-between items-center mb-3">
                                <button type="button" onclick="changeCalendarMonth(-1)" class="px-2.5 py-1 hover:bg-slate-100 rounded-lg text-slate-600 font-bold text-xs transition-colors notranslate">&larr; <?= t('cal_btn_prev', 'Prev') ?></button>
                                <span id="calendar-month-label" class="text-xs font-bold text-slate-800 font-montserrat notranslate">...</span>
                                <button type="button" onclick="changeCalendarMonth(1)" class="px-2.5 py-1 hover:bg-slate-100 rounded-lg text-slate-600 font-bold text-xs transition-colors notranslate"><?= t('cal_btn_next', 'Next') ?> &rarr;</button>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-2 notranslate" id="calendar-weekdays-row">
                                <!-- Weekday headers inserted by JS -->
                            </div>
                            <div id="calendar-days-container" class="grid grid-cols-7 gap-1">
                                <!-- Rendered dynamically by JS -->
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('checkin_date', 'Check-in Date') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="start_date" id="start_date" placeholder="<?= htmlspecialchars(t('ph_select_checkin', 'Select check-in date')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer notranslate" required readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('checkout_date', 'Check-out Date') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="end_date" id="end_date" placeholder="<?= htmlspecialchars(t('ph_select_checkout', 'Select check-out date')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer notranslate" required readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('arrival_time', 'Expected Arrival Time') ?></label>
                            <input type="text" name="arrival_time" id="arrival_time" placeholder="<?= htmlspecialchars(t('ph_select_arrival_time', 'Select arrival time')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer notranslate" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('departure_time', 'Expected Departure Time') ?></label>
                            <input type="text" name="departure_time" id="departure_time" placeholder="<?= htmlspecialchars(t('ph_select_departure_time', 'Select departure time')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer notranslate" readonly>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3 notranslate"><?= t('applicant_category', 'Applicant Category') ?> <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="category-card cursor-pointer border rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative border-primary bg-blue-50/20 text-center">
                                    <input type="radio" name="applicant_category" value="Ministry of Labour Staff" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4" checked>
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-bold text-gray-900 block mt-1 notranslate"><?= t('cat_mol_staff', 'Ministry of Labour Staff') ?></span>
                                </label>
                                <label class="category-card cursor-pointer border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative text-center">
                                    <input type="radio" name="applicant_category" value="Other Government/Private Sector" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700 block mt-1 notranslate"><?= t('cat_other_govt_private', 'Other Govt / Private Sector') ?></span>
                                </label>
                                <label class="category-card cursor-pointer border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative text-center">
                                    <input type="radio" name="applicant_category" value="Foreign Visitors" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2.945M11 20.935V19a2 2 0 012-2h2.83M11 21a9 9 0 119-9m-9 0a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700 block mt-1 notranslate"><?= t('cat_foreign_visitors', 'Foreign Visitors') ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-900 notranslate"><?= t('room_selection_title', 'Room Selection') ?></h4>
                            <button type="button" id="btnCheckAvailability" class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition notranslate"><?= t('btn_check_availability', 'Check Availability') ?></button>
                        </div>
                        <div id="availability-message" class="text-sm mb-4 hidden notranslate"></div>
                        <div id="room-selection-container" class="space-y-3 hidden">
                            <!-- Rooms will be populated here via AJAX -->
                        </div>
                    </div>
                </div>

                <!-- Step 2: Applicant Details -->
                <div class="form-step hidden" id="step-2">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b notranslate"><?= t('step_2_title', '2. Applicant Details') ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('full_name', 'Full Name') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="applicant_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required>
                        </div>
                        <div id="designation_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('designation', 'Designation') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="designation" id="designation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required>
                        </div>
                        <div id="nic_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('nic_card', 'National Identity Card (NIC)') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="nic" id="nic" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required>
                        </div>
                        <div id="passport_container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('passport_number', 'Passport Number') ?> <span class="text-red-500">*</span></label>
                            <input type="text" name="passport_number" id="passport_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate">
                        </div>
                        <div id="retired_container">
                            <label class="block text-sm font-medium text-gray-700 mb-3 notranslate"><?= t('retired_question', 'Retired?') ?> <span class="text-red-500">*</span></label>
                            <div class="flex gap-4 notranslate">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_retired" value="Yes" class="text-primary focus:ring-primary w-4 h-4">
                                    <span class="ml-2 text-sm text-gray-700"><?= t('yes', 'Yes') ?></span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_retired" value="No" class="text-primary focus:ring-primary w-4 h-4" checked>
                                    <span class="ml-2 text-sm text-gray-700"><?= t('no', 'No') ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2" id="workplace_address_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('workplace_address_label', 'Ministry/Department/Organization & Address') ?> <span class="text-red-500">*</span></label>
                            <textarea name="workplace_address" id="workplace_address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('residential_address_label', 'Residential Address') ?> <span class="text-red-500">*</span></label>
                            <textarea name="residential_address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('mobile_number', 'Mobile Number') ?> <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone_mobile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('office_number', 'Office Number') ?></label>
                            <input type="tel" name="phone_office" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 notranslate"><?= t('email_address', 'Email Address') ?> <span class="text-red-500">*</span></label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none notranslate" required>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Other Guests -->
                <div class="form-step hidden" id="step-3">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-2 notranslate"><?= t('step_3_title', '3. Details of Other Guests') ?></h3>
                    <p class="text-sm text-gray-500 mb-6 pb-2 border-b notranslate"><?= t('guests_guidance', 'Do not include children under 12 years of age. (Maximum 16 guests).') ?> <span class="text-slate-400"><?= t('guests_travel_alone_note', 'If you are traveling alone, you can remove the default guest card below.') ?></span></p>
                    
                    <div id="guests-container" class="space-y-4 mb-4">
                        <!-- Guest rows will be added here -->
                    </div>
                    
                    <button type="button" id="btnAddGuest" class="px-4 py-2 border border-dashed border-primary text-primary font-medium rounded-lg hover:bg-blue-50 transition w-full flex items-center justify-center gap-2 notranslate">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span><?= t('btn_add_guest', 'Add Guest') ?></span>
                    </button>
                </div>

                <!-- Step 4: Confirm & Submit -->
                <div class="form-step hidden" id="step-4">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b notranslate"><?= t('step_4_title', '4. Confirmation & Declaration') ?></h3>
                    
                    <!-- Booking Summary Box -->
                    <div id="booking-summary-box" class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-8 notranslate">
                        <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-primary border-b border-gray-200 pb-2"><?= t('booking_summary_title', 'Booking Details Summary') ?></h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide"><?= t('summary_applicant_name', 'Applicant Name') ?></span>
                                <span id="summary-applicant-name" class="font-semibold text-gray-800 text-base">-</span>
                                <span id="summary-applicant-category" class="block text-xs text-gray-500 font-medium mt-0.5">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide"><?= t('summary_duration', 'Booking Duration') ?></span>
                                <span id="summary-duration" class="font-semibold text-gray-800 text-base">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide"><?= t('summary_rooms', 'Selected Rooms') ?></span>
                                <span id="summary-rooms" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide"><?= t('summary_total_cost', 'Total Estimated Cost') ?></span>
                                <span id="summary-cost" class="font-bold text-secondary text-lg">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-left mb-8 notranslate">
                        <h4 class="font-semibold text-blue-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span><?= t('payment_instructions_title', 'Payment Instructions') ?></span>
                        </h4>
                        <ol class="list-decimal pl-5 text-sm text-blue-800 space-y-3">
                            <li><?= t('payment_deposit_to', 'Deposit the required amount to:') ?><br>
                                <strong class="text-gray-900"><?= t('payment_bank_label', 'Bank:') ?></strong> <?= t('payment_bank_name', "People's Bank – Narahenpita Branch") ?><br>
                                <strong class="text-gray-900"><?= t('payment_acc_label', 'Account Number:') ?></strong> <span class="notranslate" translate="no">119-1-001-59025666</span>
                            </li>
                            <li><?= sprintf(t('payment_receipt_instruction', 'Send the payment receipt via Email to %s or via WhatsApp.'), '<a href="mailto:admin@labourmin.gov.lk" class="font-medium underline notranslate" translate="no">admin@labourmin.gov.lk</a>') ?></li>
                        </ol>
                    </div>

                    <!-- Document Upload Section -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-8 notranslate">
                        <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-primary border-b border-gray-200 pb-2"><?= t('doc_upload_title', 'Document Upload') ?></h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div id="payment_slip_container">
                                <label class="block text-sm font-medium text-gray-700 mb-1"><?= t('payment_slip_label', 'Payment Slip') ?> <span class="text-red-500">*</span></label>
                                <input type="file" name="payment_slip" id="payment_slip" accept=".jpg,.jpeg,.png,.pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white" required>
                                <span class="text-[11px] text-gray-400 mt-1 block"><?= t('doc_supported_formats', 'Supported formats: JPG, JPEG, PNG, PDF (Max 5MB)') ?></span>
                            </div>
                            <div id="approval_letter_container">
                                <label class="block text-sm font-medium text-gray-700 mb-1"><?= t('approval_letter_label', 'Approval Letter') ?> <span class="text-red-500">*</span></label>
                                <input type="file" name="approval_letter" id="approval_letter" accept=".jpg,.jpeg,.png,.pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white" required>
                                <span class="text-[11px] text-gray-400 mt-1 block"><?= t('doc_supported_formats', 'Supported formats: JPG, JPEG, PNG, PDF (Max 5MB)') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6 notranslate">
                        <h4 class="font-medium text-gray-900 mb-3 text-sm"><?= t('declaration_title', 'Declaration') ?></h4>
                        <label class="flex items-start gap-3">
                            <input type="checkbox" id="declaration_check" class="mt-1 text-primary focus:ring-primary w-4 h-4 rounded" required>
                            <span class="text-sm text-gray-600 leading-relaxed">
                                <?= t('declaration_text', 'I hereby declare that all the information provided above is true and correct. I have read and understood the terms and conditions of the Ampara Circuit Bungalow and agree to abide by them. I understand that the payment receipt must be emailed or sent via WhatsApp after the application is submitted.') ?>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Form Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-5 border-t border-gray-100 notranslate">
                    <button type="button" id="btnPrev" class="hidden px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition"><?= t('btn_back', 'Back') ?></button>
                    <div class="ml-auto">
                        <button type="button" id="btnNext" class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition shadow-md"><?= t('btn_next_step', 'Next Step') ?></button>
                        <button type="submit" id="btnSubmit" class="hidden px-8 py-2.5 bg-secondary text-white font-medium rounded-lg hover:bg-[#320000] transition shadow-md"><?= t('btn_submit_app', 'Submit Application') ?></button>
                    </div>
                </div>

            </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Localized dictionary objects for JavaScript components
    const localizedStrings = {
        checking: <?= json_encode(t('room_checking', 'Checking...')) ?>,
        checkAvailability: <?= json_encode(t('btn_check_availability', 'Check Availability')) ?>,
        roomAvailSuccess: <?= json_encode(t('room_avail_success', 'Rooms available for selected dates. Please select:')) ?>,
        selectDatesFirst: <?= json_encode(t('room_select_dates_first', 'Please select Check-in and Check-out dates first.')) ?>,
        toastFillRequired: <?= json_encode(t('toast_fill_required', 'Please fill in all required fields.')) ?>,
        toastSelectRoom: <?= json_encode(t('toast_select_room', 'Please select at least one room or the entire bungalow to proceed.')) ?>,
        toastMaxGuests: <?= json_encode(t('toast_max_guests', 'Maximum 16 guests allowed.')) ?>,
        noRoomsSelected: <?= json_encode(t('no_rooms_selected', 'No rooms selected')) ?>,
        perNight: <?= json_encode(t('per_night', 'night')) ?>,
        estTotal: <?= json_encode(t('est_total', 'Est. Total')) ?>,
        nights: <?= json_encode(t('nights_label', 'Nights')) ?>,
        night: <?= json_encode(t('night_single_label', 'Night')) ?>,
        guestName: <?= json_encode(t('guest_name', 'Guest Name')) ?>,
        relationship: <?= json_encode(t('relationship', 'Relationship')) ?>,
        nicNumber: <?= json_encode(t('nic_number', 'NIC Number')) ?>,
        calMonths: <?= json_encode($current_lang === 'si' ? ['ජනවාරි', 'පෙබරවාරි', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජූනි', 'ජූලි', 'අගෝස්තු', 'සැප්තැම්බර්', 'ඔක්තෝබර්', 'නොවැම්බර්', 'දෙසැම්බර්'] : ($current_lang === 'ta' ? ['ஜனவரி', 'பிப்ரவரி', 'மார்ச்', 'ஏப்ரல்', 'மே', 'ஜூன்', 'ஜூலை', 'ஆகஸ்ட்', 'செப்டம்பர்', 'அக்டோபர்', 'நவம்பர்', 'டிசம்பர்'] : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])) ?>,
        calMonthsShort: <?= json_encode($current_lang === 'si' ? ['ජන', 'පෙබ', 'මාර්', 'අප්‍රේ', 'මැයි', 'ජූනි', 'ජූලි', 'අගෝ', 'සැප්', 'ඔක්', 'නොවැ', 'දෙසැ'] : ($current_lang === 'ta' ? ['ஜன', 'பிப்', 'மார்', 'ஏப்', 'மே', 'ஜூன்', 'ஜூலை', 'ஆக', 'செப்', 'அக்', 'நவ', 'டிச'] : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])) ?>,
        calDays: <?= json_encode($current_lang === 'si' ? ['ඉරි', 'සඳු', 'අඟ', 'බදා', 'බ්‍රහ', 'සිකු', 'සෙන'] : ($current_lang === 'ta' ? ['ஞாயி', 'திங்', 'செவ்', 'புத', 'வியா', 'வெள்', 'சனி'] : ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'])) ?>,
        calDaysLong: <?= json_encode($current_lang === 'si' ? ['ඉරිදා', 'සඳුදා', 'අඟහරුවාදා', 'බදාදා', 'බ්‍රහස්පතින්දා', 'සිකුරාදා', 'සෙනසුරාදා'] : ($current_lang === 'ta' ? ['ஞாயிற்றுக்கிழமை', 'திங்கட்கிழமை', 'செவ்வாய்க்கிழமை', 'புதன்கிழமை', 'வியாழக்கிழமை', 'வெள்ளிக்கிழமை', 'சனிக்கிழமை'] : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])) ?>,
        statusLabels: {
            'booked': <?= json_encode(t('cal_status_booked', 'Booked')) ?>,
            'pending': <?= json_encode(t('cal_status_pending', 'Pending')) ?>,
            'available': <?= json_encode(t('cal_status_available', 'Available')) ?>
        },
        calFailedLoad: <?= json_encode(t('cal_failed_load', 'Failed to load calendar.')) ?>,
        roomNames: {
            'Ground Floor Double Room (AC)': <?= json_encode(t('room_gf_double_ac', 'Ground Floor Double Room (AC)')) ?>,
            'Ground Floor Single Room (AC)': <?= json_encode(t('room_gf_single_ac', 'Ground Floor Single Room (AC)')) ?>,
            'Chalet Room (Single AC)': <?= json_encode(t('room_chalet_single_ac', 'Chalet Room (Single AC)')) ?>,
            'Upper Floor Double Room (AC)': <?= json_encode(t('room_uf_double_ac', 'Upper Floor Double Room (AC)')) ?>,
            'Driver\'s Room (Single Non-AC)': <?= json_encode(t('room_driver_single_non_ac', 'Driver\'s Room (Single Non-AC)')) ?>,
            'Entire Bungalow': <?= json_encode(t('room_entire_bungalow', 'Reserve Entire Bungalow')) ?>
        },
        roomCapacities: {
            'Ground Floor Double Room (AC)': <?= json_encode(t('room_max_guests_2', 'Max 2 Guests')) ?>,
            'Ground Floor Single Room (AC)': <?= json_encode(t('room_max_guests_1', 'Max 1 Guest')) ?>,
            'Chalet Room (Single AC)': <?= json_encode(t('room_max_guests_1', 'Max 1 Guest')) ?>,
            'Upper Floor Double Room (AC)': <?= json_encode(t('room_max_guests_4', 'Max 4 Guests')) ?>,
            'Driver\'s Room (Single Non-AC)': <?= json_encode(t('room_max_guests_2', 'Max 2 Guests')) ?>,
            'Entire Bungalow': <?= json_encode(t('room_entire_bungalow_desc', 'Exclusive access to all rooms')) ?>
        },
        roomQuantities: {
            1: <?= json_encode(t('room_qty_1', '1 Room')) ?>,
            2: <?= json_encode(t('room_qty_2', '2 Rooms')) ?>,
            3: <?= json_encode(t('room_qty_3', '3 Rooms')) ?>
        },
        categories: {
            'Ministry of Labour Staff': <?= json_encode(t('cat_mol_staff', 'Ministry of Labour Staff')) ?>,
            'Other Government/Private Sector': <?= json_encode(t('cat_other_govt_private', 'Other Govt / Private Sector')) ?>,
            'Foreign Visitors': <?= json_encode(t('cat_foreign_visitors', 'Foreign Visitors')) ?>
        }
    };

    let currentStep = 1;
    const totalSteps = 4;
    
    const steps = document.querySelectorAll('.form-step');
    const indicators = document.querySelectorAll('.step-indicator');
    const progressBar = document.getElementById('progress-bar');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    
    function updateUI() {
        // Update Form Steps with fade-in effect
        steps.forEach((step, index) => {
            if (index + 1 === currentStep) {
                step.classList.remove('hidden');
                step.classList.add('block', 'step-fade-in');
            } else {
                step.classList.add('hidden');
                step.classList.remove('block', 'step-fade-in');
            }
        });
        
        // Update Indicators
        indicators.forEach((indicator, index) => {
            const circle = indicator.querySelector('div');
            const text = indicator.querySelector('span');
            
            if (index + 1 < currentStep) {
                // Completed
                circle.className = 'w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm shadow-md transition-colors';
                circle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white/90 hidden sm:block notranslate';
            } else if (index + 1 === currentStep) {
                // Current
                circle.className = 'w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm shadow-md transition-colors';
                circle.innerHTML = index + 1;
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white hidden sm:block notranslate';
            } else {
                // Future
                circle.className = 'w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm';
                circle.innerHTML = index + 1;
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block notranslate';
            }
        });
        
        // Update Progress Bar
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progress}%`;
        
        // Update Buttons
        if (currentStep === 1) {
            btnPrev.classList.add('hidden');
        } else {
            btnPrev.classList.remove('hidden');
        }
        
        if (currentStep === totalSteps) {
            btnNext.classList.add('hidden');
            btnSubmit.classList.remove('hidden');
            populateSummary();
        } else {
            btnNext.classList.remove('hidden');
            btnSubmit.classList.add('hidden');
        }
    }

    // Identity Field & Card Selector Logic
    const applicantRadios = document.querySelectorAll('input[name="applicant_category"]');
    const nicContainer = document.getElementById('nic_container');
    const nicInput = document.getElementById('nic');
    const passportContainer = document.getElementById('passport_container');
    const passportInput = document.getElementById('passport_number');

    const designationContainer = document.getElementById('designation_container');
    const designationInput = document.getElementById('designation');
    const retiredContainer = document.getElementById('retired_container');
    const workplaceAddressContainer = document.getElementById('workplace_address_container');
    const workplaceAddressInput = document.getElementById('workplace_address');
    const approvalLetterContainer = document.getElementById('approval_letter_container');
    const approvalLetterInput = document.getElementById('approval_letter');

    function updateIdentityFields() {
        const checkedRadio = document.querySelector('input[name="applicant_category"]:checked');
        if(!checkedRadio) return;
        const category = checkedRadio.value;

        // NIC vs Passport toggle
        if (category === 'Foreign Visitors') {
            nicContainer.classList.add('hidden');
            nicInput.removeAttribute('required');
            nicInput.value = '';
            passportContainer.classList.remove('hidden');
            passportInput.setAttribute('required', 'required');
        } else {
            passportContainer.classList.add('hidden');
            passportInput.removeAttribute('required');
            passportInput.value = '';
            nicContainer.classList.remove('hidden');
            nicInput.setAttribute('required', 'required');
        }

        // Ministry-only fields toggle
        if (category === 'Ministry of Labour Staff') {
            designationContainer.classList.remove('hidden');
            designationInput.setAttribute('required', 'required');
            retiredContainer.classList.remove('hidden');
            workplaceAddressContainer.classList.remove('hidden');
            workplaceAddressInput.setAttribute('required', 'required');
            if (approvalLetterContainer && approvalLetterInput) {
                approvalLetterContainer.classList.remove('hidden');
                approvalLetterInput.setAttribute('required', 'required');
            }
        } else {
            designationContainer.classList.add('hidden');
            designationInput.removeAttribute('required');
            designationInput.value = '';
            retiredContainer.classList.add('hidden');
            workplaceAddressContainer.classList.add('hidden');
            workplaceAddressInput.removeAttribute('required');
            workplaceAddressInput.value = '';
            if (approvalLetterContainer && approvalLetterInput) {
                approvalLetterContainer.classList.add('hidden');
                approvalLetterInput.removeAttribute('required');
                approvalLetterInput.value = '';
            }
        }

        // Force refresh room container if open
        const container = document.getElementById('room-selection-container');
        if(!container.classList.contains('hidden')) {
            btnCheckAvailability.click();
        }
    }

    applicantRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove active classes from all cards
            document.querySelectorAll('.category-card').forEach(card => {
                card.classList.remove('border-primary', 'bg-blue-50/20');
                card.classList.add('border-gray-200');
                const svg = card.querySelector('svg');
                svg.classList.remove('text-primary');
                svg.classList.add('text-gray-400');
                const span = card.querySelector('span');
                span.classList.remove('font-bold', 'text-gray-900');
                span.classList.add('font-semibold', 'text-gray-700');
            });
            // Add active classes to selected card
            const card = this.closest('.category-card');
            card.classList.remove('border-gray-200');
            card.classList.add('border-primary', 'bg-blue-50/20');
            const svg = card.querySelector('svg');
            svg.classList.remove('text-gray-400');
            svg.classList.add('text-primary');
            const span = card.querySelector('span');
            span.classList.remove('font-semibold', 'text-gray-700');
            span.classList.add('font-bold', 'text-gray-900');

            updateIdentityFields();
        });
    });
    updateIdentityFields();

    // Configure Flatpickr Localization
    const flatpickrLocale = {
        firstDayOfWeek: 0,
        weekdays: {
            shorthand: localizedStrings.calDays,
            longhand: localizedStrings.calDaysLong
        },
        months: {
            shorthand: localizedStrings.calMonthsShort,
            longhand: localizedStrings.calMonths
        }
    };

    // Initialize Flatpickr on Check-in/Check-out dates & Arrival/Departure times
    const startPicker = flatpickr("#start_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: flatpickrLocale,
        onChange: function(selectedDates, dateStr, instance) {
            endPicker.set("minDate", dateStr || "today");
        }
    });
    const endPicker = flatpickr("#end_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: flatpickrLocale
    });

    flatpickr("#arrival_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: flatpickrLocale
    });
    flatpickr("#departure_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: flatpickrLocale
    });

    function populateSummary() {
        const nameVal = document.querySelector('input[name="applicant_name"]').value || '-';
        document.getElementById('summary-applicant-name').textContent = nameVal;

        const rawCatVal = document.querySelector('input[name="applicant_category"]:checked').value || '-';
        const categoryVal = localizedStrings.categories[rawCatVal] || rawCatVal;
        document.getElementById('summary-applicant-category').textContent = categoryVal;

        const startVal = document.getElementById('start_date').value;
        const endVal = document.getElementById('end_date').value;
        let durationText = '-';
        let nights = 0;
        if (startVal && endVal) {
            const d1 = new Date(startVal);
            const d2 = new Date(endVal);
            const diffTime = Math.abs(d2 - d1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            nights = diffDays;
            const nightLabel = nights > 1 ? localizedStrings.nights : localizedStrings.night;
            durationText = `${startVal} to ${endVal} (${nights} ${nightLabel})`;
        }
        document.getElementById('summary-duration').textContent = durationText;

        let roomsText = [];
        let totalCost = 0;
        const currentPrices = prices[rawCatVal] || prices['Ministry of Labour Staff'];
        const container = document.getElementById('room-selection-container');

        const entireBungalowCheck = document.getElementById('entire_bungalow_check');
        if (entireBungalowCheck && entireBungalowCheck.checked) {
            roomsText.push(localizedStrings.roomNames['Entire Bungalow'] || "Entire Bungalow");
            totalCost = currentPrices['Entire Bungalow'] * (nights || 1);
        } else {
            const checkedRooms = container.querySelectorAll('input[name="room_type[]"]:checked');
            checkedRooms.forEach(box => {
                const roomName = box.value;
                const qtySelect = container.querySelector(`select[name="room_qty[${roomName}]"]`);
                const qty = qtySelect ? parseInt(qtySelect.value) : 1;
                const localizedName = localizedStrings.roomNames[roomName] || roomName;
                roomsText.push(`${localizedName} (x${qty})`);
                
                const roomPrice = currentPrices[roomName] || 0;
                totalCost += roomPrice * qty;
            });
        }

        document.getElementById('summary-rooms').textContent = roomsText.join(', ') || localizedStrings.noRoomsSelected;
        document.getElementById('summary-cost').textContent = roomsText.length > 0 ? `Rs. ${totalCost.toLocaleString()} / ${localizedStrings.perNight} (${localizedStrings.estTotal}: Rs. ${(totalCost * (nights || 1)).toLocaleString()})` : 'Rs. 0';
    }
    
    function validateStep(step) {
        const currentStepEl = document.getElementById(`step-${step}`);
        const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
            } else {
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
            }
            if(input.type === 'checkbox' && !input.checked) {
                isValid = false;
                input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
            }
        });
        
        // Specific validation for step 1
        if (step === 1) {
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;
            if(!start || !end) {
                isValid = false;
            } else {
                const checkedRooms = document.querySelectorAll('input[name="room_type[]"]:checked');
                const entireBungalow = document.getElementById('entire_bungalow_check');
                const isEntireBooked = entireBungalow && entireBungalow.checked;
                
                if (checkedRooms.length === 0 && !isEntireBooked) {
                    isValid = false;
                    if (window.showToast) {
                        showToast(localizedStrings.toastSelectRoom, 'error');
                    }
                    return false;
                }
            }
        }
        
        if (!isValid) {
            if (window.showToast) {
                showToast(localizedStrings.toastFillRequired, 'error');
            }
        }
        return isValid;
    }
    
    btnNext.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            currentStep++;
            updateUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
    
    btnPrev.addEventListener('click', () => {
        currentStep--;
        updateUI();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    // Dynamic Guests
    const btnAddGuest = document.getElementById('btnAddGuest');
    const guestsContainer = document.getElementById('guests-container');
    let guestCount = 0;
    
    btnAddGuest.addEventListener('click', () => {
        if(guestCount >= 16) {
            if (window.showToast) {
                showToast(localizedStrings.toastMaxGuests, 'error');
            }
            return;
        }
        guestCount++;
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-gray-50 border border-gray-200 rounded-lg relative group notranslate';
        row.innerHTML = `
            <div class="md:col-span-5">
                <label class="block text-xs text-gray-500 mb-1">${localizedStrings.guestName}</label>
                <input type="text" name="guest_name[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none notranslate" required>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-500 mb-1">${localizedStrings.relationship}</label>
                <input type="text" name="guest_relation[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none notranslate" required>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-500 mb-1">${localizedStrings.nicNumber}</label>
                <input type="text" name="guest_nic[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none notranslate">
            </div>
            <div class="md:col-span-1 flex items-end justify-end">
                <button type="button" class="text-red-500 hover:text-red-700 p-2 btn-remove-guest" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        guestsContainer.appendChild(row);
        
        row.querySelector('.btn-remove-guest').addEventListener('click', function() {
            row.remove();
            guestCount--;
        });
    });

    // Check Availability Mock for UI completeness & Dynamic Pricing
    const btnCheckAvailability = document.getElementById('btnCheckAvailability');
    
    const prices = {
        'Ministry of Labour Staff': {
            'Ground Floor Double Room (AC)': 1500,
            'Ground Floor Single Room (AC)': 1200,
            'Chalet Room (Single AC)': 1200,
            'Upper Floor Double Room (AC)': 1500,
            'Driver\'s Room (Single Non-AC)': 500,
            'Entire Bungalow': 10000
        },
        'Other Government/Private Sector': {
            'Ground Floor Double Room (AC)': 3000,
            'Ground Floor Single Room (AC)': 2000,
            'Chalet Room (Single AC)': 2000,
            'Upper Floor Double Room (AC)': 3000,
            'Driver\'s Room (Single Non-AC)': 1000,
            'Entire Bungalow': 20000
        },
        'Foreign Visitors': {
            'Ground Floor Double Room (AC)': 6000,
            'Ground Floor Single Room (AC)': 4000,
            'Chalet Room (Single AC)': 4000,
            'Upper Floor Double Room (AC)': 6000,
            'Driver\'s Room (Single Non-AC)': 2000,
            'Entire Bungalow': 35000
        }
    };

    btnCheckAvailability.addEventListener('click', function() {
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;
        const msg = document.getElementById('availability-message');
        const container = document.getElementById('room-selection-container');
        
        if(!start || !end) {
            msg.textContent = localizedStrings.selectDatesFirst;
            msg.className = 'text-sm mb-4 text-red-600 block notranslate';
            return;
        }
        
        btnCheckAvailability.disabled = true;
        btnCheckAvailability.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg> ${localizedStrings.checking}`;
        
        setTimeout(() => {
            btnCheckAvailability.disabled = false;
            btnCheckAvailability.textContent = localizedStrings.checkAvailability;
            msg.textContent = localizedStrings.roomAvailSuccess;
            msg.className = 'text-sm mb-4 text-green-700 block font-medium notranslate';
            
            const category = document.querySelector('input[name="applicant_category"]:checked').value;
            const currentPrices = prices[category] || prices['Ministry of Labour Staff'];

            container.innerHTML = `
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Ground Floor Double Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">${localizedStrings.roomNames['Ground Floor Double Room (AC)']} <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Ground Floor Double Room (AC)'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Ground Floor Double Room (AC)']}</span>
                        </div>
                    </label>
                    <select name="room_qty[Ground Floor Double Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">${localizedStrings.roomQuantities[1]}</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3 notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Ground Floor Single Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">${localizedStrings.roomNames['Ground Floor Single Room (AC)']} <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Ground Floor Single Room (AC)'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Ground Floor Single Room (AC)']}</span>
                        </div>
                    </label>
                    <select name="room_qty[Ground Floor Single Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">${localizedStrings.roomQuantities[1]}</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3 notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Chalet Room (Single AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">${localizedStrings.roomNames['Chalet Room (Single AC)']} <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Chalet Room (Single AC)'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Chalet Room (Single AC)']}</span>
                        </div>
                    </label>
                    <select name="room_qty[Chalet Room (Single AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">${localizedStrings.roomQuantities[1]}</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3 notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Upper Floor Double Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">${localizedStrings.roomNames['Upper Floor Double Room (AC)']} <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Upper Floor Double Room (AC)'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Upper Floor Double Room (AC)']}</span>
                        </div>
                    </label>
                    <select name="room_qty[Upper Floor Double Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">${localizedStrings.roomQuantities[1]}</option>
                        <option value="2">${localizedStrings.roomQuantities[2]}</option>
                        <option value="3">${localizedStrings.roomQuantities[3]}</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3 notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Driver\'s Room (Single Non-AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">${localizedStrings.roomNames['Driver\'s Room (Single Non-AC)']} <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Driver\'s Room (Single Non-AC)'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Driver\'s Room (Single Non-AC)']}</span>
                        </div>
                    </label>
                    <select name="room_qty[Driver\'s Room (Single Non-AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">${localizedStrings.roomQuantities[1]}</option>
                    </select>
                </div>
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-4 border-t-2 border-t-secondary pt-4 notranslate">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="entire_bungalow" id="entire_bungalow_check" value="Yes" class="text-secondary focus:ring-secondary w-5 h-5 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-gray-900">${localizedStrings.roomNames['Entire Bungalow']} <span class="text-secondary ml-2 font-bold">Rs. ${currentPrices['Entire Bungalow'].toLocaleString()} / ${localizedStrings.perNight}</span></span>
                            <span class="block text-xs text-gray-500">${localizedStrings.roomCapacities['Entire Bungalow']}</span>
                        </div>
                    </label>
                </div>
            `;
            container.classList.remove('hidden');

            // Toggle active card styling for room checkboxes
            container.querySelectorAll('input[name="room_type[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.room-option');
                    if(!card) return;
                    if(this.checked) {
                        card.classList.remove('border-gray-200', 'bg-white');
                        card.classList.add('border-primary', 'bg-blue-50/10');
                    } else {
                        card.classList.remove('border-primary', 'bg-blue-50/10');
                        card.classList.add('border-gray-200', 'bg-white');
                    }
                });
            });

            const entireBungalowCheck = document.getElementById('entire_bungalow_check');
            entireBungalowCheck.addEventListener('change', function(e) {
                const roomBoxes = container.querySelectorAll('input[name="room_type[]"]');
                const selects = container.querySelectorAll('.room-qty');
                const roomContainers = container.querySelectorAll('.room-option');
                
                if (e.target.checked) {
                    roomBoxes.forEach(box => { 
                        box.checked = false; 
                        box.disabled = true; 
                        const card = box.closest('.room-option');
                        if(card) {
                            card.classList.remove('border-primary', 'bg-blue-50/10');
                            card.classList.add('border-gray-200', 'bg-white');
                        }
                    });
                    selects.forEach(sel => sel.disabled = true);
                    roomContainers.forEach(rc => rc.classList.add('opacity-50', 'pointer-events-none'));
                } else {
                    roomBoxes.forEach(box => box.disabled = false);
                    selects.forEach(sel => sel.disabled = false);
                    roomContainers.forEach(rc => rc.classList.remove('opacity-50', 'pointer-events-none'));
                }
            });

        }, 800);
    });

    // Populate Weekday Headers
    const weekdaysRow = document.getElementById('calendar-weekdays-row');
    if (weekdaysRow) {
        weekdaysRow.innerHTML = localizedStrings.calDays.map(d => `<span>${d}</span>`).join('');
    }

    // Visual Availability Calendar Grid logic
    let currentCalDate = new Date();

    window.renderVisualCalendar = function(monthStr) {
        const daysContainer = document.getElementById('calendar-days-container');
        const monthLabel = document.getElementById('calendar-month-label');
        if (!daysContainer) return;

        const parts = monthStr.split('-');
        const y = parseInt(parts[0]);
        const m = parseInt(parts[1]) - 1;
        monthLabel.textContent = `${localizedStrings.calMonths[m]} ${y}`;
        
        let skeletons = '';
        for (let i = 0; i < 28; i++) {
            skeletons += '<div class="h-9 border border-slate-100 rounded-lg skeleton-box"></div>';
        }
        daysContainer.innerHTML = skeletons;

        fetch('check-room-availability?action=month_calendar&month=' + monthStr)
            .then(res => res.json())
            .then(data => {
                const dateStatus = data.date_status || {};
                const year = parseInt(monthStr.split('-')[0]);
                const month = parseInt(monthStr.split('-')[1]) - 1;

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                let html = '';
                for (let i = 0; i < firstDay; i++) {
                    html += '<div class="h-8"></div>';
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const status = dateStatus[dayStr];
                    const statusLabel = localizedStrings.statusLabels[status] || localizedStrings.statusLabels['available'];
                    
                    let bgClass = 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100';
                    let badgeDot = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>';

                    if (status === 'booked') {
                        bgClass = 'bg-red-50 text-red-700 border-red-200 cursor-not-allowed opacity-80';
                        badgeDot = '<span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>';
                    } else if (status === 'pending') {
                        bgClass = 'bg-amber-50 text-amber-800 border-amber-200';
                        badgeDot = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>';
                    }

                    html += `
                        <div class="h-9 border rounded-lg flex flex-col items-center justify-center text-[11px] font-bold transition-all ${bgClass} notranslate" title="${dayStr}: ${statusLabel}">
                            <span>${day}</span>
                            ${badgeDot}
                        </div>
                    `;
                }
                daysContainer.innerHTML = html;
            })
            .catch(() => {
                daysContainer.innerHTML = `<div class="col-span-7 py-4 text-center text-xs text-red-500 notranslate">${localizedStrings.calFailedLoad}</div>`;
            });
    };

    window.changeCalendarMonth = function(delta) {
        currentCalDate.setMonth(currentCalDate.getMonth() + delta);
        const mStr = currentCalDate.toISOString().slice(0, 7);
        renderVisualCalendar(mStr);
    };

    // Initialize initial month
    renderVisualCalendar(currentCalDate.toISOString().slice(0, 7));

    // Add one default guest row
    btnAddGuest.click();
});
</script>

<!-- Load Flatpickr CSS & JS dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .step-fade-in {
        animation: fadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Make Flatpickr blend with tailwind and form design */
    .flatpickr-calendar {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #E5E7EB;
        border-radius: 12px;
    }
    .flatpickr-day.selected, .flatpickr-day.selected:focus, .flatpickr-day.selected:hover {
        background: #13273F;
        border-color: #13273F;
    }
    .flatpickr-current-month .numInputWrapper {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        padding: 2px;
    }
    .flatpickr-current-month .numInputWrapper:hover {
        background: rgba(0, 0, 0, 0.1);
    }
</style>

<?php include 'includes/footer.php'; ?>
