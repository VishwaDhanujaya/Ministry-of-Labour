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
        header("Location: bungalow-bookings.php");
        exit;
    }

    if ($new_status) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        header("Location: bungalow-bookings.php");
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
        $bookedDates[$dateStr][] = [
            'status' => $b['status'],
            'room' => ($b['room_type'] ?? 'Room') . (isset($b['no_of_rooms']) && $b['no_of_rooms'] > 1 ? ' (x' . $b['no_of_rooms'] . ')' : ''),
            'name' => $b['applicant_name']
        ];
    }
}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Bungalow Bookings</h2>
            <button class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Booking
            </button>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
<!-- Main Content -->
                <div class="xl:col-span-3">
                
                
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[12px] font-medium text-gray-500 uppercase tracking-wide">Total Bookings</p>
                                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $totalBookings) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-gray-50 text-gray-600 flex items-center justify-center shrink-0 border border-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[12px] font-medium text-amber-600 uppercase tracking-wide">Pending</p>
                                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $pendingBookings) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[12px] font-medium text-teal-600 uppercase tracking-wide">Confirmed</p>
                                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $confirmedBookings) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 border border-teal-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[12px] font-medium text-red-600 uppercase tracking-wide">Cancelled</p>
                                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $cancelledBookings) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Bar & Tabs -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <!-- Tabs -->
                    <div class="flex items-center space-x-1 bg-gray-100/50 p-1 rounded-lg border border-gray-200">
                        <button type="button" class="js-tab-filter px-5 py-2 text-[13px] font-medium rounded-md transition-colors text-gray-600 hover:text-gray-900" data-status="">All</button>
                        <button type="button" class="js-tab-filter px-5 py-2 text-[13px] font-medium rounded-md transition-colors bg-white text-gray-900 shadow-sm border border-gray-200" data-status="Pending">Pending</button>
                        <button type="button" class="js-tab-filter px-5 py-2 text-[13px] font-medium rounded-md transition-colors text-gray-600 hover:text-gray-900" data-status="Confirmed">Confirmed</button>
                        <button type="button" class="js-tab-filter px-5 py-2 text-[13px] font-medium rounded-md transition-colors text-gray-600 hover:text-gray-900" data-status="Cancelled">Cancelled</button>
                    </div>
                    
                    <div class="flex gap-4">
                        <!-- Search -->
                        <div class="relative w-64">
                            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" placeholder="Search by name..." class="w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-800 placeholder-gray-400">
                        </div>
                        
                        <!-- Bungalow Filter -->
                        <div class="relative w-48">
                            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <select class="js-bungalow-filter w-full pl-10 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                                <option value="">All Bungalows</option>
                                <?php
                                $bungalows = $pdo->query("SELECT DISTINCT bungalow_name FROM bookings ORDER BY bungalow_name")->fetchAll(PDO::FETCH_COLUMN);
                                foreach($bungalows as $bName) {
                                    echo '<option value="' . htmlspecialchars($bName) . '">' . htmlspecialchars($bName) . '</option>';
                                }
                                ?>
                            </select>
                            <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Bookings Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6">
                    
                    <?php if (empty($bookings)): ?>
                        <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5 border border-gray-100 shadow-sm">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-[15px] font-bold text-gray-900 mb-1.5">No bookings found</p>
                            <p class="text-[13px] text-gray-500">There are no bookings matching your criteria or currently in the system.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                        <?php
                        // Determine pill color and border accent based on status
                        $statusClass = '';
                        $borderAccent = '';
                        if ($booking['status'] === 'Pending') {
                            $statusClass = 'bg-[#FDF9ED] text-[#966708] border border-[#F5DE9B]';
                            $borderAccent = 'border-t-[#D19717]';
                        } elseif ($booking['status'] === 'Confirmed') {
                            $statusClass = 'bg-[#EDF7F4] text-[#166952] border border-[#A4D9C7]';
                            $borderAccent = 'border-t-[#289174]';
                        } elseif ($booking['status'] === 'Cancelled') {
                            $statusClass = 'bg-[#FCF1F2] text-[#9E212D] border border-[#F2B8BC]';
                            $borderAccent = 'border-t-[#D13645]';
                        }

                        // Calculate nights
                        $start = new DateTime($booking['start_date']);
                        $end = new DateTime($booking['end_date']);
                        $nights = $end->diff($start)->format("%a");
                        ?>
                        <div class="js-booking-card rounded-xl border border-gray-200 border-t-4 <?= $borderAccent ?> overflow-hidden shadow-sm hover:shadow-md bg-white flex flex-col transition-all duration-200 relative group">
                            
                            <!-- Header Area -->
                            <div class="px-5 pt-5 pb-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-[16px] leading-tight"><span class="js-bungalow-name"><?= htmlspecialchars($booking['bungalow_name']) ?></span> Bungalow</h3>
                                        <div class="flex items-center text-[#4E0000] text-[12px] font-medium mt-1.5">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <?= date('M j', strtotime($booking['start_date'])) ?> – <?= date('M j, Y', strtotime($booking['end_date'])) ?> (<?= $nights ?> nights)
                                        </div>
                                    </div>
                                    <span class="js-status-pill px-2.5 py-1 rounded-md text-[10px] font-bold tracking-wide uppercase <?= $statusClass ?> shadow-sm"><?= htmlspecialchars($booking['status']) ?></span>
                                </div>
                            </div>
                            
                            <!-- Body Area -->
                            <div class="px-5 pb-6 flex-1">
                                <div class="grid grid-cols-2 gap-y-4 gap-x-4 pt-4 border-t border-gray-100">
                                    
                                    <div class="col-span-2 sm:col-span-1">
                                        <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider mb-0.5">Applicant</p>
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 rounded-full bg-[#13273F]/10 text-[#13273F] flex items-center justify-center text-[10px] font-bold mr-2 shrink-0">
                                                <?= htmlspecialchars(substr($booking['applicant_name'] ?? 'A', 0, 1)) ?>
                                            </div>
                                            <span class="js-applicant-name font-semibold text-gray-900 text-[13px] truncate"><?= htmlspecialchars($booking['applicant_name'] ?? '') ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-2 sm:col-span-1">
                                        <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider mb-0.5">Room Selection</p>
                                        <p class="font-medium text-gray-700 text-[13px] flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            <span class="truncate text-gray-900" title="<?= htmlspecialchars($booking['room_type'] ?? '') ?>">
                                                <?= htmlspecialchars($booking['room_type'] ?? '') ?>
                                                <?php if (isset($booking['no_of_rooms']) && $booking['no_of_rooms'] > 1): ?>
                                                    <span class="ml-1 text-[11px] bg-red-100/80 text-[#4E0000] px-1.5 py-0.5 rounded-md font-bold">x<?= $booking['no_of_rooms'] ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div class="col-span-2">
                                        <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider mb-0.5">Contact</p>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3 mt-0.5">
                                            <p class="font-medium text-gray-700 text-[12px] truncate" title="<?= htmlspecialchars($booking['email'] ?? '') ?>"><?= htmlspecialchars($booking['email'] ?? 'No email') ?></p>
                                            <p class="font-medium text-gray-400 text-[12px] hidden sm:block">•</p>
                                            <p class="font-medium text-gray-500 text-[12px]"><?= htmlspecialchars($booking['phone'] ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Footer -->
                            <div class="bg-gray-50/80 p-4 border-t border-gray-100 flex gap-2.5">
                                <button type="button" onclick="openViewModal(<?= htmlspecialchars(json_encode($booking)) ?>)" class="flex-1 py-2 bg-white border border-gray-300 rounded-md text-gray-700 font-bold text-[12px] hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">View Details</button>
                                
                                <?php if ($booking['status'] === 'Pending'): ?>
                                    <a href="bungalow-bookings.php?action=reject&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to cancel this booking?');" class="px-3 py-2 bg-white border border-red-200 text-red-600 rounded-md font-bold text-[12px] hover:bg-red-50 transition-all shadow-sm" title="Reject">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                    <a href="bungalow-bookings.php?action=approve&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to approve this booking?');" class="flex-1 py-2 bg-[#0A6C5B] text-white text-center rounded-md font-bold text-[12px] hover:bg-[#085a4c] transition-all shadow-sm">Approve</a>
                                <?php endif; ?>
                                
                                <?php if ($booking['status'] === 'Confirmed'): ?>
                                    <a href="bungalow-bookings.php?action=reject&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to cancel this confirmed booking?');" class="flex-1 py-2 bg-white border border-red-200 text-red-600 text-center rounded-md font-bold text-[12px] hover:bg-red-50 transition-all shadow-sm">Cancel Booking</a>
                                <?php endif; ?>

                                <?php if ($booking['status'] === 'Cancelled'): ?>
                                    <a href="bungalow-bookings.php?action=delete&id=<?= $booking['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to permanently delete this cancelled booking?');" class="flex-1 py-2 bg-white border border-gray-300 text-gray-600 text-center rounded-md font-bold text-[12px] hover:bg-gray-100 hover:text-gray-900 transition-all shadow-sm">Delete Record</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Right Column: Sidebar Calendar -->
            <div class="xl:col-span-1 space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden sticky top-8">
                    <div class="bg-[#13273F] text-white p-4 flex justify-between items-center">
                        <a href="?month=<?= $prevMonth ?>" class="p-1 hover:bg-white/10 rounded transition-colors">&lt;</a>
                        <input type="month" id="calendar-month-picker" class="bg-transparent border-none text-white text-[15px] font-medium focus:outline-none focus:ring-0 cursor-pointer text-center [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert" value="<?= $monthParam ?>" onchange="window.location.href='?month='+this.value">
                        <a href="?month=<?= $nextMonth ?>" class="p-1 hover:bg-white/10 rounded transition-colors">&gt;</a>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-7 text-center mb-2">
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Su</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Mo</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Tu</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">We</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Th</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Fr</div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase">Sa</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            <?php
                            // Empty cells for days before the 1st
                            for ($i = 0; $i < $startDayOfWeek; $i++) {
                                echo '<div class="h-10"></div>';
                            }

                            // Days of the month
                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                $dateStr = clone $firstDayOfMonth;
                                $dateStr->modify("+" . ($day - 1) . " days");
                                $dateKey = $dateStr->format('Y-m-d');
                                
                                $isToday = ($dateKey === date('Y-m-d'));
                                
                                $baseClass = 'bg-white border border-gray-100 hover:border-gray-300 shadow-sm cursor-pointer';
                                $textClass = 'text-gray-700';
                                
                                $dotsHtml = '';
                                $jsonBookings = '[]';
                                
                                if (isset($bookedDates[$dateKey])) {
                                    $dayBookings = $bookedDates[$dateKey];
                                    $jsonBookings = htmlspecialchars(json_encode($dayBookings));
                                    
                                    // Build dots
                                    $dots = '';
                                    foreach ($dayBookings as $b) {
                                        if ($b['status'] === 'Confirmed') {
                                            $dots .= '<div class="w-1.5 h-1.5 rounded-full bg-[#0A6C5B]"></div>';
                                        } else {
                                            $dots .= '<div class="w-1.5 h-1.5 rounded-full bg-[#A67C00]"></div>';
                                        }
                                    }
                                    
                                    if (!empty($dots)) {
                                        $dotsHtml = '<div class="flex gap-1 justify-center mt-0.5">' . $dots . '</div>';
                                        $baseClass = 'bg-[#F4F7FB] border border-[#E1E8F0] hover:border-[#CBD5E1] shadow-inner cursor-pointer';
                                    }
                                }

                                if ($isToday) {
                                    $baseClass = 'bg-[#13273F] border-[#13273F] shadow-md cursor-pointer';
                                    $textClass = 'text-white font-bold';
                                }

                                echo '<div onclick="showDayDetails(\''.$dateKey.'\', this)" data-bookings="'.$jsonBookings.'" class="js-day-cell h-10 rounded-lg flex flex-col items-center justify-center transition-all duration-200 ' . $baseClass . '">';
                                echo '<span class="text-[13px] ' . $textClass . '">' . $day . '</span>';
                                echo $dotsHtml;
                                echo '</div>';
                            }
                            ?>
                        </div>
                        
                        <!-- Legend -->
                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                            <div class="flex items-center text-[11px] text-gray-600">
                                <div class="w-2 h-2 rounded-full bg-[#289174] mr-2 shrink-0"></div> Confirmed Reservation
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600">
                                <div class="w-2 h-2 rounded-full bg-[#D19717] mr-2 shrink-0"></div> Pending Request
                            </div>
                            <div class="text-[10px] text-gray-400 mt-2 italic">Click on a date to see details below.</div>
                        </div>
                    </div>
                </div>
                
                <!-- Day Details Panel -->
                <div id="day-details-panel" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hidden sticky top-[480px]">
                    <h4 id="day-details-title" class="font-semibold text-[#13273F] border-b border-gray-100 pb-2 mb-3 text-[14px]"></h4>
                    <div id="day-details-content" class="space-y-3">
                        <!-- Dynamic details go here -->
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <h3 class="text-lg font-bold font-montserrat text-gray-900" id="modal-title">Booking Details</h3>
            <button type="button" onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto" id="modal-content">
            <!-- Dynamic Content -->
        </div>
        <div class="p-5 border-t border-gray-100 bg-gray-50 flex justify-end">
            <button type="button" onclick="closeViewModal()" class="px-4 py-2 bg-white border border-gray-300 rounded text-[13px] font-medium text-gray-700 hover:bg-gray-50">Close</button>
        </div>
    </div>
</div>

<script>
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

function showDayDetails(dateKey, element) {
    const bookingsStr = element.getAttribute('data-bookings');
    let bookings = [];
    if (bookingsStr) {
        bookings = JSON.parse(bookingsStr);
    }
    
    document.querySelectorAll('.js-day-cell').forEach(el => {
        el.classList.remove('ring-2', 'ring-[#0A6C5B]', 'border-[#0A6C5B]');
    });
    element.classList.add('ring-2', 'ring-[#0A6C5B]', 'border-[#0A6C5B]');
    
    const panel = document.getElementById('day-details-panel');
    const title = document.getElementById('day-details-title');
    const content = document.getElementById('day-details-content');
    
    title.textContent = formatDate(dateKey);
    content.innerHTML = '';
    
    if (bookings.length === 0) {
        content.innerHTML = '<p class="text-[13px] text-gray-500 italic">No bookings on this day.</p>';
    } else {
        bookings.forEach(b => {
            const statusColor = b.status === 'Confirmed' ? 'text-[#0A6C5B]' : 'text-[#A67C00]';
            content.innerHTML += `
                <div class="p-3 bg-[#F9FAFB] rounded-lg border border-gray-100">
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-bold text-[13px] text-gray-900">${b.name}</span>
                        <span class="text-[11px] font-bold ${statusColor}">${b.status}</span>
                    </div>
                    <div class="text-[12px] text-gray-500">${b.room}</div>
                </div>
            `;
        });
    }
    
    panel.classList.remove('hidden');
}

function openViewModal(booking) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('modal-content');
    
    let html = `
        <div class="space-y-4 text-[13px] text-gray-700">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Applicant</span>
                    <span class="font-medium text-gray-900 text-[14px]">${booking.applicant_name}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Status</span>
                    <span class="font-bold">${booking.status}</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Check-in</span>
                    <span>${formatDate(booking.start_date)}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Check-out</span>
                    <span>${formatDate(booking.end_date)}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Room</span>
                                    <span>${booking.room_type} (Qty: ${booking.no_of_rooms || 1})</span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Bungalow</span>
                                    <span>${booking.bungalow_name}</span>
                                </div>
                            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Phone</span>
                    <span>${booking.phone}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Email</span>
                    <span>${booking.email}</span>
                </div>
            </div>
            
        </div>
    `;
    
    content.innerHTML = html;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[placeholder="Search by name..."]');
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
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    if (searchInput) searchInput.addEventListener('input', filterCards);
    if (bungalowSelect) bungalowSelect.addEventListener('change', filterCards);
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tabButtons.forEach(b => {
                b.classList.remove('bg-white', 'text-gray-900', 'shadow-sm', 'border-gray-200', 'border');
                b.classList.add('text-gray-600', 'hover:text-gray-900');
            });
            this.classList.remove('text-gray-600', 'hover:text-gray-900');
            this.classList.add('bg-white', 'text-gray-900', 'shadow-sm', 'border', 'border-gray-200');
            
            currentStatus = this.getAttribute('data-status');
            filterCards();
        });
    });
    
    // Initial filter on load
    filterCards();
});
</script>

<?php include 'includes/footer.php'; ?>