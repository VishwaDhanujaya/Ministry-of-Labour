<?php
require_once 'admin/includes/db.php';
require_once 'admin/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ampara-circuit-bungalow-booking.php');
    exit;
}

try {
    // Collect primary data
    $bungalow_name = 'Ampara';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $arrival_time = $_POST['arrival_time'] ?? '';
    $departure_time = $_POST['departure_time'] ?? '';
    $applicant_category = $_POST['applicant_category'] ?? '';
    $entire_bungalow = isset($_POST['entire_bungalow']) ? 'Yes' : 'No';

    // Room info
    $room_type = '';
    $no_of_rooms = 1;

    if ($entire_bungalow === 'Yes') {
        $room_type = 'Entire Bungalow';
        $no_of_rooms = 5; // standard total room capacity
    } else {
        $room_types = $_POST['room_type'] ?? [];
        $room_qtys = $_POST['room_qty'] ?? [];
        $rooms = [];
        $no_of_rooms = 0;
        foreach ($room_types as $rt) {
            $qty = (int)($room_qtys[$rt] ?? 1);
            $no_of_rooms += $qty;
            $rooms[] = $rt . ($qty > 1 ? " (x{$qty})" : "");
        }
        $room_type = implode(', ', $rooms);
    }

    // Applicant Details
    $applicant_name = $_POST['applicant_name'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $is_retired = isset($_POST['is_retired']) && $_POST['is_retired'] === 'Yes' ? 'Yes' : 'No';
    $nic = $_POST['nic'] ?? '';
    $passport_number = $_POST['passport_number'] ?? '';
    $workplace_address = $_POST['workplace_address'] ?? '';
    $residential_address = $_POST['residential_address'] ?? '';
    $phone_office = $_POST['phone_office'] ?? '';
    $phone = $_POST['phone_mobile'] ?? '';
    $email = $_POST['email'] ?? '';

    // Handle File Upload (Disabled)
    $recommendation_file = null;

    // Insert into Bookings
    $stmt = $pdo->prepare("INSERT INTO bookings (
        bungalow_name, applicant_name, designation, is_retired, workplace_address, 
        nic, passport_number, residential_address, phone, phone_office, email, 
        applicant_category, room_type, no_of_rooms, start_date, end_date, 
        arrival_time, departure_time, recommendation_file, entire_bungalow
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $bungalow_name,
        $applicant_name,
        $designation,
        $is_retired,
        $workplace_address,
        $nic,
        $passport_number,
        $residential_address,
        $phone,
        $phone_office,
        $email,
        $applicant_category,
        $room_type,
        $no_of_rooms,
        $start_date,
        $end_date,
        $arrival_time,
        $departure_time,
        $recommendation_file,
        $entire_bungalow
    ]);

    $booking_id = $pdo->lastInsertId();

    // Handle Guests
    $guest_names = $_POST['guest_name'] ?? [];
    $guest_relations = $_POST['guest_relation'] ?? [];
    $guest_nics = $_POST['guest_nic'] ?? [];
    
    if (!empty($guest_names) && is_array($guest_names)) {
        $guest_stmt = $pdo->prepare("INSERT INTO booking_guests (booking_id, guest_name, relationship, nic) VALUES (?, ?, ?, ?)");
        for ($i = 0; $i < count($guest_names); $i++) {
            $g_name = $guest_names[$i] ?? '';
            $g_rel = $guest_relations[$i] ?? '';
            $g_nic = $guest_nics[$i] ?? '';
            if (!empty($g_name)) {
                $guest_stmt->execute([$booking_id, $g_name, $g_rel, $g_nic]);
            }
        }
    }

    // Redirect to success
    header('Location: ampara-circuit-bungalow-booking?success=1');
    exit;

} catch (Exception $e) {
    error_log("Booking submission failed: " . $e->getMessage());
    header('Location: ampara-circuit-bungalow-booking?error=submission_failed');
    exit;
}
