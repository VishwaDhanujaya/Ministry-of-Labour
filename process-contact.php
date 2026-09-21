<?php
/**
 * Process Contact Form
 *
 * This script processes contact form submissions via AJAX, sends an email notification
 * using PHPMailer, and returns a JSON response.
 *
 * @package MinistryOfLabour
 * @subpackage Contact
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/includes/translations.php';
require_once __DIR__ . '/includes/Mailer.php';
require_once __DIR__ . '/includes/EmailTemplate.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Google reCAPTCHA Verification
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    if (empty($recaptchaResponse)) {
        echo json_encode(['success' => false, 'message' => 'Please check the reCAPTCHA checkbox.']);
        exit;
    }

    $recaptchaSecretKey = $env['RECAPTCHA_SECRET_KEY'] ?? '6LeIxAcTAAAAAGG-vFI1qg6EK68FjK00mFD-9hcY';
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    
    $postData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $verifyUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    if (!$responseData || !$responseData['success']) {
        echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed. Please try again.']);
        exit;
    }

    // CSRF Protection Check
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (empty($submittedToken) || !hash_equals($_SESSION['csrf_token'] ?? '', $submittedToken)) {
        echo json_encode(['success' => false, 'message' => 'Security check failed: Invalid CSRF token.']);
        exit;
    }

    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $messageBody = trim($_POST['message'] ?? '');

    // Validate inputs
    if (empty($fullname) || mb_strlen($fullname) < 2 || preg_match('/\d/', $fullname)) {
        echo json_encode(['success' => false, 'message' => t('val_fullname_required', 'Please enter a valid full name (at least 2 characters, no numbers).')]);
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => t('val_email_invalid', 'Please enter a valid email address.')]);
        exit;
    }

    // Sri Lanka Phone Number Validation (if provided)
    if (!empty($phone)) {
        $cleanedPhone = preg_replace('/\D+/', '', $phone);
        if (!preg_match('/^0\d{9}$/', $cleanedPhone)) {
            echo json_encode(['success' => false, 'message' => t('val_phone_invalid', 'Please enter a valid phone number (exactly 10 digits starting with 0).')]);
            exit;
        }
    }

    if (empty($messageBody) || mb_strlen($messageBody) < 10) {
        echo json_encode(['success' => false, 'message' => t('val_message_short', 'Message must be at least 10 characters long.')]);
        exit;
    }

    $contactData = [
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'message' => $messageBody,
    ];

    $receiver = \App\Utilities\Mailer::env('CONTACT_RECEIVER', 'info@labourmin.gov.lk');
    $subject = 'New Contact Form Submission: ' . $fullname;
    $altBody = "New message from $fullname\nEmail: $email\nPhone: $phone\n\nMessage:\n$messageBody";
    $htmlContent = \App\Utilities\EmailTemplate::contactAdminNotification($contactData);

    $mailSent = \App\Utilities\Mailer::sendEmail(
        $receiver,
        $subject,
        $htmlContent,
        $altBody,
        $email,
        $fullname
    );

    // Send courtesy acknowledgment email to the citizen
    if (!empty($email)) {
        $userSubject = 'Inquiry Acknowledgment - Ministry of Labour Sri Lanka';
        $userHtml = \App\Utilities\EmailTemplate::contactUserAcknowledgment($contactData);
        $userAlt = "Dear $fullname,\n\nThank you for contacting the Ministry of Labour. We have received your message and will review your inquiry.\n\nYour message:\n$messageBody\n\nMinistry of Labour, Sri Lanka";
        
        \App\Utilities\Mailer::sendEmail(
            $email,
            $userSubject,
            $userHtml,
            $userAlt
        );
    }

    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Message has been sent']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Please try again later.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
