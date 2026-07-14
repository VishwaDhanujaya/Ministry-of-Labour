<?php
/**
 * Simple JSON File-Based Cache Utility
 * Reduces database load for public-facing high-traffic pages.
 */

class Cache {
    private static $cacheDir = null;

    /**
     * Get the absolute path to the cache directory and ensure it exists
     */
    private static function getCacheDir() {
        if (self::$cacheDir === null) {
            self::$cacheDir = __DIR__ . '/../cache';
            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0755, true);
            }
        }
        return self::$cacheDir;
    }

    /**
     * Generate a safe file path for a cache key
     */
    private static function getFilePath($key) {
        // Sanitize key to prevent path traversal
        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '', $key);
        return self::getCacheDir() . '/' . $safeKey . '.json';
    }

    /**
     * Retrieve data from the cache if it exists and is not expired
     *
     * @param string $key The unique cache key
     * @param int $ttl Time to live in seconds (default 300s = 5 minutes)
     * @return mixed|null Returns the decoded data, or null if expired/missing
     */
    public static function get($key, $ttl = 300) {
        $file = self::getFilePath($key);
        if (file_exists($file)) {
            $mtime = filemtime($file);
            if ((time() - $mtime) <= $ttl) {
                $content = file_get_contents($file);
                if ($content !== false) {
                    $data = json_decode($content, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $data;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Save data to the cache
     *
     * @param string $key The unique cache key
     * @param mixed $data The data to serialize as JSON (must be array/string/int)
     * @return bool True on success
     */
    public static function set($key, $data) {
        $file = self::getFilePath($key);
        $json = json_encode($data);
        if ($json === false) {
            return false;
        }
        return file_put_contents($file, $json, LOCK_EX) !== false;
    }

    /**
     * Delete a specific cache key
     */
    public static function forget($key) {
        $file = self::getFilePath($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }
}
