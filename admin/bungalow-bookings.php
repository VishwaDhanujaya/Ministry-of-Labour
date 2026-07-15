<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle status updates
if (isset($_GET['action']) && isset($_GET['id'])) {
    requireCsrfToken('GET', 'get');
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    $new_status = '';

    if ($action === 'approve') {
        $new_status = 'Confirmed';
    } elseif ($action === 'reject') {
        $new_status = 'Cancelled';
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: bungalow-bookings");
        exit;
    }

    if ($new_status) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);

        // Send Email Notification (Disabled as per manual payment process requirements)
        /*
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        $booking = $stmt->fetch();
        
        if ($booking && !empty($booking['email'])) {
            require_once __DIR__ . '/../includes/Mailer.php';
            
            $subject = "";
            $textBody = "";
            
            if ($new_status === 'Confirmed') {
                $subject = "Your Bungalow Booking is Confirmed - Ministry of Labour";
                $textBody = "Dear {$booking['applicant_name']},\n\nYour booking request for {$booking['bungalow_name']} Bungalow has been CONFIRMED.\n\nDetails:\nBungalow: {$booking['bungalow_name']}\nRoom Type: {$booking['room_type']}\nCheck-in: {$booking['start_date']}\nCheck-out: {$booking['end_date']}\n\nThank you,\nMinistry of Labour";
            } elseif ($new_status === 'Cancelled') {
                $subject = "Your Bungalow Booking has been Cancelled - Ministry of Labour";
                $textBody = "Dear {$booking['applicant_name']},\n\nWe regret to inform you that your booking request for {$booking['bungalow_name']} Bungalow has been CANCELLED.\n\nDetails:\nBungalow: {$booking['bungalow_name']}\nRoom Type: {$booking['room_type']}\nCheck-in: {$booking['start_date']}\nCheck-out: {$booking['end_date']}\n\nIf you have any questions, please contact us.\n\nThank you,\nMinistry of Labour";
            }
            
            if (!empty($subject)) {
                \App\Utilities\Mailer::sendEmail(
                    $booking['email'],
                    $subject,
                    nl2br($textBody),
                    $textBody
                );
            }
        }
        */

        header("Location: bungalow-bookings");
        exit;
    }
}

// Fetch stats
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pendingBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();
$confirmedBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Confirmed'")->fetchColumn();
$cancelledBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Cancelled'")->fetchColumn();

// Fetch bookings
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
$bookings = $stmt->fetchAll();

// --- Calendar Logic ---

// Full Calendar (Current Month or Requested Month)
$monthParam = $_GET['month'] ?? date('Y-m');
try {
    $firstDayOfMonth = new DateTime($monthParam . '-01');
} catch (Exception $e) {
    $firstDayOfMonth = new DateTime('first day of this month');
}

$prevMonth = (clone $firstDayOfMonth)->modify('-1 month')->format('Y-m');
$nextMonth = (clone $firstDayOfMonth)->modify('+1 month')->format('Y-m');

$lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
$daysInMonth = (int)$lastDayOfMonth->format('t');
$startDayOfWeek = (int)$firstDayOfMonth->format('w'); // 0 (Sun) to 6 (Sat)
$monthName = $firstDayOfMonth->format('F Y');

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE status IN ('Confirmed', 'Pending')");
$stmt->execute();
$allBookings = $stmt->fetchAll();

$bookedDates = [];
foreach ($allBookings as $b) {
    $periodStart = new DateTime($b['start_date']);
    $periodEnd = new DateTime($b['end_date']);
    $interval = new DateInterval('P1D');
    
    // Create period (excludes end_date, which is correct for nights)
    $period = new DatePeriod($periodStart, $interval, $periodEnd);
    foreach ($period as $dt) {
        $dateStr = $dt->format('Y-m-d');
        if (!isset($bookedDates[$dateStr])) {
            $bookedDates[$dateStr] = [];
        }
        $bMapped = $b;
        $bMapped['room'] = ($b['room_type'] ?? 'Room') . (isset($b['no_of_rooms']) && $b['no_of_rooms'] > 1 ? ' (x' . $b['no_of_rooms'] . ')' : '');
        $bMapped['name'] = $b['applicant_name'];
        $bookedDates[$dateStr][] = $bMapped;
    }
}

function getDayOccupancy(array $dayBookings) {
    $capacities = [
        'Ground Floor Double Room (AC)' => 1,
        'Ground Floor Single Room (AC)' => 1,
        'Chalet Room (Single AC)' => 1,
        'Upper Floor Double Room (AC)' => 3,
        'Driver\'s Room (Single Non-AC)' => 1
    ];
    $booked = [
        'Ground Floor Double Room (AC)' => 0,
        'Ground Floor Single Room (AC)' => 0,
        'Chalet Room (Single AC)' => 0,
        'Upper Floor Double Room (AC)' => 0,
        'Driver\'s Room (Single Non-AC)' => 0
    ];
    $entireBungalowBooked = false;
    $bookingsList = [];

    foreach ($dayBookings as $b) {
        $roomStr = $b['room'];
        $status = $b['status'];
        
        if (strpos($roomStr, 'Entire Bungalow') !== false) {
            if ($status === 'Confirmed') {
                $entireBungalowBooked = true;
            }
            $bookingsList[] = [
                'id' => $b['id'] ?? 0,
                'name' => $b['name'],
                'room' => 'Entire Bungalow',
                'qty' => 1,
                'status' => $status
            ];
        } else {
            $parts = explode(', ', $roomStr);
            foreach ($parts as $part) {
                $qty = 1;
                $cleanRoom = $part;
                if (preg_match('/^(.*?)\s*\(x(\d+)\)$/', $part, $matches)) {
                    $cleanRoom = trim($matches[1]);
                    $qty = (int)$matches[2];
                }
                
                if ($status === 'Confirmed') {
                    if (isset($booked[$cleanRoom])) {
                        $booked[$cleanRoom] += $qty;
                    }
                }
                $bookingsList[] = [
                    'id' => $b['id'] ?? 0,
                    'name' => $b['name'],
                    'room' => $cleanRoom,
                    'qty' => $qty,
                    'status' => $status
                ];
            }
        }
    }

    if ($entireBungalowBooked) {
        $availableCount = 0;
        $bookedDetails = ['Entire Bungalow' => 1];
    } else {
        $availableCount = 0;
        $bookedDetails = [];
        foreach ($capacities as $room => $cap) {
            $bookedQty = $booked[$room] ?? 0;
            if ($bookedQty > $cap) $bookedQty = $cap;
            $avail = $cap - $bookedQty;
            $availableCount += $avail;
            if ($bookedQty > 0) {
                $bookedDetails[$room] = $bookedQty;
            }
        }
    }

    return [
        'available_count' => $availableCount,
        'booked_details' => $bookedDetails,
        'bookings_list' => $bookingsList
    ];
}

function getEstimatedCost($category, $roomTypeStr, $nights, $entireBungalow = 0) {
    $category = trim($category);
    $nights = (int)$nights;
    if ($nights <= 0) $nights = 1;
    
    $tier = 2; // Default: Local Citizens / Private
    if (stripos($category, 'Ministry of Labour') !== false || stripos($category, 'MOL') !== false) {
        $tier = 1;
    } elseif (stripos($category, 'Foreign') !== false) {
        $tier = 3;
    }
    
    if ($entireBungalow || stripos($roomTypeStr, 'Entire Bungalow') !== false) {
        $rates = [1 => 5000, 2 => 10000, 3 => 25000];
        return $rates[$tier] * $nights;
    }
    
    $rates = [1 => 1000, 2 => 2000, 3 => 5000];
    $baseRate = $rates[$tier];
    
    $totalRoomsCount = 0;
    $parts = explode(',', $roomTypeStr);
    foreach ($parts as $part) {
        $part = trim($part);
        if (empty($part)) continue;
        
        $qty = 1;
        if (preg_match('/\(x(\d+)\)/i', $part, $matches)) {
            $qty = (int)$matches[1];
        }
        $totalRoomsCount += $qty;
    }
    
    if ($totalRoomsCount <= 0) {
        $totalRoomsCount = 1;
    }
    
    return $baseRate * $totalRoomsCount * $nights;
}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-slate-50 relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Custom Styles for Premium UI & Micro-animations -->
        <style>
            .summary-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .summary-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.08);
            }
            .booking-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .booking-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            }
            .js-tab-filter {
                transition: all 0.2s ease;
            }
            .js-day-cell {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .js-day-cell:hover {
                z-index: 50 !important;
            }
            .js-day-cell:hover:not(.bg-\[\#13273F\]) {
                background-color: #F1F5F9;
                transform: scale(1.03);
            }
            .js-bungalow-filter {
                padding-right: 2.5rem !important;
                padding-left: 2.5rem !important;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
            /* Smooth Modal Animations */
            #viewModal.flex {
                animation: fadeIn 0.25s ease-out forwards;
            }
            #viewModal .modal-container {
                animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideUp {
                from { transform: scale(0.9) translateY(20px); opacity: 0; }
                to { transform: scale(1) translateY(0); opacity: 1; }
            }
            .calendar-selected-cell {
                border-color: #0A6C5B !important;
                background-color: rgba(10, 108, 91, 0.04) !important;
                box-shadow: 0 0 0 3px rgba(10, 108, 91, 0.15) !important;
            }
            .card-hidden {
                opacity: 0;
                transform: scale(0.95);
                position: absolute;
                pointer-events: none;
                visibility: hidden;
                width: 0;
                height: 0;
                overflow: hidden;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
            }
            .booking-card {
                transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            }
        </style>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Bungalow Bookings</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Monitor reservations, approve room occupancy, and view guest timelines.</p>
            </div>
            <button class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                New Booking
            </button>
        </div>

        <!-- Statistics Cards Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Bookings -->
            <div onclick="document.querySelector('.js-tab-filter[data-status=\'\']').click();" class="summary-card bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.01)] hover:-translate-y-1 hover:shadow-md transition-all duration-200 cursor-pointer flex items-center justify-between group">
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Bookings</span>
                    <span class="block text-2xl font-extrabold text-slate-800 tracking-tight mt-1"><?= sprintf("%02d", $totalBookings) ?></span>
                </div>
                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-primary/5 group-hover:text-primary transition-colors border border-slate-100 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>

            <!-- Pending Review -->
            <div onclick="document.querySelector('.js-tab-filter[data-status=\'Pending\']').click();" class="summary-card bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.01)] hover:-translate-y-1 hover:shadow-md transition-all duration-200 cursor-pointer flex items-center justify-between group">
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending Review</span>
                    <span class="block text-2xl font-extrabold text-amber-600 tracking-tight mt-1"><?= sprintf("%02d", $pendingBookings) ?></span>
                </div>
                <div class="w-10 h-10 bg-amber-50/50 rounded-xl flex items-center justify-center text-amber-500 group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors border border-amber-100/30 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Confirmed Stays -->
            <div onclick="document.querySelector('.js-tab-filter[data-status=\'Confirmed\']').click();" class="summary-card bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.01)] hover:-translate-y-1 hover:shadow-md transition-all duration-200 cursor-pointer flex items-center justify-between group">
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Confirmed Stays</span>
                    <span class="block text-2xl font-extrabold text-[#0A6C5B] tracking-tight mt-1"><?= sprintf("%02d", $confirmedBookings) ?></span>
                </div>
                <div class="w-10 h-10 bg-emerald-50/50 rounded-xl flex items-center justify-center text-[#0A6C5B] group-hover:bg-emerald-50 group-hover:text-[#075346] transition-colors border border-emerald-100/30 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Cancelled / Rejected -->
            <div onclick="document.querySelector('.js-tab-filter[data-status=\'Cancelled\']').click();" class="summary-card bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.01)] hover:-translate-y-1 hover:shadow-md transition-all duration-200 cursor-pointer flex items-center justify-between group">
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cancelled / Rejected</span>
                    <span class="block text-2xl font-extrabold text-rose-600 tracking-tight mt-1"><?= sprintf("%02d", $cancelledBookings) ?></span>
                </div>
                <div class="w-10 h-10 bg-rose-50/50 rounded-xl flex items-center justify-center text-rose-500 group-hover:bg-rose-50 group-hover:text-rose-600 transition-colors border border-rose-100/30 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Calendar & Selected Day Details Container -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-8 items-start">
            
            <!-- Calendar Card (Left 3/4) -->
            <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 p-5 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-visible">
                <!-- Calendar Header with Month Picker -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mb-5 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-bold font-montserrat text-slate-800 tracking-tight flex items-center gap-1.5">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path></svg>
                            Booking Calendar
                        </h3>
                    </div>
                    <div class="flex items-center bg-slate-100 p-1 rounded-lg border border-slate-200/50">
                        <a href="?month=<?= $prevMonth ?>" class="px-2 py-1 hover:bg-white rounded transition-all font-bold text-slate-600 text-xs shadow-sm border border-transparent hover:border-slate-200/40">&lt;</a>
                        <input type="month" id="calendar-month-picker" class="bg-transparent border-none text-slate-700 text-xs font-bold focus:outline-none focus:ring-0 cursor-pointer text-center px-2" value="<?= htmlspecialchars($monthParam) ?>" onchange="window.location.href='?month='+this.value">
                        <a href="?month=<?= $nextMonth ?>" class="px-2 py-1 hover:bg-white rounded transition-all font-bold text-slate-600 text-xs shadow-sm border border-transparent hover:border-slate-200/40">&gt;</a>
                    </div>
                </div>
                
                <!-- Calendar Grid Headers -->
                <div class="grid grid-cols-7 gap-2 text-center mb-2">
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Sun</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Mon</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Tue</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Wed</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Thu</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Fri</div>
                    <div class="text-[9.5px] font-extrabold text-slate-400 uppercase tracking-wider">Sat</div>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    <?php
                    // Empty cells for days before the 1st
                    for ($i = 0; $i < $startDayOfWeek; $i++) {
                        echo '<div class="min-h-[65px] bg-slate-50/50 border border-slate-100/50 rounded-xl"></div>';
                    }

                    // Days of the month
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $dateStr = clone $firstDayOfMonth;
                        $dateStr->modify("+" . ($day - 1) . " days");
                        $dateKey = $dateStr->format('Y-m-d');
                        
                        $isToday = ($dateKey === date('Y-m-d'));
                        
                        $dayBookings = $bookedDates[$dateKey] ?? [];
                        $occupancy = getDayOccupancy($dayBookings);
                        
                        $avail = $occupancy['available_count'];
                        $list = $occupancy['bookings_list'];
                        
                        // Calculate occupied vs pending
                        $occupiedCount = 0;
                        $pendingCount = 0;
                        foreach ($list as $bItem) {
                            if ($bItem['status'] === 'Confirmed') {
                                $occupiedCount += $bItem['qty'];
                            } else {
                                $pendingCount += $bItem['qty'];
                            }
                        }
                        
                        $colIndex = ($startDayOfWeek + $day - 1) % 7 + 1;
                        
                        // Tooltip positioning
                        $tooltipAlign = ($colIndex <= 3) ? 'left-full ml-2' : 'right-full mr-2';
                        $arrowAlign = ($colIndex <= 3) 
                            ? 'absolute top-1/2 -translate-y-1/2 right-full w-0 h-0 border-t-8 border-t-transparent border-b-8 border-b-transparent border-r-8 border-r-slate-900' 
                            : 'absolute top-1/2 -translate-y-1/2 left-full w-0 h-0 border-t-8 border-t-transparent border-b-8 border-b-transparent border-l-8 border-l-slate-900';
                        
                        $cellClass = 'bg-white border-slate-100 hover:border-slate-300';
                        if ($isToday) {
                            $cellClass = 'bg-primary/5 border-primary/40 shadow-[0_2px_8px_rgba(19,39,63,0.04)]';
                        } elseif ($avail === 0 && ($occupiedCount > 0 || $pendingCount > 0)) {
                            $cellClass = 'bg-rose-50/10 border-rose-100 hover:border-rose-200';
                        }
                        
                        $jsonBookings = htmlspecialchars(json_encode($dayBookings));
                    ?>
                        <div onclick="showDayDetails('<?= $dateKey ?>', this)" data-bookings="<?= $jsonBookings ?>" class="js-day-cell group relative flex flex-col justify-between p-2 border rounded-xl hover:bg-slate-50 transition-all cursor-pointer shadow-sm min-h-[65px] <?= $cellClass ?>">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold <?= $isToday ? 'text-primary w-5.5 h-5.5 rounded-full bg-primary/10 flex items-center justify-center' : 'text-slate-800' ?>"><?= $day ?></span>
                            </div>
                            
                            <div class="flex flex-col gap-0.5 mt-1 font-inter text-[8.5px] leading-tight">
                                <?php if (empty($list)): ?>
                                    <span class="px-1.5 py-0.5 rounded bg-slate-50/50 text-slate-400/80 font-medium text-[8.5px] flex items-center justify-center tracking-tight border border-slate-100/35">Empty</span>
                                <?php else: ?>
                                    <?php if ($avail > 0): ?>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-extrabold text-[8.5px] border border-emerald-100/50 flex items-center justify-center tracking-tight"><?= $avail ?> Free</span>
                                    <?php else: ?>
                                        <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-extrabold text-[8.5px] border border-rose-100/50 flex items-center justify-center tracking-tight">Full</span>
                                    <?php endif; ?>
                                    <?php if ($occupiedCount > 0): ?>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[8.5px] border border-slate-200/50 flex items-center justify-center tracking-tight"><?= $occupiedCount ?> Occ</span>
                                    <?php endif; ?>
                                    <?php if ($pendingCount > 0): ?>
                                        <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-semibold text-[8.5px] border border-amber-100/50 flex items-center justify-center tracking-tight"><?= $pendingCount ?> Pend</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Hover Tooltip -->
                            <div class="pointer-events-none absolute <?= $tooltipAlign ?> top-1/2 -translate-y-1/2 w-72 bg-slate-900/95 backdrop-blur-md text-slate-100 text-xs rounded-xl p-3.5 shadow-2xl opacity-0 scale-95 origin-center group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 z-[200] border border-slate-800">
                                <div class="<?= $arrowAlign ?>"></div>
                                
                                <div class="font-bold border-b border-white/10 pb-1.5 mb-1.5 flex justify-between items-center text-[11.5px]">
                                    <span><?= $dateStr->format('l, M j') ?></span>
                                    <span class="<?= $avail > 0 ? 'text-emerald-400' : 'text-rose-400' ?> font-extrabold"><?= $avail ?> / 7 Rooms Free</span>
                                </div>
                                
                                <?php if (empty($list)): ?>
                                    <p class="text-slate-400 italic text-[10px] py-0.5">No active bookings for this date.</p>
                                <?php else: ?>
                                    <div class="space-y-1.5 max-h-[180px] overflow-y-auto pr-0.5">
                                        <ul class="space-y-1.5">
                                            <?php foreach ($list as $bItem): 
                                                $statusColorItem = $bItem['status'] === 'Confirmed' ? 'text-emerald-400' : 'text-amber-400';
                                            ?>
                                                <li class="border-b border-white/5 pb-1 last:border-0 last:pb-0 text-[10.5px]">
                                                    <div class="flex justify-between items-start gap-1">
                                                        <span class="font-semibold text-white truncate max-w-[150px]"><?= htmlspecialchars($bItem['room']) ?></span>
                                                        <span class="text-[8.5px] uppercase font-bold shrink-0 <?= $statusColorItem ?>"><?= $bItem['status'] ?></span>
                                                    </div>
                                                    <span class="text-slate-300 text-[9.5px] block mt-0.5">By: <?= htmlspecialchars($bItem['name']) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <!-- Day Details Panel (Right 1/4) -->
            <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] p-5 min-h-[345px] self-stretch flex flex-col">
                <h4 id="day-details-title" class="font-bold text-primary border-b border-slate-100 pb-3 mb-4 text-[13px] tracking-tight flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Day Details
                </h4>
                <div id="day-details-content" class="space-y-3 flex-1 overflow-y-auto max-h-[300px] pr-1">
                    <div class="flex flex-col items-center justify-center text-center py-12 px-4">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3 border border-slate-100 shadow-inner">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008z"></path></svg>
                        </div>
                        <p class="text-xs text-slate-400 italic font-medium leading-normal max-w-[150px]">Click a calendar date cell to view occupancy timeline.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Section (Bookings List & Filters) -->
        <div class="space-y-6">
            <!-- Filters & Search Panel -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] flex flex-col gap-5">
                <!-- iOS-style Sliding Segmented Tab Controller -->
                <div class="flex items-center space-x-1 bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/40 w-full sm:w-fit">
                    <button type="button" class="js-tab-filter flex-1 sm:flex-none px-6 py-2.5 text-[12.5px] font-bold rounded-lg transition-all text-slate-500 hover:text-slate-800" data-status="">All</button>
                    <button type="button" class="js-tab-filter flex-1 sm:flex-none px-6 py-2.5 text-[12.5px] font-bold rounded-lg transition-all bg-white text-slate-800 shadow-[0_2px_8px_rgba(0,0,0,0.06)] border border-slate-200/30" data-status="Pending">Pending</button>
                    <button type="button" class="js-tab-filter flex-1 sm:flex-none px-6 py-2.5 text-[12.5px] font-bold rounded-lg transition-all text-slate-500 hover:text-slate-800" data-status="Confirmed">Confirmed</button>
                    <button type="button" class="js-tab-filter flex-1 sm:flex-none px-6 py-2.5 text-[12.5px] font-bold rounded-lg transition-all text-slate-500 hover:text-slate-800" data-status="Cancelled">Cancelled</button>
                </div>
                
                <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full">
                    <!-- Search Box -->
                    <div class="relative w-full lg:flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                        </span>
                        <input type="text" placeholder="Search guests by name..." class="js-search-input w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/70 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 placeholder-slate-400 shadow-inner transition-all">
                    </div>
                    
                    <!-- Bungalow Filter Selector -->
                    <?php
                    $bungalows = $pdo->query("SELECT DISTINCT bungalow_name FROM bookings ORDER BY bungalow_name")->fetchAll(PDO::FETCH_COLUMN);
                    $bungOptions = [];
                    foreach($bungalows as $bName) {
                        $displayName = $bName;
                        if (stripos($bName, 'Bungalow') === false) {
                            $displayName .= ' Bungalow';
                        }
                        $bungOptions[$bName] = $displayName;
                    }
                    echo renderDropdown([
                        'class' => 'js-bungalow-filter',
                        'placeholder' => 'All Bungalows',
                        'options' => $bungOptions,
                        'icon' => 'home',
                        'width' => 'w-full lg:w-72 shrink-0'
                    ]);
                    ?>
                </div>
            </div>

            <!-- Bookings Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($bookings)): ?>
                    <div class="col-span-full py-24 flex flex-col items-center justify-center text-center bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5 border border-slate-100 shadow-inner">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zM14.25 15h.008v.008H14.25V15zm0 2.25h.008v.008H14.25v-.008zM16.5 15h.008v.008H16.5V15zm0 2.25h.008v.008H16.5v-.008zM12 12.75h.008v.008H12v-.008zM9.75 12.75h.008v.008H9.75v-.008zM7.5 12.75h.008v.008H7.5v-.008zM14.25 12.75h.008v.008H14.25v-.008zM16.5 12.75h.008v.008H16.5v-.008z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">No bookings registered</h3>
                        <p class="text-xs text-slate-400 max-w-sm px-4">There are currently no bungalow bookings stored in the database matching this criteria.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                    <?php
                    $statusClass = '';
                    $borderAccent = '';
                    if ($booking['status'] === 'Pending') {
                        $statusClass = 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                        $borderAccent = 'border-t-[#D97706]';
                    } elseif ($booking['status'] === 'Confirmed') {
                        $statusClass = 'bg-green-50 text-green-700 border border-green-200';
                        $borderAccent = 'border-t-[#059669]';
                    } elseif ($booking['status'] === 'Cancelled') {
                        $statusClass = 'bg-rose-50 text-rose-700 border border-rose-200';
                        $borderAccent = 'border-t-[#DC2626]';
                    }

                    $start = new DateTime($booking['start_date']);
                    $end = new DateTime($booking['end_date']);
                    $nights = $end->diff($start)->format("%a");
                    ?>
                    <?php
                    $estimatedCost = getEstimatedCost($booking['applicant_category'], $booking['room_type'], $nights, $booking['entire_bungalow']);
                    ?>
                    <div onclick="openViewModal(<?= htmlspecialchars(json_encode($booking)) ?>)" class="js-booking-card booking-card rounded-2xl border border-slate-200/75 border-t-4 <?= $borderAccent ?> overflow-hidden shadow-sm bg-white flex flex-col cursor-pointer hover:border-slate-300 relative group">
                        
                        <div class="px-5 pt-5 pb-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-[15px] leading-snug flex items-center gap-1">
                                        <span class="js-bungalow-name"><?= htmlspecialchars($booking['bungalow_name']) ?></span>
                                    </h3>
                                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Bungalow</span>
                                </div>
                                <div class="flex flex-col items-end gap-1.5 shrink-0">
                                    <span class="js-status-pill px-2.5 py-1 rounded-md text-[11px] font-bold <?= $statusClass ?> shadow-sm"><?= htmlspecialchars($booking['status']) ?></span>
                                    <span class="text-[11.5px] font-extrabold text-slate-800 tracking-tight">Est. Rs. <?= number_format($estimatedCost) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-5">
                            <div class="flex items-center justify-between bg-slate-50/70 border border-slate-100 px-4 py-3 rounded-xl">
                                <div>
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Check-In</span>
                                    <span class="font-bold text-slate-700 text-xs tracking-tight"><?= date('M d, Y', strtotime($booking['start_date'])) ?></span>
                                </div>
                                <div class="flex-1 flex flex-col items-center px-3">
                                    <span class="text-[9.5px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded-full border border-primary/10 tracking-tight">
                                        <?= $nights ?> <?= $nights == 1 ? 'Night' : 'Nights' ?>
                                    </span>
                                    <div class="w-full flex items-center justify-center mt-1">
                                        <div class="w-full h-[1.5px] bg-slate-200 relative flex items-center justify-center">
                                            <div class="absolute w-2 h-2 rounded-full bg-slate-300"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Check-Out</span>
                                    <span class="font-bold text-slate-700 text-xs tracking-tight"><?= date('M d, Y', strtotime($booking['end_date'])) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-5 py-4 flex-1 flex flex-col justify-between">
                            <div class="grid grid-cols-2 gap-y-4 gap-x-4 pt-3 border-t border-slate-100/80">
                                <div class="col-span-2 sm:col-span-1">
                                    <p class="text-[10px] uppercase text-slate-400 font-bold tracking-wider mb-1">Applicant</p>
                                    <div class="flex items-center">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-primary to-[#254974] text-white flex items-center justify-center text-[10.5px] font-bold mr-2 shrink-0 shadow-sm">
                                            <?= htmlspecialchars(substr($booking['applicant_name'] ?? 'A', 0, 1)) ?>
                                        </div>
                                        <span class="js-applicant-name font-bold text-slate-800 text-[13px] truncate max-w-[120px]" title="<?= htmlspecialchars($booking['applicant_name'] ?? '') ?>"><?= htmlspecialchars($booking['applicant_name'] ?? '') ?></span>
                                    </div>
                                </div>
                                
                                <div class="col-span-2 sm:col-span-1">
                                    <p class="text-[10px] uppercase text-slate-400 font-bold tracking-wider mb-1">Rooms</p>
                                    <p class="font-bold text-slate-700 text-[12.5px] flex items-center h-7">
                                        <svg class="w-4 h-4 mr-1.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="truncate" title="<?= htmlspecialchars($booking['room_type'] ?? '') ?>">
                                            <?= htmlspecialchars($booking['room_type'] ?? '') ?>
                                            <?php if (isset($booking['no_of_rooms']) && $booking['no_of_rooms'] > 1): ?>
                                                <span class="ml-1 text-[10px] bg-red-50 text-secondary border border-red-100 px-1.5 py-0.5 rounded font-bold">x<?= $booking['no_of_rooms'] ?></span>
                                            <?php endif; ?>
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="col-span-2 pt-1.5">
                                    <div class="flex items-center text-slate-500 text-[11.5px] gap-1.5 truncate">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                        <span class="truncate" title="<?= htmlspecialchars($booking['email'] ?? '') ?>"><?= htmlspecialchars($booking['email'] ?? 'No email') ?></span>
                                    </div>
                                    <div class="flex items-center text-slate-500 text-[11.5px] gap-1.5 mt-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.194-4.172-7-7l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                        <span><?= htmlspecialchars($booking['phone'] ?? '') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50/70 p-4 border-t border-slate-100 flex gap-2.5" onclick="event.stopPropagation();">
                            <button type="button" onclick="openViewModal(<?= htmlspecialchars(json_encode($booking)) ?>)" class="flex-1 py-2.5 bg-white border border-slate-200 hover:border-slate-300 rounded-lg text-slate-700 font-bold text-[12px] hover:text-slate-900 transition-all shadow-sm">View Details</button>
                            
                            <?php if ($booking['status'] === 'Pending'): ?>
                                <a href="bungalow-bookings?action=reject&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to cancel this booking?" class="px-3.5 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-lg font-bold text-[12px] hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm flex items-center justify-center" title="Reject">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                                <a href="bungalow-bookings?action=approve&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to approve this booking?" class="flex-1 py-2.5 bg-[#0A6C5B] text-white text-center rounded-lg font-bold text-[12px] hover:bg-[#075346] hover:shadow-md transition-all shadow-sm">Approve</a>
                            <?php endif; ?>
                            
                            <?php if ($booking['status'] === 'Confirmed'): ?>
                                <a href="bungalow-bookings?action=reject&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to cancel this confirmed booking?" class="flex-1 py-2.5 bg-white border border-rose-200 text-rose-600 text-center rounded-lg font-bold text-[12px] hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm">Cancel Booking</a>
                            <?php endif; ?>
                            
                            <?php if ($booking['status'] === 'Cancelled'): ?>
                                <a href="bungalow-bookings?action=delete&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to permanently delete this cancelled booking?" class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-500 text-center rounded-lg font-bold text-[12px] hover:bg-slate-100 hover:text-slate-700 transition-all shadow-sm">Delete Record</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<!-- Deluxe View Modal Redesign -->
<div id="viewModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all flex flex-col max-h-[90vh] modal-container border border-slate-100">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-extrabold font-montserrat text-slate-800 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Booking Confirmation Detail
            </h3>
            <button type="button" onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 rounded-lg p-1.5 border border-slate-200/50 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Modal Body Content -->
        <div class="px-6 py-5 overflow-y-auto" id="modal-content">
            <!-- Dynamic Content loaded here -->
        </div>
        
        <!-- Modal Footer -->
        <div id="modal-footer-container" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end shrink-0 gap-2.5 flex-wrap">
            <button type="button" onclick="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-lg text-[12.5px] font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">Close Window</button>
        </div>
    </div>
</div>

<script>
const csrfToken = '<?= generateCsrfToken() ?>';
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

function getJSEstimatedCost(category, roomTypeStr, nights, entireBungalow) {
    let tier = 2; // Default: Local Citizens / Private
    const cat = (category || '').toLowerCase();
    if (cat.includes('ministry of labour') || cat.includes('mol')) {
        tier = 1;
    } else if (cat.includes('foreign')) {
        tier = 3;
    }
    
    if (entireBungalow || (roomTypeStr || '').toLowerCase().includes('entire bungalow')) {
        const rates = {1: 5000, 2: 10000, 3: 25000};
        return rates[tier] * nights;
    }
    
    const rates = {1: 1000, 2: 2000, 3: 5000};
    const baseRate = rates[tier];
    
    let totalRoomsCount = 0;
    const parts = (roomTypeStr || '').split(',');
    parts.forEach(part => {
        const p = part.trim();
        if (!p) return;
        let qty = 1;
        const match = p.match(/\(x(\d+)\)/i);
        if (match) {
            qty = parseInt(match[1], 10);
        }
        totalRoomsCount += qty;
    });
    
    if (totalRoomsCount <= 0) totalRoomsCount = 1;
    return baseRate * totalRoomsCount * nights;
}

function showDayDetails(dateKey, element) {
    const bookingsStr = element.getAttribute('data-bookings');
    let bookings = [];
    if (bookingsStr) {
        bookings = JSON.parse(bookingsStr);
    }
    
    document.querySelectorAll('.js-day-cell').forEach(el => {
        el.classList.remove('calendar-selected-cell');
    });
    element.classList.add('calendar-selected-cell');
    
    const title = document.getElementById('day-details-title');
    const content = document.getElementById('day-details-content');
    
    title.innerHTML = `
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        ${formatDate(dateKey)} Details
    `;
    content.innerHTML = '';
    
    if (bookings.length === 0) {
        content.innerHTML = `
            <div class="flex flex-col items-center justify-center text-center py-12 px-4">
                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3 border border-slate-100 shadow-inner">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs text-slate-400 italic font-medium leading-normal max-w-[150px]">No bookings scheduled on this date.</p>
            </div>
        `;
    } else {
        bookings.forEach(b => {
            const statusColor = b.status === 'Confirmed' ? 'text-[#047857] bg-[#ECFDF5] border-[#A7F3D0]/60' : 'text-[#B45309] bg-[#FFFBEB] border-[#FDE68A]/60';
            
            const card = document.createElement('div');
            card.className = "p-3 bg-slate-50/70 rounded-xl border border-slate-200/50 flex flex-col gap-1.5 shadow-sm cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-all";
            card.innerHTML = `
                <div class="flex justify-between items-center">
                    <span class="font-bold text-[12px] text-slate-800 truncate max-w-[110px]">${b.name}</span>
                    <span class="text-[8.5px] font-extrabold tracking-wide uppercase px-1.5 py-0.5 rounded border ${statusColor}">${b.status}</span>
                </div>
                <div class="text-[10.5px] text-slate-500 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="truncate">${b.room}</span>
                </div>
            `;
            card.addEventListener('click', () => {
                openViewModal(b);
            });
            content.appendChild(card);
        });
    }
}

function openViewModal(booking) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('modal-content');
    
    let statusPill = '';
    if (booking.status === 'Pending') {
        statusPill = 'text-[#B45309] bg-[#FFFBEB] border-[#FDE68A]';
    } else if (booking.status === 'Confirmed') {
        statusPill = 'text-[#047857] bg-[#ECFDF5] border-[#A7F3D0]';
    } else {
        statusPill = 'text-[#B91C1C] bg-[#FEF2F2] border-[#FEE2E2]';
    }

    const start = new Date(booking.start_date);
    const end = new Date(booking.end_date);
    const nights = Math.round((end - start) / (1000 * 60 * 60 * 24));
    
    const isMOL = (booking.applicant_category || '').toLowerCase().includes('ministry of labour') || (booking.applicant_category || '').toLowerCase().includes('mol');
    const estimatedCost = getJSEstimatedCost(booking.applicant_category, booking.room_type, nights, booking.entire_bungalow);
    
    let molFieldsHtml = '';
    if (isMOL) {
        molFieldsHtml = `
            <div>
                <span class="block text-[10px] font-semibold text-slate-400">Designation</span>
                <span class="block font-medium text-slate-800">${booking.designation || 'N/A'} ${booking.is_retired === 'Yes' ? '(Retired)' : ''}</span>
            </div>
            <div>
                <span class="block text-[10px] font-semibold text-slate-400">Ministry / Dept / Org</span>
                <span class="block font-medium text-slate-800">${booking.workplace_address || 'N/A'}</span>
            </div>
        `;
    }

    let html = `
        <div class="space-y-5 text-[13px] text-slate-600 font-inter">
            <!-- Top Status Summary -->
            <div class="flex justify-between items-center bg-slate-50 border border-slate-100 p-4 rounded-xl">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</span>
                    <span class="inline-block mt-1 text-[10.5px] font-extrabold tracking-wider uppercase px-2.5 py-0.5 rounded-full border ${statusPill}">${booking.status}</span>
                </div>
                <div class="text-right">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bungalow</span>
                    <span class="font-extrabold text-slate-800 text-[14px]">${booking.bungalow_name}</span>
                </div>
            </div>
            
            <!-- Dates Stay Timeline Component -->
            <div>
                <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-2">Reservation Timeline</span>
                <div class="flex items-center justify-between bg-[#F8FAFC] border border-slate-200/50 p-4 rounded-xl relative shadow-inner">
                    <div>
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Check-in Date</span>
                        <span class="font-bold text-primary text-[13px]">${formatDate(booking.start_date)}</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center px-4">
                        <span class="text-[10px] font-extrabold text-primary bg-primary/5 px-2.5 py-1 rounded-full border border-primary/10 tracking-tight">
                            ${nights} ${nights == 1 ? 'Night' : 'Nights'}
                        </span>
                        <div class="w-full h-[1.5px] bg-slate-200 mt-1 relative flex items-center justify-center">
                            <div class="absolute w-2 h-2 rounded-full bg-slate-400"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Check-out Date</span>
                        <span class="font-bold text-primary text-[13px]">${formatDate(booking.end_date)}</span>
                    </div>
                </div>
            </div>

            <!-- Booking Room details -->
            <div class="bg-white border border-slate-100 p-4 rounded-xl shadow-sm space-y-3">
                <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-1.5">Room & Space Request</span>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Selected Type</span>
                    <span class="font-bold text-slate-800">${booking.room_type}</span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-50 pt-2">
                    <span class="text-slate-500">Number of Rooms</span>
                    <span class="font-extrabold text-secondary bg-red-50 border border-red-100 px-2 py-0.5 rounded text-xs">x${booking.no_of_rooms || 1}</span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-50 pt-2">
                    <span class="text-slate-500">Estimated Cost</span>
                    <span class="font-extrabold text-slate-800">Rs. ${estimatedCost.toLocaleString()}</span>
                </div>
            </div>

            <!-- Guest Profile details -->
            <div class="bg-white border border-slate-100 p-4 rounded-xl shadow-sm space-y-3.5">
                <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-1.5">Guest Profile Information</span>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">Full Name</span>
                        <span class="block font-bold text-slate-800">${booking.applicant_name}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">NIC / Passport</span>
                        <span class="block font-medium text-slate-800">${booking.nic || booking.passport_number || 'N/A'}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">Applicant Category</span>
                        <span class="block font-medium text-slate-800">${booking.applicant_category || 'N/A'}</span>
                    </div>
                    ${molFieldsHtml}
                    <div class="col-span-2">
                        <span class="block text-[10px] font-semibold text-slate-400">Residential Address</span>
                        <span class="block font-medium text-slate-800">${booking.residential_address || 'N/A'}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white border border-slate-100 p-4 rounded-xl shadow-sm space-y-3">
                <span class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-1.5">Contact Details</span>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">Email Address</span>
                        <span class="block font-medium text-slate-800 break-all">${booking.email}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">Mobile Phone</span>
                        <span class="block font-medium text-slate-800">${booking.phone}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-slate-400">Office Phone</span>
                        <span class="block font-medium text-slate-800">${booking.phone_office || 'N/A'}</span>
                    </div>
                </div>
            </div>
            
            <div class="pt-2">
                <span class="block text-[10px] font-semibold text-slate-400 text-center">Application Submitted On: ${new Date(booking.created_at).toLocaleString()}</span>
            </div>
        </div>
    `;
    
    content.innerHTML = html;
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Dynamically populate modal footer with direct action buttons
    const footer = document.getElementById('modal-footer-container');
    let footerHtml = '<button type="button" onclick="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-lg text-[12.5px] font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">Close Window</button>';
    
    if (booking.status === 'Pending') {
        footerHtml = `
            <button type="button" onclick="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-lg text-[12.5px] font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">Close</button>
            <a href="bungalow-bookings?action=reject&id=${booking.id}&csrf_token=${csrfToken}" data-confirm="Are you sure you want to cancel this booking?" class="px-4 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-lg font-bold text-[12.5px] hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm flex items-center justify-center">Reject Request</a>
            <a href="bungalow-bookings?action=approve&id=${booking.id}&csrf_token=${csrfToken}" data-confirm="Are you sure you want to approve this booking?" class="px-5 py-2.5 bg-[#0A6C5B] text-white rounded-lg font-bold text-[12.5px] hover:bg-[#075346] hover:shadow-md transition-all shadow-sm text-center">Approve Request</a>
        `;
    } else if (booking.status === 'Confirmed') {
        footerHtml = `
            <button type="button" onclick="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-lg text-[12.5px] font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">Close</button>
            <a href="bungalow-bookings?action=reject&id=${booking.id}&csrf_token=${csrfToken}" data-confirm="Are you sure you want to cancel this confirmed booking?" class="px-5 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-lg font-bold text-[12.5px] hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm text-center">Cancel Booking</a>
        `;
    } else if (booking.status === 'Cancelled') {
        footerHtml = `
            <button type="button" onclick="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-lg text-[12.5px] font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">Close</button>
            <a href="bungalow-bookings?action=delete&id=${booking.id}&csrf_token=${csrfToken}" data-confirm="Are you sure you want to permanently delete this cancelled booking?" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-lg font-bold text-[12.5px] hover:bg-slate-100 hover:text-slate-700 transition-all shadow-sm text-center">Delete Record</a>
        `;
    }
    footer.innerHTML = footerHtml;
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.js-search-input');
    const bungalowSelect = document.querySelector('.js-bungalow-filter');
    const tabButtons = document.querySelectorAll('.js-tab-filter');
    const cards = document.querySelectorAll('.js-booking-card');
    
    let currentStatus = 'Pending';
    
    function filterCards() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const bungalowTerm = bungalowSelect ? bungalowSelect.value.toLowerCase() : '';
        
        cards.forEach(card => {
            const nameElem = card.querySelector('.js-applicant-name');
            const bungalowElem = card.querySelector('.js-bungalow-name');
            const statusElem = card.querySelector('.js-status-pill');
            
            if (!nameElem || !bungalowElem || !statusElem) return;

            const name = nameElem.textContent.toLowerCase();
            const bungalow = bungalowElem.textContent.toLowerCase();
            const status = statusElem.textContent;
            
            const matchesSearch = name.includes(searchTerm);
            const matchesBungalow = bungalowTerm === '' || bungalow.includes(bungalowTerm);
            const matchesStatus = currentStatus === '' || status === currentStatus;
            
            if (matchesSearch && matchesStatus && matchesBungalow) {
                card.classList.remove('card-hidden');
            } else {
                card.classList.add('card-hidden');
            }
        });
    }
    
    if (searchInput) searchInput.addEventListener('input', filterCards);
    if (bungalowSelect) bungalowSelect.addEventListener('change', filterCards);
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tabButtons.forEach(b => {
                b.classList.remove('bg-white', 'text-slate-800', 'shadow-[0_2px_8px_rgba(0,0,0,0.06)]', 'border-slate-200/30', 'border');
                b.classList.add('text-slate-500', 'hover:text-slate-800');
            });
            this.classList.remove('text-slate-500', 'hover:text-slate-800');
            this.classList.add('bg-white', 'text-slate-800', 'shadow-[0_2px_8px_rgba(0,0,0,0.06)]', 'border', 'border-slate-200/30');
            
            currentStatus = this.getAttribute('data-status');
            filterCards();
        });
    });
    
    // Initial filter on load
    filterCards();
});
</script>

<?php include 'includes/footer.php'; ?>

