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

// Room capacities
$capacities = [
    'VIP Room' => 1,
    'A/C Triple Room' => 1,
    'A/C Double Room' => 1,
    'Entire Bungalow' => 1
];

// Room labels for the dropdown
$labels = [
    'A/C Double Room' => 'A/C Double Room (2 Guests)',
    'A/C Triple Room' => 'A/C Triple Room (3 Guests)',
    'VIP Room' => 'VIP Room (Suite - 2 Guests)',
    'Entire Bungalow' => 'Entire Bungalow'
];

try {
    // Get confirmed bookings that overlap with the selected dates
    // Using <= and >= to match the existing logic of blocking same-day turnarounds
    $stmt = $pdo->prepare("SELECT room_type, COUNT(*) as count FROM bookings WHERE bungalow_name = 'Ampara' AND status = 'Confirmed' AND DATE(start_date) <= DATE(?) AND DATE(end_date) >= DATE(?) GROUP BY room_type");
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
            if ($booked_count < $capacity) {
                $available_rooms[] = [
                    'value' => $type,
                    'label' => $labels[$type]
                ];
            }
        }
        
        // Check Entire Bungalow
        if (!$any_individual_room_booked) {
            $available_rooms[] = [
                'value' => 'Entire Bungalow',
                'label' => $labels['Entire Bungalow']
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'available_rooms' => $available_rooms,
        'message' => empty($available_rooms) ? 'No rooms available for the selected dates.' : 'Rooms available!'
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error while checking availability.']);
}
