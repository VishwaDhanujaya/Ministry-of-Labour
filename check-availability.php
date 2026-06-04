<?php
require_once 'admin/includes/db.php';

header('Content-Type: application/json');

$start_date = $_GET['start'] ?? '';
$end_date = $_GET['end'] ?? '';

if (!$start_date || !$end_date) {
    echo json_encode(['error' => 'Please select both Check-in and Check-out dates.']);
    exit;
}

if (strtotime($start_date) >= strtotime($end_date)) {
    echo json_encode(['error' => 'Check-out date must be after Check-in date.']);
    exit;
}

try {
    // Use <= and >= to block same-day turnarounds (ensure full day gap)
    // Cast to DATE to prevent any time-based comparison issues
    // Only block dates if the booking is explicitly 'Confirmed' (Pending requests don't block public availability)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE bungalow_name = 'Ampara' AND status = 'Confirmed' AND DATE(start_date) <= DATE(?) AND DATE(end_date) >= DATE(?)");
    $stmt->execute([$end_date, $start_date]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['available' => false, 'message' => 'Sorry, these dates are already booked.']);
    } else {
        echo json_encode(['available' => true, 'message' => 'These dates are available!']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error while checking availability.']);
}
