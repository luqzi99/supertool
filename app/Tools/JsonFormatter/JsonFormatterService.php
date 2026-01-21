<?php

namespace App\Tools\JsonFormatter;

class JsonFormatterService
{
    /**
     * Format and validate JSON text
     */
    public function format(string $jsonText): string
    {
        // Attempt to decode JSON
        $decoded = json_decode($jsonText, true);

        // Check for JSON errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException($this->getHumanReadableError());
        }

        // Re-encode with pretty print
        $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($formatted === false) {
            throw new \InvalidArgumentException('Failed to format JSON.');
        }

        return $formatted;
    }

    /**
     * Convert technical JSON errors to human-readable messages
     */
    private function getHumanReadableError(): string
    {
        $error = json_last_error();
        $errorMsg = json_last_error_msg();

        return match ($error) {
            JSON_ERROR_DEPTH => 'JSON is nested too deeply. Maximum depth exceeded.',
            JSON_ERROR_STATE_MISMATCH => 'Invalid JSON structure. Please check your brackets and braces.',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found in JSON.',
            JSON_ERROR_SYNTAX => 'Invalid JSON syntax. Please check for missing commas, quotes, or brackets.',
            JSON_ERROR_UTF8 => 'Invalid UTF-8 characters in JSON.',
            JSON_ERROR_RECURSION => 'Recursive references detected in JSON.',
            JSON_ERROR_INF_OR_NAN => 'Invalid number format (infinity or NaN) in JSON.',
            JSON_ERROR_UNSUPPORTED_TYPE => 'Unsupported data type in JSON.',
            default => "Invalid JSON: {$errorMsg}",
        };
    }
}
