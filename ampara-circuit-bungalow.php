<?php
// ampara-circuit-bungalow.php
session_start();
require_once 'admin/includes/db.php';

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = '';

// Calculate disabled dates (fully booked or entire bungalow booked)
$disabled_dates = [];
try {
    $bookings = $pdo->query("SELECT start_date, end_date, room_type, no_of_rooms FROM bookings WHERE bungalow_name = 'Ampara' AND status = 'Confirmed' AND end_date >= CURRENT_DATE()")->fetchAll(PDO::FETCH_ASSOC);

    $dateMap = [];
    foreach ($bookings as $b) {
        $start = new DateTime($b['start_date']);
        $end = new DateTime($b['end_date']);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end->modify('+1 day'));
        
        foreach ($period as $dateObj) {
            $dateStr = $dateObj->format('Y-m-d');
            if (!isset($dateMap[$dateStr])) {
                $dateMap[$dateStr] = [
                    'VIP Room' => 0,
                    'A/C Triple Room' => 0,
                    'A/C Double Room' => 0,
                    'Entire Bungalow' => 0
                ];
            }
            $type = $b['room_type'];
            if (isset($dateMap[$dateStr][$type])) {
                $dateMap[$dateStr][$type] += $b['no_of_rooms'];
            }
        }
    }

    $capacities = [
        'VIP Room' => 1,
        'A/C Triple Room' => 4,
        'A/C Double Room' => 1
    ];

    foreach ($dateMap as $dateStr => $booked) {
        if ($booked['Entire Bungalow'] > 0) {
            $disabled_dates[] = $dateStr;
            continue;
        }
        
        $fullyBooked = true;
        foreach ($capacities as $type => $cap) {
            if ($booked[$type] < $cap) {
                $fullyBooked = false;
                break;
            }
        }
        if ($fullyBooked) {
            $disabled_dates[] = $dateStr;
        }
    }
} catch (Exception $e) {
    error_log("Failed to load disabled dates: " . $e->getMessage());
}
$disabled_dates_json = json_encode($disabled_dates);
// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Old booking logic removed. Booking is now handled in ampara-circuit-bungalow-booking.php
// ampara-circuit-bungalow.php
$page_title = 'Ampara Circuit Bungalow';
$pageTitle = 'Ampara Circuit Bungalow - Ministry of Labour - Sri Lanka';
$metaDescription = 'Book the Ampara Circuit Bungalow. Discover accommodation details, room types, pricing, and amenities for your stay in Ampara, Sri Lanka.';
$metaKeywords = 'Ampara Circuit Bungalow, Booking, Accommodation, Ministry of Labour, Sri Lanka';
$breadcrumbs = [
    ['label' => 'Circuit Bungalows'],
    ['label' => 'Ampara Circuit Bungalow']
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white">
    <div class="container mx-auto flex flex-col lg:flex-row gap-8 lg:gap-12">

        <!-- Left Side: Main Content -->
        <div class="w-full lg:w-[65%]">

            <!-- Gallery -->
            <div class="mb-8">
                <!-- Main Image -->
                <div class="w-full h-[300px] md:h-[400px] lg:h-[480px] rounded-[24px] overflow-hidden mb-4 relative cursor-pointer group shadow-lg border border-slate-100/50">
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-1.webp" class="block w-full h-full relative">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-1.webp" alt="Ampara Circuit Bungalow"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <span class="text-white text-xs font-bold tracking-wider uppercase bg-slate-900/60 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                                Click to view fullscreen
                            </span>
                        </div>
                    </a>
                </div>
                <!-- Thumbnails -->
                <div class="flex overflow-x-auto md:grid md:grid-cols-5 gap-3 md:gap-4 pb-2 md:pb-0 snap-x snap-mandatory hide-scrollbar">
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-2.webp"
                        class="block w-[30%] shrink-0 md:w-auto aspect-video md:aspect-[4/3] rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary shadow-sm transition-all duration-300 snap-start hover:-translate-y-0.5">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-2.webp" alt="Thumbnail 1"
                            class="w-full h-full object-cover">
                    </a>
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-3.webp"
                        class="block w-[30%] shrink-0 md:w-auto aspect-video md:aspect-[4/3] rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary shadow-sm transition-all duration-300 snap-start hover:-translate-y-0.5">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-3.webp" alt="Thumbnail 2"
                            class="w-full h-full object-cover">
                    </a>
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-4.webp"
                        class="block w-[30%] shrink-0 md:w-auto aspect-video md:aspect-[4/3] rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary shadow-sm transition-all duration-300 snap-start hover:-translate-y-0.5">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-4.webp" alt="Thumbnail 3"
                            class="w-full h-full object-cover">
                    </a>
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-5.webp"
                        class="block w-[30%] shrink-0 md:w-auto aspect-video md:aspect-[4/3] rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary shadow-sm transition-all duration-300 snap-start hover:-translate-y-0.5">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bungalow-5.webp" alt="Thumbnail 4"
                            class="w-full h-full object-cover">
                    </a>
                    <a data-fslightbox="gallery" href="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bunglalow-6.webp"
                        class="block w-[30%] shrink-0 md:w-auto aspect-video md:aspect-[4/3] rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary shadow-sm transition-all duration-300 relative group snap-start hover:-translate-y-0.5">
                        <img loading="lazy" src="<?= $base_url ?>assets/img/circuit-bunglalow/ampara/ampara-bunglalow-6.webp" alt="Thumbnail 5"
                            class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                            <span class="text-white font-bold text-xs uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                                More
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Title & Rating & Description Wrapper Card -->
            <div class="bg-white rounded-[24px] border border-slate-100/80 p-6 md:p-8 shadow-[0_4px_25px_rgba(0,0,0,0.015)] mb-8">
                <!-- Title & Rating -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-slate-50 pb-4">
                    <h2 class="text-2xl md:text-3xl font-bold font-montserrat text-gray-900 tracking-tight">Ampara Circuit Bungalow</h2>
                </div>

                <!-- Description -->
                <div class="text-slate-600 font-inter text-[14.5px] leading-relaxed space-y-4 mb-6">
                    <p>
                        Ampara, a town located in the Eastern Province of Sri Lanka, is known for its beautiful landscapes,
                        wildlife sanctuaries, and historical heritage. If you are planning a visit to this scenic region, finding the right
                        accommodation is crucial for a comfortable and memorable stay.
                    </p>
                    <p>
                        The Ministry of Labour has established this Circuit Bungalow in Ampara to provide premium accommodation
                        facilities for its officers. While primarily reserved for the Department of Labour staff, other public sector
                        officers and general citizens are welcome to apply if availability permits.
                    </p>
                    <p>
                        The bungalow features air-conditioned double and single rooms, chalets, common dining halls, and full culinary facilities.
                        Meal preparation can be requested on-site, or guests may arrange to utilize the kitchen resources directly.
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-50">
                    <a href="https://maps.app.goo.gl/LNeQQ3s4E5vq4AD98" target="_blank"
                        class="inline-flex items-center gap-2 text-secondary hover:text-[#320000] font-bold text-xs uppercase tracking-wide transition-colors">
                        View Location on Google Maps
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2 2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Booking Widget (Mobile Only) -->
            <div class="block lg:hidden bg-white rounded-[24px] p-6 border border-slate-100 shadow-md mb-8">
                <div class="flex items-baseline gap-1.5 mb-5">
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Starting From</span>
                    <span class="text-3xl font-extrabold text-gray-900 font-montserrat tracking-tight">Rs. 2,000</span>
                    <span class="text-slate-400 text-xs font-medium">/ night</span>
                </div>

                <hr class="border-slate-100 mb-5">

                <?php if ($success): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl mb-4 font-inter text-sm font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Your booking request has been submitted successfully and is pending approval.
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl mb-4 font-inter text-sm font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <a href="ampara-circuit-bungalow-booking"
                        class="block text-center w-full py-3.5 px-4 bg-gradient-to-r from-secondary to-[#721c1c] text-white font-bold rounded-xl hover:shadow-lg transition-all text-xs uppercase tracking-wider shadow-md">
                        Check Availability & Book
                    </a>
                </div>
                <div class="mt-4 text-center text-[11px] text-slate-400 font-medium leading-relaxed">
                    Select your dates and check room availability to submit a reservation request. Offline payments apply post-approval.
                </div>
            </div>

            <!-- Amenities & Facilities -->
            <div class="mb-8 bg-white rounded-[24px] p-6 md:p-8 border border-slate-100/80 shadow-[0_4px_25px_rgba(0,0,0,0.015)]">
                <h3 class="text-lg font-bold font-montserrat text-gray-900 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Amenities & Facilities
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <!-- Air Conditioning -->
                    <div class="bg-[#F8FAFC] border border-slate-100 hover:border-slate-200 hover:bg-white hover:shadow-md hover:-translate-y-0.5 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2.5 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-white group-hover:bg-secondary/5 text-slate-400 group-hover:text-secondary rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3m14.5-5.5l-11 11m0-11l11 11"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors duration-200">Air Conditioning</span>
                    </div>
                    <!-- Parking -->
                    <div class="bg-[#F8FAFC] border border-slate-100 hover:border-slate-200 hover:bg-white hover:shadow-md hover:-translate-y-0.5 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2.5 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-white group-hover:bg-secondary/5 text-slate-400 group-hover:text-secondary rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors duration-200">Vehicle Parking</span>
                    </div>
                    <!-- Hot Water -->
                    <div class="bg-[#F8FAFC] border border-slate-100 hover:border-slate-200 hover:bg-white hover:shadow-md hover:-translate-y-0.5 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2.5 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-white group-hover:bg-secondary/5 text-slate-400 group-hover:text-secondary rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors duration-200">Hot Water</span>
                    </div>
                    <!-- Kitchen -->
                    <div class="bg-[#F8FAFC] border border-slate-100 hover:border-slate-200 hover:bg-white hover:shadow-md hover:-translate-y-0.5 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2.5 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-white group-hover:bg-secondary/5 text-slate-400 group-hover:text-secondary rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors duration-200">Kitchen & Dining</span>
                    </div>
                </div>
            </div>

            <!-- Accommodation & Room Rates -->
            <div class="mb-10 bg-white rounded-[24px] p-6 md:p-8 border border-slate-100/80 shadow-[0_4px_25px_rgba(0,0,0,0.015)]">
                <h3 class="text-lg font-bold font-montserrat text-gray-900 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Accommodation & Room Rates
                </h3>
                
                <!-- Mobile Card View -->
                <div class="block md:hidden space-y-4">
                    <!-- Ground Floor Double Room (AC) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Ground Floor Double Room (AC)</h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">1 Double Bed / Max 2 Persons</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 1,500.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 3,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 6,000.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ground Floor Single Room (AC) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Ground Floor Single Room (AC)</h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">1 Single Bed / Max 1 Person</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 1,200.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 2,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 4,000.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chalet Room (Single AC) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Chalet Room (Single AC)</h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">1 Single Bed / Max 1 Person</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 1,200.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 2,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 4,000.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upper Floor Double Room (AC) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Upper Floor Double Room (AC) <span class="text-[10px] text-slate-400 font-normal ml-1">(3 Rooms)</span></h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">2 Double Beds / Max 4 Persons</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 2,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 4,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 8,000.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Driver's Room (Single Non-AC) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Driver's Room (Single Non-AC)</h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">2 Beds / Max 2 Persons</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 500.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 1,500.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 1,500.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Entire Bungalow (Per Day) -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm">
                        <div class="mb-3 border-b border-slate-200/50 pb-2">
                            <h4 class="font-bold text-slate-800 text-sm">Entire Bungalow (Per Day)</h4>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide">All Rooms / Full Access</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Ministry Staff</span>
                                <span class="font-bold text-slate-800">Rs. 10,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Other Govt / Private</span>
                                <span class="font-bold text-slate-800">Rs. 20,000.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Foreign Visitors</span>
                                <span class="font-bold text-slate-800">Rs. 35,000.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto pb-2">
                    <table class="w-full text-left text-sm text-slate-600 min-w-[600px] border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                <th class="pb-3 font-bold">Room Type</th>
                                <th class="pb-3 font-bold">Beds / Max Occupancy</th>
                                <th class="pb-3 font-bold text-right">Ministry Staff</th>
                                <th class="pb-3 font-bold text-right">Govt / Private</th>
                                <th class="pb-3 font-bold text-right">Foreign</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-[13.5px]">
                            <tr class="hover:bg-slate-50/55 transition-colors">
                                <td class="py-3.5 font-bold text-slate-800">Ground Floor Double Room (AC)</td>
                                <td class="py-3.5 text-slate-500">1 Double Bed / 2 Persons</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 1,500</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 3,000</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 6,000</td>
                            </tr>
                            <tr class="hover:bg-slate-50/55 transition-colors">
                                <td class="py-3.5 font-bold text-slate-800">Ground Floor Single Room (AC)</td>
                                <td class="py-3.5 text-slate-500">1 Single Bed / 1 Person</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 1,200</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 2,000</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 4,000</td>
                            </tr>
                            <tr class="hover:bg-slate-50/55 transition-colors">
                                <td class="py-3.5 font-bold text-slate-800">Chalet Room (Single AC)</td>
                                <td class="py-3.5 text-slate-500">1 Single Bed / 1 Person</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 1,200</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 2,000</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 4,000</td>
                            </tr>
                            <tr class="hover:bg-slate-50/55 transition-colors">
                                <td class="py-3.5 font-bold text-slate-800">Upper Floor Double Room (AC) <span class="text-[10.5px] text-slate-400 font-medium ml-1">(3 Rooms)</span></td>
                                <td class="py-3.5 text-slate-500">2 Double Beds / 4 Persons</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 2,000</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 4,000</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 8,000</td>
                            </tr>
                            <tr class="hover:bg-slate-50/55 transition-colors">
                                <td class="py-3.5 font-bold text-slate-800">Driver's Room (Single Non-AC)</td>
                                <td class="py-3.5 text-slate-500">2 Beds / 2 Persons</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 500</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 1,500</td>
                                <td class="py-3.5 text-right font-semibold text-slate-700">Rs. 1,500</td>
                            </tr>
                            <tr class="bg-slate-50/50 font-bold border-t border-slate-200">
                                <td class="py-4 font-bold text-primary">Entire Bungalow (Per Day)</td>
                                <td class="py-4 text-slate-500 font-medium">All Rooms / Full Access</td>
                                <td class="py-4 text-right font-extrabold text-primary">Rs. 10,000</td>
                                <td class="py-4 text-right font-extrabold text-primary">Rs. 20,000</td>
                                <td class="py-4 text-right font-extrabold text-primary">Rs. 35,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Driver Accommodation Info -->
                <div class="mt-6 p-4 bg-emerald-50/55 border border-emerald-100 rounded-xl flex items-start gap-3 shadow-sm">
                    <div class="shrink-0 w-6 h-6 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-[13px] font-medium font-inter text-slate-600 leading-relaxed">
                        <span class="font-bold text-slate-800">Driver Accommodation:</span> 1 room (accommodating up to 4 drivers in a group) is available <span class="font-bold text-emerald-700 bg-emerald-100/50 px-1.5 py-0.5 rounded">Free of Charge</span>.
                    </div>
                </div>

                <!-- Additional Charges -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Optional / Additional Charges
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2.5 text-[13.5px] text-slate-600 font-medium">
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Single Bed Sheet</span>
                            <span class="font-bold text-slate-800">Rs. 50</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Double Bed Sheet</span>
                            <span class="font-bold text-slate-800">Rs. 150</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Pillow Request</span>
                            <span class="font-bold text-slate-800">Rs. 75</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Towel Request</span>
                            <span class="font-bold text-slate-800">Rs. 100</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Electric Kettle</span>
                            <span class="font-bold text-slate-800">Rs. 100</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span>Kitchen Fuel (per day)</span>
                            <span class="font-bold text-slate-800">Rs. 100 - 150</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information & Manual Application -->
            <div class="mb-10 bg-white rounded-[24px] p-6 md:p-8 border border-slate-100/80 shadow-[0_4px_25px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 mb-3 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Official Bank Account Details
                    </h3>
                    <p class="text-slate-500 text-[13.5px] leading-relaxed mb-4">
                        Payments should only be deposited <strong>after</strong> receiving official approval from the Ministry.
                    </p>
                    <div class="bg-[#F8FAFC] border border-slate-100 p-4 rounded-xl space-y-2.5 text-[13.5px] text-slate-700 shadow-inner">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Beneficiary Bank</span>
                            <span class="font-bold text-slate-800">People's Bank – Narahenpita Branch</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200/50 pt-2">
                            <span class="text-slate-400">Account Number</span>
                            <span class="font-extrabold text-primary">119-1-001-59025666</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Manual Application
                    </h3>
                    <p class="text-slate-500 text-[13.5px] leading-relaxed mb-4">
                        Alternatively, you may submit a physical booking application by downloading, printing, and delivering the official document.
                    </p>
                    <a href="<?= $base_url ?>assets/docs/ampara-application.pdf" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-secondary text-secondary font-bold text-[12.5px] uppercase tracking-wide rounded-xl hover:bg-secondary/5 active:scale-95 transition-all shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF Form
                    </a>
                </div>
            </div>
        </div>

            
        <!-- Right Side: Sticky Sidebar -->
        <div class="w-full lg:w-[35%] lg:sticky lg:top-32 lg:self-start space-y-6">

            <!-- Booking Widget -->
            <div class="hidden lg:block bg-white rounded-[24px] p-6 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.03)]">
                <div class="flex items-baseline gap-1.5 mb-5">
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Starting From</span>
                    <span class="text-3xl font-extrabold text-gray-900 font-montserrat tracking-tight">Rs. 2,000</span>
                    <span class="text-slate-400 text-xs font-medium">/ night</span>
                </div>

                <hr class="border-slate-100 mb-5">

                <?php if ($success): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl mb-4 font-inter text-sm font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Your booking request has been submitted successfully and is pending approval.
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl mb-4 font-inter text-sm font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <a href="ampara-circuit-bungalow-booking"
                        class="block text-center w-full py-3.5 px-4 bg-gradient-to-r from-secondary to-[#721c1c] text-white font-bold rounded-xl hover:shadow-lg transition-all text-xs uppercase tracking-wider shadow-md">
                        Check Availability & Book
                    </a>
                </div>
                <div class="mt-4 text-center text-[11px] text-slate-400 font-medium leading-relaxed">
                    Select your dates and check room availability to submit a reservation request. Offline payments apply post-approval.
                </div>
            </div>

            <!-- Location & Contact -->
            <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.02)]">
                <h3 class="text-sm font-bold font-montserrat text-gray-900 mb-6 uppercase tracking-wider border-b border-slate-50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Location & Contact
                </h3>

                <ul class="space-y-4 text-sm text-slate-600 font-medium font-inter">
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary/5 text-secondary flex items-center justify-center border border-secondary/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-[13px] mb-0.5">Address</span>
                            <span class="text-[12px] leading-normal block">Ministry of Labour Circuit Bungalow, Ampara</span>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary/5 text-secondary flex items-center justify-center border border-secondary/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-[13px] mb-0.5">Telephone / Fax</span>
                            <span class="text-[12px] leading-normal block">+94 11 2368143</span>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary/5 text-secondary flex items-center justify-center border border-secondary/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-[13px] mb-0.5">Email Contact</span>
                            <a href="mailto:info@labour.gov.lk"
                                class="text-[12px] hover:text-secondary leading-normal block transition-colors">info@labour.gov.lk</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</section>

<!-- Booking Modal moved to footer.php to bypass containing block layout side-effects -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Make the year input more obvious in flatpickr */
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