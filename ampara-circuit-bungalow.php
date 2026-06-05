<?php
// ampara-circuit-bungalow.php
session_start();
require_once 'admin/includes/db.php';

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = '';

// Disable dates calculation removed. Availability check is now dynamic via AJAX.
$disabled_dates_json = "[]";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $applicant_name = trim($_POST['applicant_name'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $room_types = $_POST['room_type'] ?? [];
    if (!is_array($room_types)) {
        $room_types = [$room_types];
    }


    if (empty($start_date) || empty($end_date) || empty($applicant_name) || empty($telephone) || empty($email) || empty($room_types)) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $room_qtys = $_POST['room_qty'] ?? [];
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO bookings (bungalow_name, applicant_name, phone, email, room_type, no_of_rooms, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($room_types as $room_type) {
                $qty = isset($room_qtys[$room_type]) ? (int) $room_qtys[$room_type] : 1;
                if ($qty < 1)
                    $qty = 1;
                $stmt->execute(['Ampara', $applicant_name, $telephone, $email, $room_type, $qty, $start_date, $end_date]);
            }
            $pdo->commit();
            header("Location: ampara-circuit-bungalow.php?success=1");
            exit;
        } catch (PDOException $e) {
            $error = "Failed to submit booking: " . $e->getMessage();
        }
    }
}
// ampara-circuit-bungalow.php
$page_title = 'Ampara Circuit Bungalow';
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
                <div class="w-full h-[300px] md:h-[400px] lg:h-[450px] rounded-[20px] overflow-hidden mb-4">
                    <img src="assets/img/circuit-bunglalow/ampara/ampara-bungalow-1.webp" alt="Ampara Circuit Bungalow"
                        class="w-full h-full object-cover">
                </div>
                <!-- Thumbnails -->
                <div class="grid grid-cols-5 gap-2 md:gap-4">
                    <div
                        class="aspect-video md:aspect-[4/3] rounded-lg md:rounded-[12px] overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-colors">
                        <img src="assets/img/circuit-bunglalow/ampara/ampara-bungalow-2.webp" alt="Thumbnail 1"
                            class="w-full h-full object-cover">
                    </div>
                    <div
                        class="aspect-video md:aspect-[4/3] rounded-lg md:rounded-[12px] overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-colors">
                        <img src="assets/img/circuit-bunglalow/ampara/ampara-bungalow-3.webp" alt="Thumbnail 2"
                            class="w-full h-full object-cover">
                    </div>
                    <div
                        class="aspect-video md:aspect-[4/3] rounded-lg md:rounded-[12px] overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-colors">
                        <img src="assets/img/circuit-bunglalow/ampara/ampara-bungalow-4.webp" alt="Thumbnail 3"
                            class="w-full h-full object-cover">
                    </div>
                    <div
                        class="aspect-video md:aspect-[4/3] rounded-lg md:rounded-[12px] overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-colors">
                        <img src="assets/img/circuit-bunglalow/ampara/ampara-bungalow-5.webp" alt="Thumbnail 4"
                            class="w-full h-full object-cover">
                    </div>
                    <div
                        class="aspect-video md:aspect-[4/3] rounded-lg md:rounded-[12px] overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-colors relative group">
                        <img src="assets/img/circuit-bunglalow/ampara/ampara-bunglalow-6.webp" alt="Thumbnail 5"
                            class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-white font-medium text-sm">+More</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title & Rating -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <h2 class="text-2xl md:text-3xl font-semibold font-montserrat text-gray-900">Ampara Circuit Bungalow
                </h2>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="font-medium text-gray-900">4.7</span>
                </div>
            </div>

            <!-- Description -->
            <div class="text-gray-700 font-inter text-[15px] leading-relaxed space-y-4 mb-8">
                <p>
                    Ampara, a town located in the Eastern Province of Sri Lanka, is known for its beautiful landscapes,
                    wildlife, and historical sites. If you are planning a visit to Ampara, finding the right
                    accommodation is crucial for a comfortable and memorable stay.
                </p>
                <p>
                    The Ministry of Labour has established a Circuit Bungalow in Ampara to provide accommodation
                    facilities for its officers. It is primarily meant for the officers of the Department of Labour, but
                    if available, other public officers and even the general public may be allowed to book it.
                </p>
                <p>
                    The bungalow usually provides basic amenities such as furnished rooms, attached bathrooms, and a
                    common dining area. Meals may be provided upon request, or there might be facilities for guests to
                    cook their own meals. The specific facilities can vary, so it's advisable to inquire when making a
                    reservation.
                </p>
                <p>
                    <a href="https://maps.app.goo.gl/LNeQQ3s4E5vq4AD98" target="_blank"
                        class="text-secondary hover:underline font-medium inline-flex items-center gap-2">
                        The location is highly accessible.
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </p>
            </div>

            <!-- Booking Widget (Mobile Only) -->
            <div class="block lg:hidden bg-[#FAFAFA] rounded-[20px] p-6 border-[0.5px] border-[#D4D4D4] shadow-sm mb-8">
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-gray-500 text-sm font-medium font-inter">From</span>
                    <span class="text-3xl font-bold text-gray-900 font-montserrat">Rs. 2,000</span>
                    <span class="text-gray-500 text-sm font-inter">/ night</span>
                </div>

                <hr class="border-gray-200 mb-6">

                <?php if ($success): ?>
                    <div
                        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4 font-inter text-sm">
                        Your booking request has been submitted successfully and is pending approval.
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4 font-inter text-sm">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <button type="button"
                        onclick="openBookingModal()"
                        class="w-full py-3 px-4 bg-[#4E0000] hover:bg-[#320000] text-white font-semibold rounded-lg transition-colors text-sm font-inter shadow-md">
                        Check Availability & Book
                    </button>
                </div>
                <div class="mt-5 text-center text-[12px] text-gray-500 font-inter leading-relaxed">
                    Select your dates and provide your details to request a reservation. Subject to approval by the
                    administration.
                </div>
            </div>

            <!-- Amenities & Facilities -->
            <div class="mb-8 bg-[#FAFAFA] rounded-[20px] p-6 md:p-8 border-[0.5px] border-[#D4D4D4]">
                <h3 class="text-2xl font-semibold font-montserrat text-gray-900 mb-6 pb-4 border-b border-[#D4D4D4]">
                    Amenities & Facilities</h3>
                <div class="flex flex-wrap gap-3">
                    <?php
                    $amenities = [
                        'Air Conditioning',
                        'Parking',
                        'Hot Water',
                        'Kitchen',
                        'Garden',
                        'Security',
                        'Generator Backup',
                        'Outdoor Seating'
                    ];
                    foreach ($amenities as $amenity) {
                        echo '<span class="px-4 py-2.5 bg-[#EAE5E5] text-[#2D2D2D] text-[13px] font-medium rounded-[8px]">' . $amenity . '</span>';
                    }
                    ?>
                </div>
            </div>

            <!-- Room Types & Pricing -->
            <div class="mb-10 bg-[#FAFAFA] rounded-[20px] p-5 sm:p-6 md:p-8 border-[0.5px] border-[#D4D4D4]">
                <h3
                    class="text-xl md:text-2xl font-semibold font-montserrat text-gray-900 mb-5 md:mb-6 pb-4 border-b border-[#D4D4D4]">
                    Room Types & Pricing</h3>
                <div class="space-y-4">

                    <!-- Room 1 -->
                    <div
                        class="bg-white rounded-[16px] p-5 md:p-6 border-[0.5px] border-[#D4D4D4] flex flex-col md:flex-row justify-between md:items-start gap-4 md:gap-6 hover:shadow-sm transition-shadow">
                        <div class="flex-1">
                            <h4 class="text-base md:text-[18px] font-medium text-gray-900 mb-2 font-montserrat">Double
                                A/C Room</h4>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full mb-4 md:mb-6 font-inter">Double
                                Room</span>
                            <div
                                class="flex flex-col md:flex-row gap-3 md:gap-8 text-xs md:text-[13px] text-gray-800 font-inter">
                                <div class="flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <span>Up to 2 guests</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Comfortable air conditioned double room ideal for couples or solo
                                        travellers.</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-left md:text-right shrink-0 flex flex-col md:items-end">
                            <div class="text-base md:text-[18px] font-medium text-gray-900 font-montserrat mb-0.5">Rs.
                                2,000</div>
                            <div class="text-[10px] md:text-[11px] text-gray-400 font-inter mb-2">per night</div>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full font-inter w-fit">Available</span>
                        </div>
                    </div>

                    <!-- Room 2 -->
                    <div
                        class="bg-white rounded-[16px] p-5 md:p-6 border-[0.5px] border-[#D4D4D4] flex flex-col md:flex-row justify-between md:items-start gap-4 md:gap-6 hover:shadow-sm transition-shadow">
                        <div class="flex-1">
                            <h4 class="text-base md:text-[18px] font-medium text-gray-900 mb-2 font-montserrat">Triple
                                A/C Room</h4>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full mb-4 md:mb-6 font-inter">Triple
                                Room</span>
                            <div
                                class="flex flex-col md:flex-row gap-3 md:gap-8 text-xs md:text-[13px] text-gray-800 font-inter">
                                <div class="flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <span>Up to 3 guests</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Air conditioned triple room suitable for families or small groups.</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-left md:text-right shrink-0 flex flex-col md:items-end">
                            <div class="text-base md:text-[18px] font-medium text-gray-900 font-montserrat mb-0.5">Rs.
                                3,500</div>
                            <div class="text-[10px] md:text-[11px] text-gray-400 font-inter mb-2">per night</div>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full font-inter w-fit">Available</span>
                        </div>
                    </div>

                    <!-- Room 3 -->
                    <div
                        class="bg-white rounded-[16px] p-5 md:p-6 border-[0.5px] border-[#D4D4D4] flex flex-col md:flex-row justify-between md:items-start gap-4 md:gap-6 hover:shadow-sm transition-shadow">
                        <div class="flex-1">
                            <h4 class="text-base md:text-[18px] font-medium text-gray-900 mb-2 font-montserrat">VIP Room
                            </h4>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full mb-4 md:mb-6 font-inter">Suite</span>
                            <div
                                class="flex flex-col md:flex-row gap-3 md:gap-8 text-xs md:text-[13px] text-gray-800 font-inter">
                                <div class="flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <span>Up to 2 guests</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Available for Staff Grade Officers and Public Representatives of All Island
                                        Services. Air conditioned with premium furnishings.</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-left md:text-right shrink-0 flex flex-col md:items-end">
                            <div class="text-base md:text-[18px] font-medium text-gray-900 font-montserrat mb-0.5">Rs.
                                4,500</div>
                            <div class="text-[10px] md:text-[11px] text-gray-400 font-inter mb-2">per night</div>
                            <span
                                class="inline-block px-3 py-1 bg-[#DDF1EC] text-[#42937A] text-[10px] md:text-[11px] font-medium rounded-full font-inter w-fit">Available</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Accommodation & Room Rates -->
            <div class="mb-10 bg-[#FAFAFA] rounded-[20px] p-5 sm:p-6 md:p-8 border-[0.5px] border-[#D4D4D4]">
                <h3 class="text-xl font-semibold font-montserrat text-gray-900 mb-5 md:mb-6">Accommodation & Room Rates
                </h3>
                <!-- Mobile Card View -->
                <div class="block md:hidden space-y-4">
                    <!-- VIP Room Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-medium text-gray-900">VIP Room <span
                                    class="ml-1 text-[10px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                            </h4>
                            <div class="text-right font-semibold text-gray-900">4,500.00 <span
                                    class="text-[11px] text-gray-500 block font-normal">Rs. / Room</span></div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[13px] text-gray-600 border-t border-gray-100 pt-3">
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">No. of Rooms</span>
                                <span class="font-medium text-gray-800">01</span>
                            </div>
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">Max Occupancy</span>
                                <span class="font-medium text-gray-800">2 Persons</span>
                            </div>
                        </div>
                    </div>
                    <!-- A/C Triple Room Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-medium text-gray-900">A/C Triple Room <span
                                    class="ml-1 text-[10px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                            </h4>
                            <div class="text-right font-semibold text-gray-900">3,500.00 <span
                                    class="text-[11px] text-gray-500 block font-normal">Rs. / Room</span></div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[13px] text-gray-600 border-t border-gray-100 pt-3">
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">No. of Rooms</span>
                                <span class="font-medium text-gray-800">04</span>
                            </div>
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">Max Occupancy</span>
                                <span class="font-medium text-gray-800">3 Persons</span>
                            </div>
                        </div>
                    </div>
                    <!-- A/C Double Room Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-medium text-gray-900">A/C Double Room <span
                                    class="ml-1 text-[10px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                            </h4>
                            <div class="text-right font-semibold text-gray-900">2,000.00 <span
                                    class="text-[11px] text-gray-500 block font-normal">Rs. / Room</span></div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[13px] text-gray-600 border-t border-gray-100 pt-3">
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">No. of Rooms</span>
                                <span class="font-medium text-gray-800">01</span>
                            </div>
                            <div>
                                <span class="block text-[11px] text-gray-400 mb-0.5">Max Occupancy</span>
                                <span class="font-medium text-gray-800">2 Persons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto pb-2">
                    <table class="w-full text-left text-xs sm:text-sm text-gray-600 min-w-[500px]">
                        <thead class="bg-primary text-white font-medium rounded-t-lg">
                            <tr>
                                <th class="px-3 md:px-4 py-2.5 md:py-3 rounded-tl-lg font-medium whitespace-nowrap">Room
                                    Type</th>
                                <th class="px-3 md:px-4 py-2.5 md:py-3 font-medium whitespace-nowrap">No. of Rooms</th>
                                <th class="px-3 md:px-4 py-2.5 md:py-3 font-medium whitespace-nowrap">Max Occupancy</th>
                                <th
                                    class="px-3 md:px-4 py-2.5 md:py-3 rounded-tr-lg text-right font-medium whitespace-nowrap">
                                    Rate per Room (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr>
                                <td class="px-3 md:px-4 py-3 md:py-4 font-medium text-gray-900 whitespace-nowrap">VIP
                                    Room <span
                                        class="ml-1 text-[10px] md:text-[11px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                                </td>
                                <td class="px-3 md:px-4 py-3 md:py-4">01</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 whitespace-nowrap">2 Persons</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 text-right">4,500.00</td>
                            </tr>
                            <tr>
                                <td class="px-3 md:px-4 py-3 md:py-4 font-medium text-gray-900 whitespace-nowrap">A/C
                                    Triple Room <span
                                        class="ml-1 text-[10px] md:text-[11px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                                </td>
                                <td class="px-3 md:px-4 py-3 md:py-4">04</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 whitespace-nowrap">3 Persons</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 text-right">3,500.00</td>
                            </tr>
                            <tr>
                                <td class="px-3 md:px-4 py-3 md:py-4 font-medium text-gray-900 whitespace-nowrap">A/C
                                    Double Room <span
                                        class="ml-1 text-[10px] md:text-[11px] bg-[#E1F0FF] text-[#0058B9] px-2 py-0.5 rounded-full font-normal">A/C</span>
                                </td>
                                <td class="px-3 md:px-4 py-3 md:py-4">01</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 whitespace-nowrap">2 Persons</td>
                                <td class="px-3 md:px-4 py-3 md:py-4 text-right">2,000.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Driver Accommodation Info -->
                <div class="mt-6 p-4 bg-green-50/70 border border-green-200/80 rounded-[12px] flex items-start gap-3">
                    <div
                        class="shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-700 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="text-[13.5px] md:text-sm font-inter text-gray-700 leading-relaxed">
                        <span class="font-semibold text-gray-900">Driver Accommodation:</span> 1 room (accommodating up
                        to 4 persons in a group) is available <span class="font-semibold text-green-700">Free of
                            Charge</span>.
                    </div>
                </div>

                <!-- VIP Room Policy -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold font-inter text-gray-900 mb-3">VIP Room Policy:</h4>
                    <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600 font-inter">
                        <li>VIP room will be strictly reserved for Staff Grade Officers in Public Institutions.</li>
                        <li>The person making the reservation should present at the check in time and the stay is not
                            permitted for his/her friends/relatives/visitors.</li>
                    </ul>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="mb-10 bg-[#FAFAFA] rounded-[20px] p-6 md:p-8 border-[0.5px] border-[#D4D4D4]">
                <h3 class="text-xl font-semibold font-montserrat text-gray-900 mb-4">Payment Information</h3>
                <p class="text-gray-600 text-sm mb-4 font-inter">Payments are to be credited as below.</p>
                <div class="space-y-2 text-sm text-gray-700 font-inter">
                    <p><span class="font-medium text-gray-900">Bank:</span> Bank of Ceylon</p>
                    <p><span class="font-medium text-gray-900">Account Number:</span> 00014167</p>
                    <p><span class="font-medium text-gray-900">Account Name:</span> Chief Secretary, Eastern Province
                    </p>
                </div>
            </div>

            <!-- Guest Reviews -->
            <div class="hidden md:block bg-[#FAFAFA] rounded-[20px] p-6 md:p-8 border-[0.5px] border-[#D4D4D4]">
                <h3 class="text-2xl md:text-3xl font-bold font-montserrat text-gray-900 mb-4">Guest Reviews</h3>
                <hr class="border-[#E5E7EB] mb-6">

                <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-8">
                    <!-- Rating Summary -->
                    <div
                        class="bg-secondary text-white rounded-[16px] p-6 w-[160px] shrink-0 text-center flex flex-col items-center justify-center shadow-md">
                        <div class="text-5xl font-semibold mb-2 font-montserrat">4.7</div>
                        <div class="flex justify-center text-yellow-500 mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div class="text-[13px] opacity-80 font-inter font-light">10 reviews</div>
                    </div>

                    <!-- Rating Bars -->
                    <div class="flex-1 w-full space-y-3 pt-1">
                        <!-- Bar 5 -->
                        <div class="flex items-center text-[15px] font-inter">
                            <span class="w-3 font-medium text-gray-800">5</span>
                            <svg class="w-4 h-4 text-yellow-500 mx-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div
                                class="w-full bg-transparent border border-gray-200 rounded-[2px] h-2.5 mx-3 overflow-hidden flex">
                                <div class="bg-primary h-full" style="width: 60%"></div>
                            </div>
                            <span class="w-4 text-right text-gray-800">6</span>
                        </div>
                        <!-- Bar 4 -->
                        <div class="flex items-center text-[15px] font-inter">
                            <span class="w-3 font-medium text-gray-800">4</span>
                            <svg class="w-4 h-4 text-yellow-500 mx-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div
                                class="w-full bg-transparent border border-gray-200 rounded-[2px] h-2.5 mx-3 overflow-hidden flex">
                                <div class="bg-primary h-full" style="width: 40%"></div>
                            </div>
                            <span class="w-4 text-right text-gray-800">4</span>
                        </div>
                        <!-- Bar 3 -->
                        <div class="flex items-center text-[15px] font-inter">
                            <span class="w-3 font-medium text-gray-800">3</span>
                            <svg class="w-4 h-4 text-yellow-500 mx-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div
                                class="w-full bg-transparent border border-gray-200 rounded-[2px] h-2.5 mx-3 overflow-hidden flex">
                                <div class="bg-primary h-full" style="width: 0%"></div>
                            </div>
                            <span class="w-4 text-right text-gray-800">0</span>
                        </div>
                        <!-- Bar 2 -->
                        <div class="flex items-center text-[15px] font-inter">
                            <span class="w-3 font-medium text-gray-800">2</span>
                            <svg class="w-4 h-4 text-yellow-500 mx-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div
                                class="w-full bg-transparent border border-gray-200 rounded-[2px] h-2.5 mx-3 overflow-hidden flex">
                                <div class="bg-primary h-full" style="width: 0%"></div>
                            </div>
                            <span class="w-4 text-right text-gray-800">0</span>
                        </div>
                        <!-- Bar 1 -->
                        <div class="flex items-center text-[15px] font-inter">
                            <span class="w-3 font-medium text-gray-800">1</span>
                            <svg class="w-4 h-4 text-yellow-500 mx-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div
                                class="w-full bg-transparent border border-gray-200 rounded-[2px] h-2.5 mx-3 overflow-hidden flex">
                                <div class="bg-primary h-full" style="width: 0%"></div>
                            </div>
                            <span class="w-4 text-right text-gray-800">0</span>
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="space-y-4">
                    <!-- Review 1 -->
                    <div class="bg-white p-5 md:p-6 rounded-[12px] border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-medium text-sm shrink-0">
                                    KA</div>
                                <div>
                                    <div class="font-medium text-gray-900 text-[15px] font-inter">K. A. Perera</div>
                                    <div class="text-[13px] text-gray-500 font-inter mt-0.5">Department of Finance</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5">
                                <div class="flex text-yellow-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div class="text-[12px] text-gray-500 font-inter">Nov 15, 2025</div>
                            </div>
                        </div>
                        <p class="text-[14.5px] text-gray-800 font-inter leading-relaxed">Excellent facilities and very
                            peaceful environment. The caretaker was extremely helpful and the rooms were spotlessly
                            clean. Highly recommend for family holidays.</p>
                    </div>

                    <!-- Review 2 -->
                    <div class="bg-white p-5 md:p-6 rounded-[12px] border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-medium text-sm shrink-0">
                                    HM</div>
                                <div>
                                    <div class="font-medium text-gray-900 text-[15px] font-inter">H. M. Silva</div>
                                    <div class="text-[13px] text-gray-500 font-inter mt-0.5">Provincial Administration
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5">
                                <div class="flex text-yellow-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div class="text-[12px] text-gray-500 font-inter">Oct 3, 2025</div>
                            </div>
                        </div>
                        <p class="text-[14.5px] text-gray-800 font-inter leading-relaxed">Great location with beautiful
                            gardens. The amenities were well maintained and the check-in process was smooth. Would
                            definitely visit again.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Side: Sticky Sidebar -->
        <div class="w-full lg:w-[35%] lg:sticky lg:top-32 lg:self-start space-y-6">

            <!-- Booking Widget -->
            <div class="hidden lg:block bg-[#FAFAFA] rounded-[20px] p-6 border-[0.5px] border-[#D4D4D4] shadow-sm">
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-gray-500 text-sm font-medium font-inter">From</span>
                    <span class="text-3xl font-bold text-gray-900 font-montserrat">Rs. 2,000</span>
                    <span class="text-gray-500 text-sm font-inter">/ night</span>
                </div>

                <hr class="border-gray-200 mb-6">

                <?php if ($success): ?>
                    <div
                        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4 font-inter text-sm">
                        Your booking request has been submitted successfully and is pending approval.
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4 font-inter text-sm">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <button type="button"
                        onclick="openBookingModal()"
                        class="w-full py-3 px-4 bg-[#4E0000] hover:bg-[#320000] text-white font-semibold rounded-lg transition-colors text-sm font-inter shadow-md">
                        Check Availability & Book
                    </button>
                </div>
                <div class="mt-5 text-center text-[12px] text-gray-500 font-inter leading-relaxed">
                    Select your dates and provide your details to request a reservation. Subject to approval by the
                    administration.
                </div>
            </div>

            <!-- Location & Contact -->
            <div class="bg-[#FAFAFA] rounded-[20px] p-6 border-[0.5px] border-[#D4D4D4] shadow-sm">
                <h3 class="text-lg font-semibold font-montserrat text-gray-900 mb-6">Location & Contact</h3>

                <ul class="space-y-4 text-sm text-gray-700 font-inter">
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="pt-1">
                            <span class="block font-semibold text-gray-900 mb-0.5 text-sm">Address</span>
                            <span class="text-[13px]">Ministry of Labour Circuit Bungalow, Ampara</span>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="pt-1">
                            <span class="block font-semibold text-gray-900 mb-0.5 text-sm">Telephone / Fax</span>
                            <span class="text-[13px]">+94 11 2368143</span>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <div
                            class="shrink-0 w-8 h-8 rounded-lg bg-secondary text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="pt-1">
                            <span class="block font-semibold text-gray-900 mb-0.5 text-sm">Email</span>
                            <a href="mailto:info@labour.gov.lk"
                                class="text-[13px] hover:text-secondary transition-colors">info@labour.gov.lk</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</section>

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 transition-all duration-300 bg-transparent">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out border border-gray-100" id="booking-modal-card">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-[#FAFAFA]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#4E0000]/10 flex items-center justify-center text-[#4E0000]">
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
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4E0000]/20 focus:border-[#4E0000] bg-white font-inter transition-all"
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
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4E0000]/20 focus:border-[#4E0000] bg-white font-inter transition-all"
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
                                class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4E0000]/20 focus:border-[#4E0000] bg-white font-inter transition-all"
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
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4E0000]/20 focus:border-[#4E0000] bg-white font-inter transition-all"
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
                                    class="w-full border border-gray-300 rounded-lg py-2.5 pl-9 pr-3 text-[13px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4E0000]/20 focus:border-[#4E0000] bg-white font-inter transition-all"
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
                    class="px-6 py-2.5 text-[13px] font-bold text-white bg-[#4E0000] hover:bg-[#3d0000] rounded-xl active:scale-95 transition-all font-inter shadow-md shadow-red-950/10 focus:outline-none">Submit Booking Request</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        const disabledDates = <?= $disabled_dates_json ?>;

        window.openBookingModal = function() {
            const modal = document.getElementById('booking-modal');
            const card = document.getElementById('booking-modal-card');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('bg-transparent');
                modal.classList.add('bg-black/40', 'backdrop-blur-md');
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        };

        window.closeBookingModal = function() {
            const modal = document.getElementById('booking-modal');
            const card = document.getElementById('booking-modal-card');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('bg-black/40', 'backdrop-blur-md');
            modal.classList.add('bg-transparent');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        };

        const checkInInput = document.getElementById('modal-check-in');
        const checkOutInput = document.getElementById('modal-check-out');
        const roomContainer = document.getElementById('room_type_container');
        const roomMsg = document.getElementById('room-availability-msg');
        const submitBtn = document.querySelector('#booking-form button[type="submit"]');

        function checkAvailability() {
            const start = checkInInput.value;
            const end = checkOutInput.value;

            if (start && end) {
                roomContainer.innerHTML = '<p class="text-[13px] text-gray-500 font-inter m-0">Checking availability...</p>';
                roomMsg.classList.add('hidden');
                roomMsg.classList.remove('flex');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                fetch(`check-room-availability.php?start=${start}&end=${end}`)
                    .then(res => res.json())
                    .then(data => {
                        roomContainer.innerHTML = '';
                        if (data.success && data.available_rooms.length > 0) {
                            data.available_rooms.forEach(room => {
                                const wrapper = document.createElement('div');
                                wrapper.className = 'relative';

                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.name = 'room_type[]';
                                checkbox.value = room.value;
                                checkbox.id = 'room_' + room.value.replace(/[\s\/]+/g, '_');
                                checkbox.className = 'peer sr-only';

                                let qtyWrapper = null;
                                const label = document.createElement('label');
                                label.htmlFor = checkbox.id;
                                label.className = 'flex items-center justify-between w-full p-3 text-gray-700 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-[#4E0000] peer-checked:bg-red-50 hover:bg-gray-50 peer-disabled:opacity-50 peer-disabled:cursor-not-allowed transition-all shadow-sm';

                                const span = document.createElement('span');
                                span.className = 'text-[13px] font-medium font-inter pr-2';
                                span.textContent = room.label;
                                label.appendChild(span);

                                if (room.max_available > 1) {
                                    qtyWrapper = document.createElement('div');
                                    qtyWrapper.className = 'relative z-10 flex items-center gap-1.5 ml-auto mr-6 opacity-0 pointer-events-none transition-opacity duration-200 bg-gray-100/80 border border-gray-250/75 rounded-[10px] p-0.5 shadow-sm';
                                    
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = `room_qty[${room.value}]`;
                                    hiddenInput.value = '1';
                                    qtyWrapper.appendChild(hiddenInput);

                                    const btnMinus = document.createElement('button');
                                    btnMinus.type = 'button';
                                    btnMinus.className = 'w-5 h-5 rounded-md bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 flex items-center justify-center font-bold text-xs select-none active:scale-90 transition-all focus:outline-none';
                                    btnMinus.textContent = '−';
                                    
                                    const qtyVal = document.createElement('span');
                                    qtyVal.className = 'w-5 text-center text-[12px] font-bold font-inter text-gray-800 select-none';
                                    qtyVal.textContent = '1';

                                    const btnPlus = document.createElement('button');
                                    btnPlus.type = 'button';
                                    btnPlus.className = 'w-5 h-5 rounded-md bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 flex items-center justify-center font-bold text-xs select-none active:scale-90 transition-all focus:outline-none';
                                    btnPlus.textContent = '+';

                                    btnMinus.addEventListener('click', e => {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        let val = parseInt(hiddenInput.value) || 1;
                                        if (val > 1) {
                                            val--;
                                            hiddenInput.value = val;
                                            qtyVal.textContent = val;
                                        }
                                    });
                                    btnMinus.addEventListener('mousedown', e => e.stopPropagation());

                                    btnPlus.addEventListener('click', e => {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        let val = parseInt(hiddenInput.value) || 1;
                                        if (val < room.max_available) {
                                            val++;
                                            hiddenInput.value = val;
                                            qtyVal.textContent = val;
                                        }
                                    });
                                    btnPlus.addEventListener('mousedown', e => e.stopPropagation());

                                    qtyWrapper.appendChild(btnMinus);
                                    qtyWrapper.appendChild(qtyVal);
                                    qtyWrapper.appendChild(btnPlus);
                                    label.appendChild(qtyWrapper);
                                }

                                checkbox.addEventListener('change', function () {
                                    if (qtyWrapper) {
                                        if (this.checked) {
                                            qtyWrapper.classList.remove('opacity-0', 'pointer-events-none');
                                        } else {
                                            qtyWrapper.classList.add('opacity-0', 'pointer-events-none');
                                        }
                                    }

                                    if (this.value === 'Entire Bungalow' && this.checked) {
                                        document.querySelectorAll('input[name="room_type[]"]').forEach(cb => {
                                            if (cb !== this) {
                                                cb.checked = false;
                                                cb.disabled = true;
                                                cb.dispatchEvent(new Event('change'));
                                            }
                                        });
                                    } else if (this.value === 'Entire Bungalow' && !this.checked) {
                                        document.querySelectorAll('input[name="room_type[]"]').forEach(cb => {
                                            cb.disabled = false;
                                        });
                                    } else if (this.checked) {
                                        const entireCb = document.getElementById('room_Entire_Bungalow');
                                        if (entireCb) {
                                            entireCb.checked = false;
                                            entireCb.disabled = true;
                                            entireCb.dispatchEvent(new Event('change'));
                                        }
                                    } else {
                                        const anyChecked = Array.from(document.querySelectorAll('input[name="room_type[]"]'))
                                            .some(cb => cb.checked && cb.value !== 'Entire Bungalow');
                                        if (!anyChecked) {
                                            const entireCb = document.getElementById('room_Entire_Bungalow');
                                            if (entireCb) entireCb.disabled = false;
                                        }
                                    }
                                });

                                const iconHtml = `
                                <svg class="w-4 h-4 text-[#4E0000] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            `;

                                wrapper.appendChild(checkbox);
                                wrapper.appendChild(label);
                                wrapper.insertAdjacentHTML('beforeend', iconHtml);
                                roomContainer.appendChild(wrapper);
                            });

                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            roomContainer.innerHTML = '<p class="text-[13px] text-gray-500 font-inter m-0">No rooms available</p>';
                            roomMsg.textContent = data.message || 'No rooms available for selected dates.';
                            roomMsg.classList.remove('hidden');
                            roomMsg.classList.add('flex');
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    })
                    .catch(err => {
                        roomContainer.innerHTML = '<p class="text-[13px] text-red-500 font-inter m-0">Error checking availability</p>';
                        roomMsg.textContent = 'Network error. Please try again.';
                        roomMsg.classList.remove('hidden');
                        roomMsg.classList.add('flex');
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    });
            }
        }

        // Flatpickr for Check-In
        const checkInPicker = flatpickr("#modal-check-in", {
            minDate: "today",
            disable: disabledDates,
            dateFormat: "Y-m-d",
            allowInput: true,
            monthSelectorType: "dropdown",
            onChange: function (selectedDates, dateStr, instance) {
                // Set min check-out date to check-in + 1 day
                if (selectedDates.length > 0) {
                    let minOut = new Date(selectedDates[0]);
                    minOut.setDate(minOut.getDate() + 1);
                    checkOutPicker.set('minDate', minOut);

                    // If checkOut date is now invalid, clear it
                    if (checkOutPicker.selectedDates.length > 0 && checkOutPicker.selectedDates[0] <= selectedDates[0]) {
                        checkOutPicker.clear();
                    }
                }
                checkAvailability();
            }
        });

        // Flatpickr for Check-Out
        const checkOutPicker = flatpickr("#modal-check-out", {
            minDate: new Date().fp_incr(1), // Tomorrow
            disable: disabledDates,
            dateFormat: "Y-m-d",
            allowInput: true,
            monthSelectorType: "dropdown",
            onChange: function () {
                checkAvailability();
            }
        });

        // Form validation before submit
        document.getElementById('booking-form').addEventListener('submit', function (e) {
            const checkedRooms = document.querySelectorAll('input[name="room_type[]"]:checked');
            if (checkedRooms.length === 0 && !submitBtn.disabled) {
                e.preventDefault();
                roomMsg.textContent = 'Please select at least one option.';
                roomMsg.classList.remove('hidden');
            }
        });
    });
</script>
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