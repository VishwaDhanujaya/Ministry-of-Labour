<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once dirname(__DIR__) . '/includes/Cache.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$csrfToken = $input['csrf_token'] ?? ($_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''));
if (empty($csrfToken) || !verifyCsrfToken($csrfToken)) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token or session expired.']);
    exit;
}

$text = $input['text'] ?? '';
$fromLang = $input['from'] ?? 'en';
$toLang = $input['to'] ?? 'si';

if (empty(trim($text))) {
    echo json_encode(['success' => true, 'translatedText' => '']);
    exit;
}

// Function to fetch translation using multiple providers
function fetchTranslationChunk($chunk, $fromLang, $toLang) {
    if (empty(trim($chunk))) return $chunk;

    // If the chunk contains no actual translatable letters or numbers (e.g. only HTML tags or spaces), return as-is
    $plain = strip_tags($chunk);
    if (!preg_match('/[\p{L}\p{N}]/u', $plain)) {
        return $chunk;
    }
    
    $cacheKey = md5("trans_{$fromLang}_{$toLang}_" . trim($chunk));
    $cached = Cache::get($cacheKey, 2592000); // 30 days TTL
    if ($cached !== null && is_string($cached) && $cached !== '') {
        return $cached;
    }

    $encodedChunk = urlencode(trim($chunk));
    $providers = [
        // 1. Google Dict Chrome Extension API
        [
            'url' => "https://translate.googleapis.com/translate_a/single?client=dict-chrome-ex&sl={$fromLang}&tl={$toLang}&dt=t&q={$encodedChunk}",
            'parser' => function($resp) {
                $data = json_decode($resp, true);
                if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                    $result = '';
                    foreach ($data[0] as $t) {
                        if (isset($t[0]) && is_string($t[0])) $result .= $t[0];
                    }
                    return $result ?: null;
                }
                return null;
            }
        ],
        // 2. Google GTX API
        [
            'url' => "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$fromLang}&tl={$toLang}&dt=t&q={$encodedChunk}",
            'parser' => function($resp) {
                $data = json_decode($resp, true);
                if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                    $result = '';
                    foreach ($data[0] as $t) {
                        if (isset($t[0]) && is_string($t[0])) $result .= $t[0];
                    }
                    return $result ?: null;
                }
                return null;
            }
        ],
        // 3. MyMemory Free API
        [
            'url' => "https://api.mymemory.translated.net/get?q={$encodedChunk}&langpair={$fromLang}|{$toLang}",
            'parser' => function($resp) {
                $data = json_decode($resp, true);
                if (isset($data['responseData']['translatedText']) && is_string($data['responseData']['translatedText'])) {
                    return $data['responseData']['translatedText'];
                }
                return null;
            }
        ]
    ];

    foreach ($providers as $provider) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $provider['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $parsed = $provider['parser']($response);
            if ($parsed !== null && trim($parsed) !== '') {
                // Preserve leading/trailing whitespace of the original chunk
                $prefix = preg_match('/^\s+/', $chunk, $m) ? $m[0] : '';
                $suffix = preg_match('/\s+$/', $chunk, $m) ? $m[0] : '';
                $finalTranslation = $prefix . $parsed . $suffix;
                Cache::set($cacheKey, $finalTranslation);
                return $finalTranslation;
            }
        }
    }
    
    // If all providers fail, return original chunk
    return $chunk;
}

// Function to chunk large text (HTML or plain text) intelligently
function splitAndTranslate($text, $from, $to) {
    if (mb_strlen($text) < 700) {
        return fetchTranslationChunk($text, $from, $to);
    }
    
    // Split by paragraph / block tags / line breaks to keep chunks within safe limits
    $delimiters = '/(<\/p>|<\/div>|<\/li>|<\/h[1-6]>|<\/blockquote>|<br\s*\/?>|\r?\n+)/i';
    $tokens = preg_split($delimiters, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $translatedText = '';
    $current = '';
    
    foreach ($tokens as $token) {
        if ($token === '') continue;
        
        if (preg_match($delimiters, $token)) {
            $current .= $token;
            if (mb_strlen($current) > 500) {
                $translatedText .= fetchTranslationChunk($current, $from, $to);
                $current = '';
            }
        } else {
            // If an unbroken piece is very large (> 700 chars), split it by sentences
            if (mb_strlen($token) > 700) {
                if ($current !== '') {
                    $translatedText .= fetchTranslationChunk($current, $from, $to);
                    $current = '';
                }
                $sentences = preg_split('/([.!?]\s+)/u', $token, -1, PREG_SPLIT_DELIM_CAPTURE);
                $sentBuffer = '';
                foreach ($sentences as $s) {
                    if (mb_strlen($sentBuffer . $s) > 600 && $sentBuffer !== '') {
                        $translatedText .= fetchTranslationChunk($sentBuffer, $from, $to);
                        $sentBuffer = '';
                    }
                    $sentBuffer .= $s;
                }
                if ($sentBuffer !== '') {
                    $current = $sentBuffer;
                }
            } else {
                if (mb_strlen($current . $token) > 600 && $current !== '') {
                    $translatedText .= fetchTranslationChunk($current, $from, $to);
                    $current = '';
                }
                $current .= $token;
            }
        }
    }
    
    if ($current !== '') {
        $translatedText .= fetchTranslationChunk($current, $from, $to);
    }
    
    return $translatedText;
}

try {
    $result = splitAndTranslate($text, $fromLang, $toLang);
    echo json_encode(['success' => true, 'translatedText' => $result]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
