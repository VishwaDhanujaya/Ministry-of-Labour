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
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
}

$envPath = __DIR__ . '/.env';
$env = file_exists($envPath) ? parse_ini_file($envPath) : [];

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $mailSent = false;

    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $env['SMTP_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $env['SMTP_USER'] ?? '';
        $mail->Password   = $env['SMTP_PASS'] ?? '';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $env['SMTP_PORT'] ?? 587;

        // Recipients
        $fromEmail = $env['MAIL_FROM_ADDRESS'] ?? 'info@labourmin.gov.lk';
        $fromName  = $env['MAIL_FROM_NAME'] ?? 'Ministry of Labour Portal';
        $mail->setFrom($fromEmail, $fromName);
        
        $receiver = $env['CONTACT_RECEIVER'] ?? 'info@labourmin.gov.lk';
        $mail->addAddress($receiver);
        
        $mail->addReplyTo($email, $fullname);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission: ' . $fullname;

        // Embed the logo
        $mail->addEmbeddedImage(__DIR__ . '/assets/img/logo.png', 'ministry_logo');

        // Beautiful HTML UI
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

        $mail->Body    = $htmlContent;
        $mail->AltBody = "New message from $fullname\nEmail: $email\nPhone: $phone\n\nMessage:\n$messageBody";

            $mail->send();
            $mailSent = true;
            echo json_encode(['success' => true, 'message' => 'Message has been sent']);
        } catch (\Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
        }
    }

    if (!$mailSent) {
        // Native mail() fallback
        $receiver = $env['CONTACT_RECEIVER'] ?? 'info@labourmin.gov.lk';
        $fromEmail = $env['MAIL_FROM_ADDRESS'] ?? 'info@labourmin.gov.lk';
        $fromName  = $env['MAIL_FROM_NAME'] ?? 'Ministry of Labour Portal';
        
        $subject = 'New Contact Form Submission: ' . $fullname;
        $textBody = "New message from $fullname\nEmail: $email\nPhone: $phone\n\nMessage:\n$messageBody";
        
        $headers = "From: $fromName <$fromEmail>\r\n";
        $headers .= "Reply-To: $fullname <$email>\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        if (@mail($receiver, $subject, $textBody, $headers)) {
            echo json_encode(['success' => true, 'message' => 'Message has been sent']);
        } else {
            error_log("Native mail() fallback failed.");
            echo json_encode(['success' => false, 'message' => 'Message could not be sent. Please try again later.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
