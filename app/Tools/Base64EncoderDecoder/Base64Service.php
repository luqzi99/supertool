<?php

namespace App\Tools\Base64EncoderDecoder;

class Base64Service
{
    /**
     * Encode plain text to Base64
     */
    public function encode(string $text): string
    {
        return base64_encode($text);
    }

    /**
     * Decode Base64 string to plain text
     */
    public function decode(string $text): string
    {
        if (!$this->isValidBase64($text)) {
            throw new \InvalidArgumentException('Invalid Base64 string. Please check your input.');
        }

        $decoded = base64_decode($text, true);

        if ($decoded === false) {
            throw new \InvalidArgumentException('Invalid Base64 string. Please check your input.');
        }

        return $decoded;
    }

    /**
     * Validate if string is valid Base64 format
     */
    private function isValidBase64(string $text): bool
    {
        // Base64 should only contain A-Z, a-z, 0-9, +, /, and = for padding
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $text)) {
            return false;
        }

        // Try to decode and re-encode to verify
        $decoded = base64_decode($text, true);

        if ($decoded === false) {
            return false;
        }

        // Re-encode and compare (normalize by removing whitespace)
        $normalized = preg_replace('/\s+/', '', $text);
        return base64_encode($decoded) === $normalized;
    }
}
