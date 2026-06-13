<?php
/**
 * Centralized Mailer Utility
 */

namespace App\Utilities;

class Mailer {
    private static $envLoaded = false;
    private static $env = [];

    /**
     * Load environment variables from .env file
     */
    private static function loadEnv() {
        if (self::$envLoaded) {
            return;
        }

        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            if (function_exists('parse_ini_file')) {
                self::$env = @parse_ini_file($envPath);
            }
            if (empty(self::$env)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if (is_array($lines)) {
                    foreach ($lines as $line) {
                        if (strpos(trim($line), '#') === 0) continue;
                        if (strpos($line, '=') !== false) {
                            list($key, $value) = explode('=', $line, 2);
                            self::$env[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
                        }
                    }
                }
            }
        }
        self::$envLoaded = true;
    }

    /**
     * Send an email using PHPMailer or fallback to native mail().
     *
     * @param string|array $to Single email string or array of emails
     * @param string $subject
     * @param string $htmlBody
     * @param string $altBody
     * @param string|null $replyToEmail
     * @param string|null $replyToName
     * @param array $embeddedImages Associative array ['path' => 'cid']
     * @return bool True on success, false on failure
     */
    public static function sendEmail($to, $subject, $htmlBody, $altBody, $replyToEmail = null, $replyToName = null, $embeddedImages = []) {
        self::loadEnv();
        $env = self::$env;

        $autoloadPath = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            require_once $autoloadPath;
        }

        $mailSent = false;
        $errorInfo = '';

        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $debugOutput = '';

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = $env['SMTP_HOST'] ?? 'smtp.gmail.com';
                $mail->SMTPAuth   = !empty($env['SMTP_USER']);
                $mail->Username   = $env['SMTP_USER'] ?? '';
                $mail->Password   = $env['SMTP_PASS'] ?? '';
                
                // Port & Encryption
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
                }

                // Capture SMTP handshake/connection details on failure
                $mail->SMTPDebug = 2;
                $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
                    $debugOutput .= $str . "\n";
                };

                // Sender
                $fromEmail = $env['MAIL_FROM_ADDRESS'] ?? 'info@labourmin.gov.lk';
                $fromName  = $env['MAIL_FROM_NAME'] ?? 'Ministry of Labour Portal';
                $mail->setFrom($fromEmail, $fromName);

                // Recipients
                if (is_array($to)) {
                    foreach ($to as $recipient) {
                        $mail->addAddress($recipient);
                    }
                } else {
                    $mail->addAddress($to);
                }

                if ($replyToEmail) {
                    $mail->addReplyTo($replyToEmail, $replyToName ?? '');
                }

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $htmlBody;
                $mail->AltBody = $altBody;

                foreach ($embeddedImages as $path => $cid) {
                    if (file_exists($path)) {
                        $mail->addEmbeddedImage($path, $cid);
                    }
                }

                $mail->send();
                $mailSent = true;
            } catch (\Exception $e) {
                $errorInfo = $mail->ErrorInfo;
                error_log("Mailer Error: {$errorInfo}");
                $log_message = date('[Y-m-d H:i:s] ') . "Mailer Error: " . $errorInfo . "\n";
                if (!empty($debugOutput)) {
                    $log_message .= "SMTP Debug Log:\n" . $debugOutput . "\n------------------------------------------\n";
                }
                file_put_contents(__DIR__ . '/../mail_error.log', $log_message, FILE_APPEND);
            }
        }

        // Fallback to native mail()
        if (!$mailSent) {
            $fromEmail = $env['MAIL_FROM_ADDRESS'] ?? 'info@labourmin.gov.lk';
            $fromName  = $env['MAIL_FROM_NAME'] ?? 'Ministry of Labour Portal';
            
            $headers = "From: $fromName <$fromEmail>\r\n";
            if ($replyToEmail) {
                $headers .= "Reply-To: $replyToName <$replyToEmail>\r\n";
            }
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            $toString = is_array($to) ? implode(', ', $to) : $to;
            
            if (@mail($toString, $subject, $altBody, $headers)) {
                $mailSent = true;
            } else {
                error_log("Native mail() fallback failed after PHPMailer failure.");
            }
        }

        return $mailSent;
    }

    /**
     * Helper to get env variable
     */
    public static function env($key, $default = null) {
        self::loadEnv();
        return self::$env[$key] ?? $default;
    }
}
