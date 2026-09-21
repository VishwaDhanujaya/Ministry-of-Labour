<?php
/**
 * Centralized Email Template Engine for Ministry of Labour
 * 
 * Provides consistent, responsive, table-based HTML email templates
 * compatible with Gmail, Outlook, Apple Mail, iOS/Android and webmail clients.
 * 
 * @package MinistryOfLabour
 * @subpackage Utilities
 */

namespace App\Utilities;

class EmailTemplate {

    /**
     * Wrap content with standard Ministry of Labour email shell
     * 
     * @param string $title Page / Email Title
     * @param string $preheader Short summary text visible in email preview
     * @param string $bodyContent HTML content of the email body
     * @return string Complete HTML document
     */
    public static function wrap($title, $preheader, $bodyContent) {
        $year = date('Y');
        $portalUrl = Mailer::env('APP_URL', 'https://labourmin.gov.lk');
        
        return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>' . htmlspecialchars($title) . '</title>
    <!--[if mso]>
    <style>
        * { font-family: "Segoe UI", Arial, sans-serif !important; }
    </style>
    <![endif]-->
    <style type="text/css">
        html, body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background-color: #F1F5F9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        img {
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
            border: 0;
            outline: none;
            text-decoration: none;
        }
        a {
            text-decoration: none;
            color: #13273F;
        }
        /* Mobile Breakpoints */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }
            .mobile-p-20 {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            .mobile-py-24 {
                padding-top: 24px !important;
                padding-bottom: 24px !important;
            }
            .stack-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .mobile-text-center {
                text-align: center !important;
            }
            .detail-label-col {
                width: 100% !important;
                display: block !important;
                padding-bottom: 4px !important;
            }
            .detail-val-col {
                width: 100% !important;
                display: block !important;
                padding-left: 0 !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F1F5F9; min-width: 100%;">
    <!-- Preheader Text (Invisible in body, visible in inbox list) -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        ' . htmlspecialchars($preheader) . '
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>

    <!-- Outer Wrapper -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F1F5F9;">
        <tr>
            <td align="center" style="padding: 30px 12px 40px 12px;">
                <!-- Main 600px Container -->
                <table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(19, 39, 63, 0.08); border: 1px solid #E2E8F0;">
                    
                    <!-- Top Gold & Maroon Accent Bar -->
                    <tr>
                        <td style="background: #4E0000; height: 5px; font-size: 0; line-height: 0; border-top: 3px solid #D97706;">&nbsp;</td>
                    </tr>

                    <!-- Header Section -->
                    <tr>
                        <td style="background-color: #13273F; padding: 26px 32px; text-align: center;" class="mobile-p-20">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="vertical-align: middle;">
                                                    <img src="cid:ministry_logo" alt="Ministry of Labour - Sri Lanka" style="height: 52px; width: auto; display: block; border: 0;" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 10px;">
                                        <span style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: #94A3B8; font-weight: 600; display: block;">
                                            Democratic Socialist Republic of Sri Lanka
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content Slot -->
                    <tr>
                        <td style="padding: 36px 36px 30px 36px;" class="mobile-p-20 mobile-py-24">
                            ' . $bodyContent . '
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td style="background-color: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 28px 32px; text-align: center;" class="mobile-p-20">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13px; font-weight: 700; color: #13273F; letter-spacing: 0.5px;">
                                        MINISTRY OF LABOUR
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 12px; color: #64748B; padding-top: 6px; line-height: 1.6;">
                                        "Mehewara Piyasa", P.O. Box 575, Narahenpita, Colombo 05, Sri Lanka.<br>
                                        Hotline: <strong style="color: #13273F;">1919</strong> | General: <strong style="color: #13273F;">+94 11 258 1903</strong> | Web: <a href="' . htmlspecialchars($portalUrl) . '" style="color: #13273F; font-weight: 600; text-decoration: underline;">labourmin.gov.lk</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 18px;">
                                        <div style="height: 1px; background-color: #E2E8F0; width: 60%; margin: 0 auto;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 11px; color: #94A3B8; padding-top: 14px; line-height: 1.5;">
                                        This is an automated administrative notification dispatched by the Ministry of Labour Web Portal.<br>
                                        Please do not reply directly to this automated email address unless otherwise instructed.
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 11px; color: #CBD5E1; padding-top: 8px;">
                                        &copy; ' . $year . ' Ministry of Labour - Sri Lanka. All Rights Reserved.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
                <!-- End 600px Container -->
            </td>
        </tr>
    </table>
</body>
</html>';
    }

    /**
     * Render a styled badge component
     */
    public static function renderBadge($label, $type = 'info') {
        $colors = [
            'success' => ['bg' => '#ECFDF5', 'text' => '#065F46', 'border' => '#A7F3D0'],
            'warning' => ['bg' => '#FFFBEB', 'text' => '#92400E', 'border' => '#FDE68A'],
            'danger'  => ['bg' => '#FEF2F2', 'text' => '#991B1B', 'border' => '#FECACA'],
            'info'    => ['bg' => '#EFF6FF', 'text' => '#1E40AF', 'border' => '#BFDBFE'],
            'navy'    => ['bg' => '#F1F5F9', 'text' => '#13273F', 'border' => '#CBD5E1'],
            'maroon'  => ['bg' => '#FDF2F2', 'text' => '#4E0000', 'border' => '#F87171'],
        ];

        $c = $colors[$type] ?? $colors['info'];

        return '<span style="display: inline-block; background-color: ' . $c['bg'] . '; color: ' . $c['text'] . '; border: 1px solid ' . $c['border'] . '; padding: 5px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif;">' . htmlspecialchars($label) . '</span>';
    }

    /**
     * Render a structured details table card
     */
    public static function renderDetailsTable(array $rows, $heading = null) {
        $html = '';
        if ($heading) {
            $html .= '<div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; font-weight: 700; color: #13273F; text-transform: uppercase; letter-spacing: 0.75px; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 2px solid #E2E8F0;">' . htmlspecialchars($heading) . '</div>';
        }

        $html .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; overflow: hidden; margin-bottom: 24px;">';
        
        $rowIndex = 0;
        $totalRows = count($rows);
        foreach ($rows as $label => $value) {
            $borderBottom = ($rowIndex < $totalRows - 1) ? 'border-bottom: 1px solid #EDF2F7;' : '';
            $html .= '<tr>
                <td class="detail-label-col" width="38%" style="padding: 12px 18px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 12.5px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.4px; vertical-align: top; ' . $borderBottom . '">
                    ' . htmlspecialchars($label) . '
                </td>
                <td class="detail-val-col" width="62%" style="padding: 12px 18px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; font-weight: 500; color: #1E293B; vertical-align: top; ' . $borderBottom . '">
                    ' . $value . '
                </td>
            </tr>';
            $rowIndex++;
        }

        $html .= '</table>';
        return $html;
    }

    /**
     * Render an informative Callout Box
     */
    public static function renderCallout($content, $type = 'info', $title = null) {
        $styles = [
            'info' => [
                'bg' => '#F0F9FF', 'border' => '#0284C7', 'text' => '#0369A1', 'icon' => 'ℹ️',
            ],
            'success' => [
                'bg' => '#F0FDF4', 'border' => '#16A34A', 'text' => '#15803D', 'icon' => '✓',
            ],
            'warning' => [
                'bg' => '#FFFBEB', 'border' => '#D97706', 'text' => '#B45309', 'icon' => '⚠️',
            ],
            'danger' => [
                'bg' => '#FEF2F2', 'border' => '#DC2626', 'text' => '#B91C1C', 'icon' => '✕',
            ],
            'navy' => [
                'bg' => '#F8FAFC', 'border' => '#13273F', 'text' => '#334155', 'icon' => '🏛️',
            ],
        ];

        $s = $styles[$type] ?? $styles['info'];

        $html = '<div style="background-color: ' . $s['bg'] . '; border-left: 4px solid ' . $s['border'] . '; border-radius: 8px; padding: 18px 20px; margin: 24px 0;">';
        if ($title) {
            $html .= '<div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; font-weight: 700; color: ' . $s['border'] . '; margin-bottom: 6px;">' . htmlspecialchars($title) . '</div>';
        }
        $html .= '<div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13.5px; line-height: 1.6; color: ' . $s['text'] . ';">' . $content . '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Render a Primary Action Button
     */
    public static function renderButton($url, $label, $color = '#13273F') {
        return '<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 28px auto 20px auto;">
            <tr>
                <td align="center" style="border-radius: 8px; background-color: ' . $color . ';">
                    <a href="' . htmlspecialchars($url) . '" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; padding: 14px 32px; display: inline-block; border-radius: 8px; letter-spacing: 0.5px; text-transform: uppercase;">
                        ' . htmlspecialchars($label) . ' &rarr;
                    </a>
                </td>
            </tr>
        </table>';
    }

    /* =========================================================================
       SPECIFIC EMAIL TEMPLATE BUILDERS
       ========================================================================= */

    /**
     * 1. Contact Form Submission (Dispatched to Admin / Ministry Office)
     */
    public static function contactAdminNotification(array $data) {
        $fullname = $data['fullname'] ?? 'Anonymous Citizen';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $messageBody = $data['message'] ?? '';
        $submittedAt = date('F j, Y - g:i A (T)');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

        $preheader = "New citizen message from " . $fullname . " (" . $email . ")";
        $title = "New Contact Form Submission";

        $badge = self::renderBadge('Citizen Inquiry', 'navy');

        $rows = [
            'Full Name' => '<strong>' . htmlspecialchars($fullname) . '</strong>',
            'Email Address' => '<a href="mailto:' . htmlspecialchars($email) . '" style="color: #13273F; font-weight: 600; text-decoration: underline;">' . htmlspecialchars($email) . '</a>',
            'Phone Number' => !empty($phone) ? '<a href="tel:' . htmlspecialchars($phone) . '" style="color: #13273F; text-decoration: none;">' . htmlspecialchars($phone) . '</a>' : '<span style="color: #94A3B8; font-style: italic;">Not provided</span>',
            'Submitted At' => htmlspecialchars($submittedAt),
            'Sender IP' => '<code style="background-color: #EDF2F7; padding: 2px 6px; border-radius: 4px; font-size: 12px; color: #475569;">' . htmlspecialchars($ip) . '</code>',
        ];

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #13273F; margin: 0 0 6px 0; letter-spacing: -0.25px;">
                New Website Inquiry Received
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                A citizen has submitted a new message through the public contact portal.
            </p>
        </div>

        ' . self::renderDetailsTable($rows, 'Sender Particulars') . '

        <div style="margin-top: 24px;">
            <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13.5px; font-weight: 700; color: #13273F; text-transform: uppercase; letter-spacing: 0.75px; margin-bottom: 10px;">
                Message Content
            </div>
            <div style="background-color: #FFFFFF; border: 1px solid #CBD5E1; border-top: 4px solid #C41E3A; border-radius: 8px; padding: 22px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; white-space: pre-wrap; word-break: break-word; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
' . nl2br(htmlspecialchars($messageBody)) . '
            </div>
        </div>

        ' . self::renderButton('mailto:' . $email . '?subject=Re: Your Inquiry to Ministry of Labour', 'Reply Directly via Email');

        return self::wrap($title, $preheader, $body);
    }

    /**
     * 2. Contact Form Acknowledgment (Dispatched to Citizen)
     */
    public static function contactUserAcknowledgment(array $data) {
        $fullname = $data['fullname'] ?? 'Valued Citizen';
        $email = $data['email'] ?? '';
        $messageBody = $data['message'] ?? '';
        $refId = 'MOL-CNT-' . date('ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $preheader = "We have received your message (Ref: " . $refId . "). Thank you for reaching out.";
        $title = "Inquiry Acknowledgment - Ministry of Labour";

        $badge = self::renderBadge('Inquiry Acknowledged', 'success');

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #13273F; margin: 0 0 6px 0;">
                Thank You for Contacting Us
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                Reference Number: <strong style="color: #13273F;">' . htmlspecialchars($refId) . '</strong>
            </p>
        </div>

        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 18px;">
            Dear <strong>' . htmlspecialchars($fullname) . '</strong>,
        </p>
        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
            This is an official acknowledgment that your message sent via the Ministry of Labour online portal has been successfully logged into our system. Our relevant department or officer will review your inquiry and get back to you if a response is required.
        </p>

        <div style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
            <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                Summary of your submitted message:
            </div>
            <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13.5px; line-height: 1.6; color: #475569; font-style: italic; white-space: pre-wrap;">
"' . nl2br(htmlspecialchars($messageBody)) . '"
            </div>
        </div>

        ' . self::renderCallout('For urgent labour-related inquiries or grievance escalation, please call the Government Information Center Hotline <strong>1919</strong> or the Ministry helpline at <strong>+94 11 258 1903</strong> during official working hours (8:30 AM – 4:15 PM on government working days).', 'info', 'Need Urgent Assistance?') . '

        ' . self::renderButton(Mailer::env('APP_URL', 'https://labourmin.gov.lk'), 'Visit Official Ministry Portal');

        return self::wrap($title, $preheader, $body);
    }

    /**
     * 3. Circuit Bungalow Booking Submitted (Dispatched to Applicant)
     */
    public static function bungalowBookingSubmittedApplicant(array $data) {
        $bookingId = $data['id'] ?? 'Pending';
        $applicantName = $data['applicant_name'] ?? 'Applicant';
        $bungalowName = $data['bungalow_name'] ?? 'Ampara Circuit Bungalow';
        $roomType = $data['room_type'] ?? 'Room';
        $startDate = $data['start_date'] ?? '';
        $endDate = $data['end_date'] ?? '';
        $arrivalTime = $data['arrival_time'] ?? '2:00 PM';
        $departureTime = $data['departure_time'] ?? '12:00 PM';
        $phone = $data['phone'] ?? '';
        $refCode = 'MOL-BKG-' . str_pad($bookingId, 5, '0', STR_PAD_LEFT);

        $preheader = "Your booking request {$refCode} for {$bungalowName} has been received and is pending verification.";
        $title = "Bungalow Booking Request Received - " . $refCode;

        $badge = self::renderBadge('Pending Document Verification', 'warning');

        $details = [
            'Booking Reference' => '<strong>' . htmlspecialchars($refCode) . '</strong>',
            'Bungalow Location' => htmlspecialchars($bungalowName),
            'Reserved Space' => htmlspecialchars($roomType),
            'Check-In Date' => '<strong>' . htmlspecialchars($startDate) . '</strong> (' . htmlspecialchars($arrivalTime) . ')',
            'Check-Out Date' => '<strong>' . htmlspecialchars($endDate) . '</strong> (' . htmlspecialchars($departureTime) . ')',
            'Applicant Name' => htmlspecialchars($applicantName),
            'Contact Mobile' => htmlspecialchars($phone),
            'Status' => '<span style="color: #D97706; font-weight: 700;">Pending Administrative Approval</span>',
        ];

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #13273F; margin: 0 0 6px 0;">
                Bungalow Booking Request Received
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                Application Reference: <strong style="color: #13273F;">' . htmlspecialchars($refCode) . '</strong>
            </p>
        </div>

        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 18px;">
            Dear <strong>' . htmlspecialchars($applicantName) . '</strong>,
        </p>
        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
            Thank you for applying to reserve the <strong>' . htmlspecialchars($bungalowName) . '</strong>. We have received your application details along with your submitted payment receipt.
        </p>

        ' . self::renderDetailsTable($details, 'Reservation Particulars') . '

        ' . self::renderCallout('<strong>Next Step:</strong> Our administrative officers will review your application and verify your uploaded payment slip. You will receive an official email notification as soon as your booking status is updated to <strong>Confirmed</strong>.<br><br>Please keep your Reference Code <strong>' . htmlspecialchars($refCode) . '</strong> safe for all future correspondence.', 'warning', 'Verification in Progress') . '

        <div style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 20px; margin-top: 24px;">
            <div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13px; font-weight: 700; color: #13273F; margin-bottom: 8px;">
                Important Information:
            </div>
            <ul style="margin: 0; padding-left: 20px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13px; color: #64748B; line-height: 1.6;">
                <li>Please bring your original National Identity Card (NIC) / Passport at the time of check-in.</li>
                <li>Ensure all guests accompanying you comply with standard Circuit Bungalow administrative rules and regulations.</li>
                <li>For any inquiries regarding your booking, please reach out to the Welfare & Administration Division.</li>
            </ul>
        </div>';

        return self::wrap($title, $preheader, $body);
    }

    /**
     * 4. Circuit Bungalow Booking Submitted (Dispatched to Admin Officers)
     */
    public static function bungalowBookingSubmittedAdmin(array $data) {
        $bookingId = $data['id'] ?? 'N/A';
        $applicantName = $data['applicant_name'] ?? 'Applicant';
        $bungalowName = $data['bungalow_name'] ?? 'Ampara Circuit Bungalow';
        $roomType = $data['room_type'] ?? 'Room';
        $category = $data['applicant_category'] ?? 'General Public';
        $startDate = $data['start_date'] ?? '';
        $endDate = $data['end_date'] ?? '';
        $phone = $data['phone'] ?? '';
        $email = $data['email'] ?? '';
        $nic = $data['nic'] ?? '';
        $adminDashboardUrl = Mailer::env('APP_URL', 'https://labourmin.gov.lk') . '/admin/bungalow-bookings';
        $refCode = 'MOL-BKG-' . str_pad($bookingId, 5, '0', STR_PAD_LEFT);

        $preheader = "New Bungalow Booking {$refCode} submitted by {$applicantName} requires review.";
        $title = "Action Required: New Bungalow Booking - " . $refCode;

        $badge = self::renderBadge('New Booking Submission', 'navy');

        $details = [
            'Booking ID / Ref' => '<strong>' . htmlspecialchars($refCode) . '</strong>',
            'Applicant Name' => '<strong>' . htmlspecialchars($applicantName) . '</strong>',
            'Applicant Category' => htmlspecialchars($category),
            'NIC / Identification' => htmlspecialchars($nic),
            'Contact Mobile' => htmlspecialchars($phone),
            'Applicant Email' => '<a href="mailto:' . htmlspecialchars($email) . '" style="color: #13273F;">' . htmlspecialchars($email) . '</a>',
            'Bungalow / Space' => htmlspecialchars($bungalowName) . ' &mdash; ' . htmlspecialchars($roomType),
            'Stay Duration' => htmlspecialchars($startDate) . ' to ' . htmlspecialchars($endDate),
            'Status' => '<span style="color: #D97706; font-weight: 700;">Pending Review</span>',
        ];

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #13273F; margin: 0 0 6px 0;">
                New Circuit Bungalow Booking
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                A new reservation request has been registered and is waiting for payment verification.
            </p>
        </div>

        ' . self::renderDetailsTable($details, 'Applicant & Booking Details') . '

        ' . self::renderCallout('Please log in to the Administrative Management Panel to inspect the uploaded bank payment slip and approve or reject this booking request.', 'navy', 'Action Required') . '

        ' . self::renderButton($adminDashboardUrl, 'Open Bookings Dashboard');

        return self::wrap($title, $preheader, $body);
    }

    /**
     * 5. Circuit Bungalow Booking Status Update (Confirmed / Cancelled)
     */
    public static function bungalowBookingStatusUpdate(array $data, $status) {
        $bookingId = $data['id'] ?? '0';
        $applicantName = $data['applicant_name'] ?? 'Applicant';
        $bungalowName = $data['bungalow_name'] ?? 'Ampara Circuit Bungalow';
        $roomType = $data['room_type'] ?? 'Room';
        $startDate = $data['start_date'] ?? '';
        $endDate = $data['end_date'] ?? '';
        $arrivalTime = $data['arrival_time'] ?? '2:00 PM';
        $departureTime = $data['departure_time'] ?? '12:00 PM';
        $refCode = 'MOL-BKG-' . str_pad($bookingId, 5, '0', STR_PAD_LEFT);

        $isConfirmed = (strtolower($status) === 'confirmed');

        if ($isConfirmed) {
            $title = "Booking CONFIRMED: {$bungalowName} - {$refCode}";
            $preheader = "Your booking request {$refCode} for {$bungalowName} has been officially CONFIRMED.";
            $badge = self::renderBadge('Booking Confirmed', 'success');
            $headline = "Your Reservation is Confirmed!";
            $headlineColor = "#065F46";
        } else {
            $title = "Booking Status Update: {$bungalowName} - {$refCode}";
            $preheader = "Your booking request {$refCode} for {$bungalowName} has been CANCELLED.";
            $badge = self::renderBadge('Booking Cancelled', 'danger');
            $headline = "Booking Request Cancelled";
            $headlineColor = "#991B1B";
        }

        $details = [
            'Booking Reference' => '<strong>' . htmlspecialchars($refCode) . '</strong>',
            'Bungalow Name' => htmlspecialchars($bungalowName),
            'Reserved Accommodation' => htmlspecialchars($roomType),
            'Check-In' => '<strong>' . htmlspecialchars($startDate) . '</strong> (' . htmlspecialchars($arrivalTime) . ')',
            'Check-Out' => '<strong>' . htmlspecialchars($endDate) . '</strong> (' . htmlspecialchars($departureTime) . ')',
            'Applicant Name' => htmlspecialchars($applicantName),
            'Status' => $isConfirmed 
                ? '<span style="color: #059669; font-weight: 700;">CONFIRMED</span>' 
                : '<span style="color: #DC2626; font-weight: 700;">CANCELLED</span>',
        ];

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: ' . $headlineColor . '; margin: 0 0 6px 0;">
                ' . $headline . '
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                Official Booking Reference: <strong style="color: #13273F;">' . htmlspecialchars($refCode) . '</strong>
            </p>
        </div>

        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 18px;">
            Dear <strong>' . htmlspecialchars($applicantName) . '</strong>,
        </p>';

        if ($isConfirmed) {
            $body .= '
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
                We are pleased to inform you that your reservation for the <strong>' . htmlspecialchars($bungalowName) . '</strong> has been <strong>CONFIRMED</strong> by the Ministry of Labour Administration.
            </p>

            ' . self::renderDetailsTable($details, 'Confirmed Reservation Details') . '

            ' . self::renderCallout('
                <strong>Check-In Instructions:</strong><br>
                1. Please present this confirmation email (digital or printed) along with your original National Identity Card (NIC) to the bungalow caretaker upon arrival.<br>
                2. Standard Check-In time is <strong>' . htmlspecialchars($arrivalTime) . '</strong> and Check-Out is <strong>' . htmlspecialchars($departureTime) . '</strong>.<br>
                3. Maintain strict decorum and abide by the government circuit bungalow code of conduct during your stay.
            ', 'success', 'Important Instructions for Check-In') . '

            <div style="text-align: center; margin-top: 24px;">
                <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 13.5px; color: #64748B; margin: 0;">
                    We wish you a pleasant and comfortable stay!
                </p>
            </div>';
        } else {
            $body .= '
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
                We regret to inform you that your booking request for the <strong>' . htmlspecialchars($bungalowName) . '</strong> could not be approved and has been <strong>CANCELLED</strong>.
            </p>

            ' . self::renderDetailsTable($details, 'Cancelled Request Details') . '

            ' . self::renderCallout('This cancellation may be due to date unavailability, incomplete or unverified payment slip, or official government scheduling priorities. If you believe this is an error or require a refund/rebooking, please contact the Welfare Division at <strong>+94 11 258 1903</strong> referencing Code <strong>' . htmlspecialchars($refCode) . '</strong>.', 'danger', 'Reason for Cancellation & Support') . '

            ' . self::renderButton(Mailer::env('APP_URL', 'https://labourmin.gov.lk') . '/ampara-circuit-bungalow', 'View Alternative Dates');
        }

        return self::wrap($title, $preheader, $body);
    }

    /**
     * 6. Admin Account Created / Welcome Notification
     */
    public static function adminWelcomeEmail(array $data) {
        $name = $data['name'] ?? 'Administrator';
        $email = $data['email'] ?? '';
        $role = $data['role'] ?? 'content_editor';
        $portalUrl = Mailer::env('APP_URL', 'https://labourmin.gov.lk') . '/admin/login';

        $preheader = "Your administrative account for Ministry of Labour Portal has been created.";
        $title = "Welcome to Ministry of Labour Administration";

        $badge = self::renderBadge('Staff Account Access', 'navy');

        $roleLabel = ($role === 'executive_officer') ? 'Executive Officer (Super Admin)' : 'Content Editor';

        $details = [
            'Staff Name' => '<strong>' . htmlspecialchars($name) . '</strong>',
            'Authorized Email' => htmlspecialchars($email),
            'Assigned Role' => '<strong>' . htmlspecialchars($roleLabel) . '</strong>',
            'Portal URL' => '<a href="' . htmlspecialchars($portalUrl) . '" style="color: #13273F;">' . htmlspecialchars($portalUrl) . '</a>',
        ];

        $body = '
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">' . $badge . '</div>
            <h1 style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #13273F; margin: 0 0 6px 0;">
                Welcome to the Admin Portal
            </h1>
            <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14px; color: #64748B; margin: 0;">
                Your administrative privileges have been configured.
            </p>
        </div>

        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 18px;">
            Dear <strong>' . htmlspecialchars($name) . '</strong>,
        </p>
        <p style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif; font-size: 14.5px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
            An administrative account has been provisioned for you on the official Ministry of Labour Content Management System. You may now log in to access your designated dashboard modules.
        </p>

        ' . self::renderDetailsTable($details, 'Account Overview') . '

        ' . self::renderCallout('<strong>Security Notice:</strong> Please protect your login credentials and never share your administrative password. If you did not request this access, please notify the Ministry IT Security Officer immediately.', 'warning', 'Security Best Practices') . '

        ' . self::renderButton($portalUrl, 'Log In to CMS Dashboard');

        return self::wrap($title, $preheader, $body);
    }
}
