<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'geminiuser677@gmail.com';
        $mail->Password   = 'ujepkuyrasymzaym';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('geminiuser677@gmail.com', 'Ministry of Labour Portal');
        $mail->addAddress('info@labourmin.gov.lk');
        $mail->addReplyTo($email, $fullname);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission: ' . $fullname;

        // Beautiful HTML UI
        $htmlContent = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f4f7f6;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 600px;
                    margin: 40px auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                }
                .email-header {
                    background-color: #13273F;
                    color: #ffffff;
                    padding: 30px;
                    text-align: center;
                }
                .email-header h1 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 600;
                    letter-spacing: 1px;
                }
                .email-body {
                    padding: 40px 30px;
                    color: #333333;
                }
                .detail-row {
                    margin-bottom: 20px;
                    border-bottom: 1px solid #eeeeee;
                    padding-bottom: 15px;
                }
                .detail-label {
                    font-size: 13px;
                    color: #888888;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin-bottom: 5px;
                }
                .detail-value {
                    font-size: 16px;
                    color: #222222;
                    font-weight: 500;
                }
                .message-box {
                    background-color: #f9f9f9;
                    border-left: 4px solid #C41E3A;
                    padding: 20px;
                    margin-top: 30px;
                    border-radius: 4px;
                }
                .message-text {
                    font-size: 15px;
                    line-height: 1.6;
                    color: #444444;
                    white-space: pre-wrap;
                }
                .email-footer {
                    background-color: #f9f9f9;
                    padding: 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #999999;
                    border-top: 1px solid #eeeeee;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <h1>New Message Received</h1>
                </div>
                <div class="email-body">
                    <div class="detail-row">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value">' . htmlspecialchars($fullname) . '</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value">' . htmlspecialchars($email) . '</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Phone Number</div>
                        <div class="detail-value">' . (!empty($phone) ? htmlspecialchars($phone) : '<em>Not provided</em>') . '</div>
                    </div>
                    
                    <div class="message-box">
                        <div class="detail-label">Message Content</div>
                        <div class="message-text">' . nl2br(htmlspecialchars($messageBody)) . '</div>
                    </div>
                </div>
                <div class="email-footer">
                    This email was automatically generated from the Ministry of Labour website contact form.
                </div>
            </div>
        </body>
        </html>
        ';

        $mail->Body    = $htmlContent;
        $mail->AltBody = "New message from $fullname\nEmail: $email\nPhone: $phone\n\nMessage:\n$messageBody";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
