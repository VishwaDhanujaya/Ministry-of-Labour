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
require_once __DIR__ . '/includes/Mailer.php';

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

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $messageBody = $_POST['message'] ?? '';

    // Validate inputs
    if (empty($fullname) || empty($email) || empty($messageBody)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    $receiver = \App\Utilities\Mailer::env('CONTACT_RECEIVER', 'info@labourmin.gov.lk');
    $subject = 'New Contact Form Submission: ' . $fullname;
    $altBody = "New message from $fullname\nEmail: $email\nPhone: $phone\n\nMessage:\n$messageBody";
    
    $htmlContent = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                    background-color: #F3F4F6;
                    margin: 0;
                    padding: 0;
                    -webkit-font-smoothing: antialiased;
                }
                .email-wrapper {
                    padding: 40px 20px;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
                }
                .email-header {
                    background-color: #13273F;
                    padding: 30px;
                    text-align: center;
                    border-bottom: 3px solid #C41E3A;
                }
                .email-header img {
                    height: 55px;
                    margin-bottom: 0;
                    display: inline-block;
                }
                .email-body {
                    padding: 40px 35px;
                    color: #374151;
                }
                .greeting {
                    font-size: 20px;
                    font-weight: 600;
                    color: #111827;
                    margin-top: 0;
                    margin-bottom: 25px;
                    text-align: center;
                }
                .detail-row {
                    margin-bottom: 20px;
                    background-color: #F9FAFB;
                    padding: 15px 20px;
                    border-radius: 8px;
                    border-left: 3px solid #13273F;
                }
                .detail-label {
                    font-size: 12px;
                    color: #6B7280;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                    font-weight: 600;
                }
                .detail-value {
                    font-size: 16px;
                    color: #111827;
                    font-weight: 500;
                }
                .message-box {
                    background-color: #ffffff;
                    border: 1px solid #E5E7EB;
                    border-top: 4px solid #C41E3A;
                    padding: 25px;
                    margin-top: 35px;
                    border-radius: 8px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                }
                .message-title {
                    font-size: 14px;
                    font-weight: 600;
                    color: #1F2937;
                    margin-bottom: 12px;
                    border-bottom: 1px solid #E5E7EB;
                    padding-bottom: 10px;
                }
                .message-text {
                    font-size: 15px;
                    line-height: 1.7;
                    color: #4B5563;
                    white-space: pre-wrap;
                }
                .email-footer {
                    background-color: #F9FAFB;
                    padding: 24px;
                    text-align: center;
                    font-size: 13px;
                    color: #6B7280;
                    border-top: 1px solid #E5E7EB;
                }
                .footer-link {
                    color: #13273F;
                    text-decoration: none;
                    font-weight: 500;
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="email-container">
                    <div class="email-header">
                        <img src="cid:ministry_logo" alt="Ministry of Labour">
                    </div>
                <div class="email-body">
                        <h2 class="greeting">New Message Received</h2>
                        
                        <div class="detail-row">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">' . htmlspecialchars($fullname) . '</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value"><a href="mailto:' . htmlspecialchars($email) . '" style="color: #13273F; text-decoration: none;">' . htmlspecialchars($email) . '</a></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">' . (!empty($phone) ? htmlspecialchars($phone) : '<span style="color: #9CA3AF; font-style: italic;">Not provided</span>') . '</div>
                        </div>
                        
                        <div class="message-box">
                            <div class="message-title">Message Content</div>
                            <div class="message-text">' . nl2br(htmlspecialchars($messageBody)) . '</div>
                        </div>
                    </div>
                    <div class="email-footer">
                        This is an automated notification from the <a href="https://labourmin.gov.lk" class="footer-link">Ministry of Labour Portal</a>.<br>
                        Please do not reply directly to this email address.
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';

    $mailSent = \App\Utilities\Mailer::sendEmail(
        $receiver,
        $subject,
        $htmlContent,
        $altBody,
        $email,
        $fullname,
        [__DIR__ . '/assets/img/logo.png' => 'ministry_logo']
    );

    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Message has been sent']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Please try again later.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
