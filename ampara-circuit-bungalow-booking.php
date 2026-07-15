<?php
$page_title = 'Ampara Circuit Bungalow Booking';
$is_success = isset($_GET['success']) && $_GET['success'] == '1';
$pageTitle = 'Book Ampara Circuit Bungalow - Ministry of Labour - Sri Lanka';
$metaDescription = 'Book the Ampara Circuit Bungalow online. Fill in your reservation details, applicant information, and submit your request.';
$metaKeywords = 'Ampara Circuit Bungalow, Booking, Accommodation, Ministry of Labour, Sri Lanka';
$breadcrumbs = [
    ['label' => 'Circuit Bungalows', 'url' => 'ampara-circuit-bungalow.php'],
    ['label' => 'Ampara', 'url' => 'ampara-circuit-bungalow.php'],
    ['label' => 'Book Now']
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>


<section class="py-12 md:py-16 px-4 md:px-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <?php if ($is_success): ?>
                <div class="text-center py-12 px-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-montserrat font-bold text-gray-900 mb-4">Application Submitted!</h3>
                    <p class="text-gray-600 max-w-md mx-auto mb-8 leading-relaxed">
                        Your booking application has been received and is currently <strong>Pending Approval</strong>. Once the Ministry confirms your booking, you may proceed with the payment.
                    </p>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-left max-w-lg mx-auto mb-8">
                        <h4 class="font-semibold text-blue-900 mb-4">Payment Instructions</h4>
                        <ol class="list-decimal pl-5 text-sm text-blue-800 space-y-3">
                            <li>Deposit the required amount to:<br>
                                <strong class="text-gray-900">Bank:</strong> People's Bank – Narahenpita Branch<br>
                                <strong class="text-gray-900">Account Number:</strong> 119-1-001-59025666
                            </li>
                            <li>Send the payment receipt via Email to <a href="mailto:admin@labourmin.gov.lk" class="font-medium underline">admin@labourmin.gov.lk</a> or via WhatsApp.</li>
                        </ol>
                    </div>
                    <a href="ampara-circuit-bungalow.php" class="inline-flex px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition shadow-md">Return to Details</a>
                </div>
            <?php else: ?>
            <!-- Form Header & Stepper -->

            <div class="bg-primary px-8 py-6 text-white">
                <h2 class="text-2xl font-montserrat font-semibold mb-6">Ampara Circuit Bungalow Reservation Form</h2>
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-white/20 z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-white z-0 transition-all duration-500" id="progress-bar" style="width: 0%;"></div>
                    
                    <!-- Steps -->
                    <div class="step-indicator active relative z-10 flex flex-col items-center gap-2" data-step="1">
                        <div class="w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm shadow-md transition-colors">1</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium hidden sm:block">Reservation</span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="2">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">2</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block">Applicant</span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="3">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">3</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block">Guests</span>
                    </div>
                    <div class="step-indicator relative z-10 flex flex-col items-center gap-2" data-step="4">
                        <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm">4</div>
                        <span class="text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block">Confirm</span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form id="bookingForm" action="process-ampara-booking" method="POST" class="p-8" enctype="multipart/form-data">
                
                <!-- Step 1: Reservation Details -->
                <div class="form-step active" id="step-1">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b">1. Reservation Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Check-in Date <span class="text-red-500">*</span></label>
                            <input type="text" name="start_date" id="start_date" placeholder="Select check-in date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer" required readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Check-out Date <span class="text-red-500">*</span></label>
                            <input type="text" name="end_date" id="end_date" placeholder="Select check-out date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer" required readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expected Arrival Time</label>
                            <input type="text" name="arrival_time" id="arrival_time" placeholder="Select arrival time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expected Departure Time</label>
                            <input type="text" name="departure_time" id="departure_time" placeholder="Select departure time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white cursor-pointer" readonly>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Applicant Category <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="category-card cursor-pointer border rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative border-primary bg-blue-50/20 text-center">
                                    <input type="radio" name="applicant_category" value="Ministry of Labour Staff" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4" checked>
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-bold text-gray-900 block mt-1">Ministry of Labour Staff</span>
                                </label>
                                <label class="category-card cursor-pointer border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative text-center">
                                    <input type="radio" name="applicant_category" value="Other Government/Private Sector" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700 block mt-1">Other Govt / Private Sector</span>
                                </label>
                                <label class="category-card cursor-pointer border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all hover:border-primary hover:bg-slate-50 relative text-center">
                                    <input type="radio" name="applicant_category" value="Foreign Visitors" class="absolute top-3 right-3 text-primary focus:ring-primary w-4 h-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2.945M11 20.935V19a2 2 0 012-2h2.83M11 21a9 9 0 119-9m-9 0a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-sm font-semibold text-gray-700 block mt-1">Foreign Visitors</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-900">Room Selection</h4>
                            <button type="button" id="btnCheckAvailability" class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Check Availability</button>
                        </div>
                        <div id="availability-message" class="text-sm mb-4 hidden"></div>
                        <div id="room-selection-container" class="space-y-3 hidden">
                            <!-- Rooms will be populated here via AJAX -->
                        </div>
                    </div>
                </div>

                <!-- Step 2: Applicant Details -->
                <div class="form-step hidden" id="step-2">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b">2. Applicant Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="applicant_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                        </div>
                        <div id="designation_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Designation <span class="text-red-500">*</span></label>
                            <input type="text" name="designation" id="designation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                        </div>
                        <div id="nic_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1">National Identity Card (NIC) <span class="text-red-500">*</span></label>
                            <input type="text" name="nic" id="nic" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                        </div>
                        <div id="passport_container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Passport Number <span class="text-red-500">*</span></label>
                            <input type="text" name="passport_number" id="passport_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        </div>
                        <div id="retired_container">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Retired? <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_retired" value="Yes" class="text-primary focus:ring-primary w-4 h-4">
                                    <span class="ml-2 text-sm text-gray-700">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_retired" value="No" class="text-primary focus:ring-primary w-4 h-4" checked>
                                    <span class="ml-2 text-sm text-gray-700">No</span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2" id="workplace_address_container">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ministry/Department/Organization & Address <span class="text-red-500">*</span></label>
                            <textarea name="workplace_address" id="workplace_address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Residential Address <span class="text-red-500">*</span></label>
                            <textarea name="residential_address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone_mobile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Office Number</label>
                            <input type="tel" name="phone_office" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Other Guests -->
                <div class="form-step hidden" id="step-3">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-2">3. Details of Other Guests</h3>
                    <p class="text-sm text-gray-500 mb-6 pb-2 border-b">Do not include children under 12 years of age. (Maximum 16 guests). <span class="text-slate-400">If you are traveling alone, you can remove the default guest card below.</span></p>
                    
                    <div id="guests-container" class="space-y-4 mb-4">
                        <!-- Guest rows will be added here -->
                    </div>
                    
                    <button type="button" id="btnAddGuest" class="px-4 py-2 border border-dashed border-primary text-primary font-medium rounded-lg hover:bg-blue-50 transition w-full flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Guest
                    </button>
                </div>

                <!-- Step 4: Confirm & Submit -->
                <div class="form-step hidden" id="step-4">
                    <h3 class="text-xl font-montserrat font-semibold text-gray-800 mb-6 pb-2 border-b">4. Confirmation & Declaration</h3>
                    
                    <!-- Booking Summary Box -->
                    <div id="booking-summary-box" class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-8">
                        <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-primary border-b border-gray-200 pb-2">Booking Details Summary</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Applicant Name</span>
                                <span id="summary-applicant-name" class="font-semibold text-gray-800 text-base">-</span>
                                <span id="summary-applicant-category" class="block text-xs text-gray-500 font-medium mt-0.5">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Booking Duration</span>
                                <span id="summary-duration" class="font-semibold text-gray-800 text-base">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Selected Rooms</span>
                                <span id="summary-rooms" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Total Estimated Cost</span>
                                <span id="summary-cost" class="font-bold text-secondary text-lg">-</span>
                            </div>
                        </div>
                    </div>


                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6">
                        <h4 class="font-medium text-gray-900 mb-3 text-sm">Declaration</h4>
                        <label class="flex items-start gap-3">
                            <input type="checkbox" id="declaration_check" class="mt-1 text-primary focus:ring-primary w-4 h-4 rounded" required>
                            <span class="text-sm text-gray-600 leading-relaxed">
                                I hereby declare that all the information provided above is true and correct. I have read and understood the terms and conditions of the Ampara Circuit Bungalow and agree to abide by them. I understand that the payment receipt must be emailed or sent via WhatsApp after the application is submitted.
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Form Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-5 border-t border-gray-100">
                    <button type="button" id="btnPrev" class="hidden px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">Back</button>
                    <div class="ml-auto">
                        <button type="button" id="btnNext" class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition shadow-md">Next Step</button>
                        <button type="submit" id="btnSubmit" class="hidden px-8 py-2.5 bg-secondary text-white font-medium rounded-lg hover:bg-[#320000] transition shadow-md">Submit Application</button>
                    </div>
                </div>

            </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white/90 hidden sm:block';
            } else if (index + 1 === currentStep) {
                // Current
                circle.className = 'w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm shadow-md transition-colors';
                circle.innerHTML = index + 1;
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white hidden sm:block';
            } else {
                // Future
                circle.className = 'w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors backdrop-blur-sm';
                circle.innerHTML = index + 1;
                text.className = 'text-[11px] uppercase tracking-wider font-medium text-white/70 hidden sm:block';
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
        } else {
            designationContainer.classList.add('hidden');
            designationInput.removeAttribute('required');
            designationInput.value = '';
            retiredContainer.classList.add('hidden');
            workplaceAddressContainer.classList.add('hidden');
            workplaceAddressInput.removeAttribute('required');
            workplaceAddressInput.value = '';
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

    // Initialize Flatpickr on Check-in/Check-out dates & Arrival/Departure times
    const startPicker = flatpickr("#start_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            endPicker.set("minDate", dateStr || "today");
        }
    });
    const endPicker = flatpickr("#end_date", {
        minDate: "today",
        dateFormat: "Y-m-d"
    });

    flatpickr("#arrival_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
    flatpickr("#departure_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    function populateSummary() {
        const nameVal = document.querySelector('input[name="applicant_name"]').value || '-';
        document.getElementById('summary-applicant-name').textContent = nameVal;

        const categoryVal = document.querySelector('input[name="applicant_category"]:checked').value || '-';
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
            durationText = `${startVal} to ${endVal} (${nights} Night${nights > 1 ? 's' : ''})`;
        }
        document.getElementById('summary-duration').textContent = durationText;

        let roomsText = [];
        let totalCost = 0;
        const currentPrices = prices[categoryVal];
        const container = document.getElementById('room-selection-container');

        const entireBungalowCheck = document.getElementById('entire_bungalow_check');
        if (entireBungalowCheck && entireBungalowCheck.checked) {
            roomsText.push("Entire Bungalow");
            totalCost = currentPrices['Entire Bungalow'] * (nights || 1);
        } else {
            const checkedRooms = container.querySelectorAll('input[name="room_type[]"]:checked');
            checkedRooms.forEach(box => {
                const roomName = box.value;
                const qtySelect = container.querySelector(`select[name="room_qty[${roomName}]"]`);
                const qty = qtySelect ? parseInt(qtySelect.value) : 1;
                roomsText.push(`${roomName} (x${qty})`);
                
                const roomPrice = currentPrices[roomName] || 0;
                totalCost += roomPrice * qty;
            });
        }

        document.getElementById('summary-rooms').textContent = roomsText.join(', ') || 'No rooms selected';
        document.getElementById('summary-cost').textContent = roomsText.length > 0 ? `Rs. ${totalCost.toLocaleString()} / night (Est. Rs. ${(totalCost * (nights || 1)).toLocaleString()} total)` : 'Rs. 0';
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
                    window.showToast ? window.showToast('Please select at least one room or the entire bungalow to proceed.', 'error') : alert('Please select at least one room.');
                    return false; // Exit immediately to prevent showing duplicate fill-in-fields toast
                }
            }
        }
        
        if (!isValid) {
            window.showToast ? window.showToast('Please fill in all required fields.', 'error') : alert('Please fill in all required fields.');
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
            window.showToast ? window.showToast('Maximum 16 guests allowed.', 'error') : alert('Maximum 16 guests allowed.');
            return;
        }
        guestCount++;
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-gray-50 border border-gray-200 rounded-lg relative group';
        row.innerHTML = `
            <div class="md:col-span-5">
                <label class="block text-xs text-gray-500 mb-1">Guest Name</label>
                <input type="text" name="guest_name[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none" required>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-500 mb-1">Relationship</label>
                <input type="text" name="guest_relation[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none" required>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-500 mb-1">NIC Number</label>
                <input type="text" name="guest_nic[]" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary outline-none">
            </div>
            <div class="md:col-span-1 flex items-end justify-end">
                <button type="button" class="text-red-500 hover:text-red-700 p-2 btn-remove-guest">
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
            msg.textContent = 'Please select Check-in and Check-out dates first.';
            msg.className = 'text-sm mb-4 text-red-600 block';
            return;
        }
        
        btnCheckAvailability.disabled = true;
        btnCheckAvailability.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg> Checking...`;
        
        // Since backend isn't ready for new categories, we'll simulate the UI
        setTimeout(() => {
            btnCheckAvailability.disabled = false;
            btnCheckAvailability.textContent = 'Check Availability';
            msg.textContent = 'Rooms available for selected dates. Please select:';
            msg.className = 'text-sm mb-4 text-green-700 block font-medium';
            
            const category = document.querySelector('input[name="applicant_category"]:checked').value;
            const currentPrices = prices[category];

            container.innerHTML = `
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Ground Floor Double Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Ground Floor Double Room (AC) <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Ground Floor Double Room (AC)'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Max 2 Guests</span>
                        </div>
                    </label>
                    <select name="room_qty[Ground Floor Double Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">1 Room</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Ground Floor Single Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Ground Floor Single Room (AC) <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Ground Floor Single Room (AC)'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Max 1 Guest</span>
                        </div>
                    </label>
                    <select name="room_qty[Ground Floor Single Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">1 Room</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Chalet Room (Single AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Chalet Room (Single AC) <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Chalet Room (Single AC)'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Max 1 Guest</span>
                        </div>
                    </label>
                    <select name="room_qty[Chalet Room (Single AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">1 Room</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Upper Floor Double Room (AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Upper Floor Double Room (AC) <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Upper Floor Double Room (AC)'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Max 4 Guests</span>
                        </div>
                    </label>
                    <select name="room_qty[Upper Floor Double Room (AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">1 Room</option>
                        <option value="2">2 Rooms</option>
                        <option value="3">3 Rooms</option>
                    </select>
                </div>
                <div class="room-option flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-3">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="room_type[]" value="Driver\'s Room (Single Non-AC)" class="text-primary focus:ring-primary w-4 h-4 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Driver's Room (Single Non-AC) <span class="text-primary ml-2 font-bold">Rs. ${currentPrices['Driver\'s Room (Single Non-AC)'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Max 2 Guests</span>
                        </div>
                    </label>
                    <select name="room_qty[Driver\'s Room (Single Non-AC)]" class="room-qty text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-primary">
                        <option value="1">1 Room</option>
                    </select>
                </div>
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-primary transition cursor-pointer mt-4 border-t-2 border-t-secondary pt-4">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="checkbox" name="entire_bungalow" id="entire_bungalow_check" value="Yes" class="text-secondary focus:ring-secondary w-5 h-5 rounded">
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-gray-900">Reserve Entire Bungalow <span class="text-secondary ml-2 font-bold">Rs. ${currentPrices['Entire Bungalow'].toLocaleString()} / night</span></span>
                            <span class="block text-xs text-gray-500">Exclusive access to all rooms</span>
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

    // Handle Form Submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if(!validateStep(currentStep)) {
            e.preventDefault();
        }
    });
    
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

    /* Make Flatpickr blend beautifully with tailwind and form design */
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
