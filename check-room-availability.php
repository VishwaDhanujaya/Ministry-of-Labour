<?php
/**
 * Check Room Availability
 *
 * This script handles AJAX requests to check room availability for a given date range.
 *
 * @package MinistryOfLabour
 * @subpackage Bookings
 */
require_once 'admin/includes/db.php';

header('Content-Type: application/json');

$start_date = $_GET['start'] ?? '';
$end_date = $_GET['end'] ?? '';

if (!$start_date || !$end_date) {
    echo json_encode(['success' => false, 'message' => 'Please select both Check-in and Check-out dates.']);
    exit;
}

if (strtotime($start_date) >= strtotime($end_date)) {
    echo json_encode(['success' => false, 'message' => 'Check-out date must be after Check-in date.']);
    exit;
}

// Room capacities
$capacities = [
    'Ground Floor Double Room (AC)' => 1,
    'Ground Floor Single Room (AC)' => 1,
    'Chalet Room (Single AC)' => 1,
    'Upper Floor Double Room (AC)' => 3,
    'Driver\'s Room (Single Non-AC)' => 1,
    'Entire Bungalow' => 1
];

// Room labels for the dropdown
$labels = [
    'Ground Floor Double Room (AC)' => 'Ground Floor Double Room (AC) - Max 2 Guests',
    'Ground Floor Single Room (AC)' => 'Ground Floor Single Room (AC) - Max 1 Guest',
    'Chalet Room (Single AC)' => 'Chalet Room (Single AC) - Max 1 Guest',
    'Upper Floor Double Room (AC)' => 'Upper Floor Double Room (AC) - Max 4 Guests',
    'Driver\'s Room (Single Non-AC)' => 'Driver\'s Room (Single Non-AC) - Max 2 Guests',
    'Entire Bungalow' => 'Entire Bungalow'
];

try {
    // Get confirmed bookings that overlap with the selected dates
    // Using <= and >= to match the existing logic of blocking same-day turnarounds
    $stmt = $pdo->prepare("SELECT room_type, SUM(no_of_rooms) as count FROM bookings WHERE bungalow_name = 'Ampara' AND status = 'Confirmed' AND DATE(start_date) <= DATE(?) AND DATE(end_date) >= DATE(?) GROUP BY room_type");
    $stmt->execute([$end_date, $start_date]);
    $booked_rooms = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    $entire_bungalow_booked = isset($booked_rooms['Entire Bungalow']) ? $booked_rooms['Entire Bungalow'] > 0 : false;
    $any_individual_room_booked = false;
    
    foreach ($booked_rooms as $type => $count) {
        if ($type !== 'Entire Bungalow' && $count > 0) {
            $any_individual_room_booked = true;
            break;
        }
    }
    
    $available_rooms = [];
    
    if (!$entire_bungalow_booked) {
        // Check individual rooms
        foreach ($capacities as $type => $capacity) {
            if ($type === 'Entire Bungalow') continue;
            
            $booked_count = $booked_rooms[$type] ?? 0;
            $available_count = $capacity - $booked_count;
            if ($available_count > 0) {
                $available_rooms[] = [
                    'value' => $type,
                    'label' => $labels[$type],
                    'max_available' => $available_count
                ];
            }
        }
        
        // Check Entire Bungalow
        if (!$any_individual_room_booked) {
            $available_rooms[] = [
                'value' => 'Entire Bungalow',
                'label' => $labels['Entire Bungalow'],
                'max_available' => 1
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'available_rooms' => $available_rooms,
        'message' => empty($available_rooms) ? 'No rooms available for the selected dates.' : 'Rooms available!'
    ]);
    
} catch (Exception $e) {
    error_log("Database error while checking availability: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error while checking availability.']);
}
