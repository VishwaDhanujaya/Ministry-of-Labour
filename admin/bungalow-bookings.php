<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle status updates
if (isset($_GET['action']) && isset($_GET['id'])) {
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
        if (!isset($bookedDates[$dateStr]) || $bookedDates[$dateStr]['status'] == 'Pending') {
            // Priority: Confirmed > Pending
            $bookedDates[$dateStr] = [
                'status' => $b['status'],
                'name' => $b['applicant_name']
            ];
        }
    }
}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Bungalow Bookings</h2>
            <button class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Booking
            </button>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Left Column: Main Content -->
            <div class="xl:col-span-3">
                
                <!-- Filter Bar -->
                <div class="flex flex-col md:flex-row gap-4 mb-8">
                    <div class="relative flex-1 max-w-2xl">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search by name..." class="w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-800 placeholder-gray-400">
                    </div>
                    
                    <div class="flex gap-4">
                        
                        <div class="relative w-36">
                            <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <button class="js-reset-filter px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center hover:bg-red-50 transition-colors">
                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset Filter
                        </button>
                    </div>
                </div>



                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-[12px] font-medium text-gray-600">Total Bookings</p>
                        <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $totalBookings) ?></p>
                    </div>
                    <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-[12px] font-medium text-[#A67C00]">Pending Review</p>
                        <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $pendingBookings) ?></p>
                    </div>
                    <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-[12px] font-medium text-[#0A6C5B]">Confirmed</p>
                        <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $confirmedBookings) ?></p>
                    </div>
                    <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-[12px] font-medium text-red-600">Cancelled</p>
                        <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2"><?= sprintf('%02d', $cancelledBookings) ?></p>
                    </div>
                </div>

                <!-- Bookings Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6">
                    
                    <?php if (empty($bookings)): ?>
                        <div class="col-span-full py-10 text-center text-gray-500">No bookings found.</div>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                        <?php
                        // Determine pill color and text based on status
                        $statusClass = '';
                        if ($booking['status'] === 'Pending') {
                            $statusClass = 'bg-[#A67C00]/20 text-[#A67C00]';
                        } elseif ($booking['status'] === 'Confirmed') {
                            $statusClass = 'bg-[#0A6C5B]/30 text-[#0A6C5B]';
                        } elseif ($booking['status'] === 'Cancelled') {
                            $statusClass = 'bg-red-900/40 text-red-600';
                        }

                        // Calculate nights
                        $start = new DateTime($booking['start_date']);
                        $end = new DateTime($booking['end_date']);
                        $nights = $end->diff($start)->format("%a");
                        ?>
                        <div class="js-booking-card rounded-xl border border-gray-100 overflow-hidden shadow-sm bg-white flex flex-col">
                            <div class="bg-[#13273F] text-white px-5 py-4 flex justify-between items-center">
                                <h3 class="font-semibold text-[14px]"><?= htmlspecialchars($booking['bungalow_name']) ?> Bungalow</h3>
                                <span class="js-status-pill px-2.5 py-0.5 rounded text-[10px] font-bold <?= $statusClass ?>"><?= htmlspecialchars($booking['status']) ?></span>
                            </div>
                            <div class="p-6 space-y-3.5 flex-1">
                                <div class="flex items-start text-[12px] text-gray-700">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="font-bold text-gray-900"><?= htmlspecialchars($booking['applicant_name'] ?? '') ?></span>
                                </div>
                                <div class="flex items-start text-[12px] text-gray-500">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span><?= htmlspecialchars($booking['email'] ?? 'No email provided') ?></span>
                                </div>
                                <div class="flex items-start text-[12px] text-gray-500">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span><?= htmlspecialchars($booking['phone'] ?? '') ?></span>
                                </div>
                                <div class="flex items-start text-[12px] text-gray-500">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span><?= date('M j', strtotime($booking['start_date'])) ?> – <?= date('M j, Y', strtotime($booking['end_date'])) ?> (<?= $nights ?> nights)</span>
                                </div>
                                <div class="flex items-start text-[12px] text-gray-500">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span><?= htmlspecialchars($booking['guests'] ?? '1') ?> guests</span>
                                </div>
                                <div class="flex items-start text-[12px] text-gray-500">
                                    <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="truncate" title="<?= htmlspecialchars($booking['purpose'] ?? '') ?>"><?= htmlspecialchars($booking['purpose'] ?? 'No purpose provided') ?></span>
                                </div>
                            </div>
                            <div class="bg-[#E5E7EB] p-4 flex gap-2">
                                <button type="button" onclick="openViewModal(<?= htmlspecialchars(json_encode($booking)) ?>)" class="flex-1 py-2 border border-gray-400 rounded text-gray-800 font-bold text-[12px] hover:bg-gray-200 transition-colors bg-transparent">View</button>
                                <?php if ($booking['status'] === 'Cancelled'): ?>
                                <a href="bungalow-bookings.php?action=delete&id=<?= $booking['id'] ?>" onclick="return confirm('Are you sure you want to permanently delete this cancelled booking?');" class="flex-1 py-2 bg-gray-700 text-white text-center rounded font-bold text-[12px] hover:bg-gray-900 transition-colors">Delete</a>
                                <?php endif; ?>
                                <?php if ($booking['status'] !== 'Cancelled'): ?>
                                <a href="bungalow-bookings.php?action=reject&id=<?= $booking['id'] ?>" onclick="return confirm('Are you sure you want to cancel this booking?');" class="flex-1 py-2 bg-[#D10000] text-white text-center rounded font-bold text-[12px] hover:bg-[#a30000] transition-colors">Reject</a>
                                <?php endif; ?>
                                <?php if ($booking['status'] !== 'Confirmed'): ?>
                                <a href="bungalow-bookings.php?action=approve&id=<?= $booking['id'] ?>" onclick="return confirm('Are you sure you want to approve this booking?');" class="flex-1 py-2 bg-[#0A6C5B] text-white text-center rounded font-bold text-[12px] hover:bg-[#075043] transition-colors">Approve</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Full Calendar -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden sticky top-8">
                    <div class="bg-[#13273F] text-white p-5 flex justify-between items-center">
                        <h3 class="font-medium text-[15px]"><?= $monthName ?></h3>
                        <div class="flex items-center gap-2">
                            <a href="?month=<?= $prevMonth ?>" class="p-1 hover:bg-white/10 rounded transition-colors">&lt;</a>
                            <a href="?month=<?= $nextMonth ?>" class="p-1 hover:bg-white/10 rounded transition-colors">&gt;</a>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-7 gap-1 text-center mb-2">
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
                                
                                $statusClass = 'bg-[#F9FAFB] hover:bg-gray-100 text-gray-700'; // Default free
                                $tooltip = 'Available';
                                
                                if (isset($bookedDates[$dateKey])) {
                                    $bStatus = $bookedDates[$dateKey]['status'];
                                    $bName = $bookedDates[$dateKey]['name'];
                                    if ($bStatus === 'Confirmed') {
                                        $statusClass = 'bg-[#0A6C5B]/20 text-[#0A6C5B] font-bold ring-1 ring-[#0A6C5B]/30';
                                        $tooltip = "Confirmed: $bName";
                                    } elseif ($bStatus === 'Pending') {
                                        $statusClass = 'bg-[#FDECB1] text-[#A67C00] font-bold ring-1 ring-[#FDECB1]';
                                        $tooltip = "Pending: $bName";
                                    }
                                }

                                if ($isToday && !isset($bookedDates[$dateKey])) {
                                    $statusClass = 'bg-[#13273F] text-white font-bold shadow-md';
                                }

                                echo '<div class="h-10 rounded flex items-center justify-center text-[12px] cursor-help transition-colors ' . $statusClass . '" title="' . htmlspecialchars($tooltip) . '">' . $day . '</div>';
                            }
                            ?>
                        </div>
                        
                        <!-- Legend -->
                        <div class="mt-6 pt-4 border-t border-gray-100 space-y-2">
                            <div class="flex items-center text-[11px] text-gray-600">
                                <div class="w-3 h-3 rounded bg-[#0A6C5B]/20 ring-1 ring-[#0A6C5B]/30 mr-2 shrink-0"></div> Confirmed Booking
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600">
                                <div class="w-3 h-3 rounded bg-[#FDECB1] ring-1 ring-[#FDECB1] mr-2 shrink-0"></div> Pending Request
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600">
                                <div class="w-3 h-3 rounded bg-[#F9FAFB] border border-gray-200 mr-2 shrink-0"></div> Available
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- View Booking Modal -->
<div id="view-booking-modal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-[#13273F] text-white px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="font-semibold text-[16px]">Booking Details</h3>
            <button type="button" onclick="document.getElementById('view-booking-modal').classList.add('hidden')" class="text-gray-300 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="p-6 overflow-y-auto font-inter text-[13px] text-gray-700 space-y-4">
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Bungalow</span>
                <span class="col-span-2" id="modal-bungalow"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Status</span>
                <span class="col-span-2" id="modal-status"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Dates</span>
                <span class="col-span-2" id="modal-dates"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Applicant Name</span>
                <span class="col-span-2" id="modal-name"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Designation</span>
                <span class="col-span-2" id="modal-designation"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Telephone</span>
                <span class="col-span-2" id="modal-phone"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Email</span>
                <span class="col-span-2" id="modal-email"></span>
            </div>
            <div class="grid grid-cols-3 border-b border-gray-100 pb-2">
                <span class="font-semibold text-gray-900">Guests</span>
                <span class="col-span-2" id="modal-guests"></span>
            </div>
            <div class="grid grid-cols-3 pb-2">
                <span class="font-semibold text-gray-900">Requested On</span>
                <span class="col-span-2" id="modal-created"></span>
            </div>
        </div>
        
        <!-- Footer Buttons -->
        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex gap-3 justify-end shrink-0">
            <button type="button" onclick="document.getElementById('view-booking-modal').classList.add('hidden')" class="px-5 py-2 border border-gray-300 rounded text-gray-700 font-medium text-[13px] hover:bg-gray-100 transition-colors bg-white">Close</button>
            <div id="modal-actions" class="flex gap-2">
                <!-- Action buttons injected dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
function openViewModal(booking) {
    document.getElementById('modal-bungalow').innerText = booking.bungalow_name + ' Bungalow';
    
    // Status styling
    let statusClass = '';
    if (booking.status === 'Pending') statusClass = 'bg-[#A67C00]/20 text-[#A67C00]';
    else if (booking.status === 'Confirmed') statusClass = 'bg-[#0A6C5B]/30 text-[#0A6C5B]';
    else if (booking.status === 'Cancelled') statusClass = 'bg-red-900/40 text-red-600';
    
    document.getElementById('modal-status').innerHTML = `<span class="px-2.5 py-0.5 rounded text-[11px] font-bold ${statusClass}">${booking.status}</span>`;
    
    document.getElementById('modal-dates').innerText = booking.start_date + ' to ' + booking.end_date;
    document.getElementById('modal-name').innerText = booking.applicant_name || 'N/A';
    document.getElementById('modal-designation').innerText = booking.designation || 'N/A';
    document.getElementById('modal-phone').innerText = booking.phone || 'N/A';
    document.getElementById('modal-email').innerText = booking.email || 'N/A';
    document.getElementById('modal-guests').innerText = booking.guests || 'N/A';
    
    // Format created_at nicely
    let created = 'N/A';
    if(booking.created_at) {
        created = new Date(booking.created_at).toLocaleString();
    }
    document.getElementById('modal-created').innerText = created;

    // Build action buttons
    const actionsDiv = document.getElementById('modal-actions');
    let actionsHtml = '';
    if (booking.status === 'Cancelled') {
        actionsHtml += `<a href="bungalow-bookings.php?action=delete&id=${booking.id}" onclick="return confirm('Are you sure you want to permanently delete this cancelled booking?');" class="px-5 py-2 bg-gray-700 text-white rounded font-medium text-[13px] hover:bg-gray-900 transition-colors inline-block text-center">Delete</a>`;
    }
    if (booking.status !== 'Cancelled') {
        actionsHtml += `<a href="bungalow-bookings.php?action=reject&id=${booking.id}" onclick="return confirm('Are you sure you want to cancel this booking?');" class="px-5 py-2 bg-[#D10000] text-white rounded font-medium text-[13px] hover:bg-[#a30000] transition-colors inline-block text-center">Reject</a>`;
    }
    if (booking.status !== 'Confirmed') {
        actionsHtml += `<a href="bungalow-bookings.php?action=approve&id=${booking.id}" onclick="return confirm('Are you sure you want to approve this booking?');" class="px-5 py-2 bg-[#0A6C5B] text-white rounded font-medium text-[13px] hover:bg-[#075043] transition-colors inline-block text-center">Approve</a>`;
    }
    actionsDiv.innerHTML = actionsHtml;

    document.getElementById('view-booking-modal').classList.remove('hidden');
}
</script>

<?php include 'includes/footer.php'; ?>
