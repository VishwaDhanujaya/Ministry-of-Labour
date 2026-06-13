<?php
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
} else {
    die("PHPMailer autoload not found. Please ensure vendor folder exists.");
}

$envPath = __DIR__ . '/.env';
$env = [];
if (file_exists($envPath)) {
    if (function_exists('parse_ini_file')) {
        $env = @parse_ini_file($envPath);
    }
    if (empty($env)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (is_array($lines)) {
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $env[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
                }
            }
        }
    }
}

echo "<h2>SMTP Connection Test</h2>";
echo "<pre>";

if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    die("PHPMailer class not found!");
}

$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

try {
    $mail->SMTPDebug = 3; // Detailed debug output
    $mail->Debugoutput = 'html';
    
    $mail->isSMTP();
    $mail->Host       = $env['SMTP_HOST'] ?? 'smtp.gmail.com';
    $mail->SMTPAuth   = !empty($env['SMTP_USER']);
    $mail->Username   = $env['SMTP_USER'] ?? '';
    $mail->Password   = $env['SMTP_PASS'] ?? '';
    
    $port = intval($env['SMTP_PORT'] ?? 587);
    $mail->Port = $port;
    
    $smtpSecure = strtolower($env['SMTP_SECURE'] ?? '');
    if ($smtpSecure === 'ssl') {
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    } elseif ($smtpSecure === 'tls') {
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($smtpSecure === 'none' || $smtpSecure === 'false') {
        $mail->SMTPSecure = '';
        $mail->SMTPAutoTLS = false;
    } else {
        $mail->SMTPSecure = ($port === 465) 
            ? \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS 
            : \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    }

    if (isset($env['SMTP_BYPASS_SSL']) && filter_var($env['SMTP_BYPASS_SSL'], FILTER_VALIDATE_BOOLEAN)) {
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        echo "SSL Bypass is ENABLED.\n";
    }

    echo "Attempting to connect to " . $mail->Host . ":" . $mail->Port . "...\n";
    echo "Using Encryption: " . ($mail->SMTPSecure ? $mail->SMTPSecure : 'None') . "\n";
    echo "--------------------------------------------------------\n\n";

    $fromEmail = $env['MAIL_FROM_ADDRESS'] ?? 'info@labourmin.gov.lk';
    $fromName  = $env['MAIL_FROM_NAME'] ?? 'Ministry of Labour Portal';
    $mail->setFrom($fromEmail, $fromName);
    
    $receiver = $env['CONTACT_RECEIVER'] ?? 'info@labourmin.gov.lk';
    $mail->addAddress($receiver);

    $mail->Subject = 'SMTP Test from Server';
    $mail->Body    = 'This is a test email to verify SMTP configuration.';

    $mail->send();
    echo "\n--------------------------------------------------------\n";
    echo "SUCCESS: Email sent successfully via PHPMailer!\n";

} catch (\Exception $e) {
    echo "\n--------------------------------------------------------\n";
    echo "ERROR: Mailer Error: {$mail->ErrorInfo}\n";
}

echo "</pre>";
?>
