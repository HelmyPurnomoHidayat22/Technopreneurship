<?php

namespace App\Helpers;

class InputSanitizer
{
    /**
     * Sanitize HTML input
     */
    public static function sanitizeHtml($input): string
    {
        if (is_null($input)) {
            return '';
        }

        // Remove all HTML tags except safe ones
        $allowed = '<p><br><strong><em><u><a><ul><ol><li>';
        $cleaned = strip_tags($input, $allowed);

        // Remove dangerous attributes
        $cleaned = preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i', '<$1$2>', $cleaned);

        return trim($cleaned);
    }

    /**
     * Sanitize plain text (remove all HTML)
     */
    public static function sanitizeText($input): string
    {
        if (is_null($input)) {
            return '';
        }

        // Remove all HTML tags
        $cleaned = strip_tags($input);

        // Remove extra whitespace
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        return trim($cleaned);
    }

    /**
     * Sanitize for database (prevent SQL injection via Laravel)
     */
    public static function sanitizeForDatabase($input): string
    {
        if (is_null($input)) {
            return '';
        }

        // Laravel's Eloquent already handles SQL injection
        // This is additional sanitization for XSS prevention
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize chat message
     */
    public static function sanitizeChatMessage($message): string
    {
        // Remove HTML but keep line breaks
        $cleaned = self::sanitizeText($message);

        // Limit length
        $cleaned = substr($cleaned, 0, 1000);

        return $cleaned;
    }

    /**
     * Sanitize custom notes
     */
    public static function sanitizeNotes($notes): string
    {
        // Allow basic formatting
        $cleaned = self::sanitizeHtml($notes);

        // Limit length
        $cleaned = substr($cleaned, 0, 5000);

        return $cleaned;
    }

    /**
     * Sanitize filename
     */
    public static function sanitizeFilename($filename): string
    {
        // Remove path traversal attempts
        $filename = basename($filename);

        // Remove special characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

        return $filename;
    }
}
