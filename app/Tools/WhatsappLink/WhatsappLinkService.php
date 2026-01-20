<?php

namespace App\Tools\WhatsappLink;

class WhatsappLinkService
{
    /**
     * Generate WhatsApp link from phone number and optional message.
     */
    public function generate(string $phone, ?string $message = null): string
    {
        $sanitizedPhone = $this->sanitizePhone($phone);

        if (empty($sanitizedPhone)) {
            throw new \InvalidArgumentException('Phone number must contain digits');
        }

        $baseUrl = "https://wa.me/{$sanitizedPhone}";

        if ($message !== null && trim($message) !== '') {
            $encodedMessage = $this->encodeMessage($message);
            return "{$baseUrl}?text={$encodedMessage}";
        }

        return $baseUrl;
    }

    /**
     * Strip all non-numeric characters from phone number.
     */
    private function sanitizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * URL encode message for WhatsApp link.
     */
    private function encodeMessage(string $message): string
    {
        return rawurlencode(substr($message, 0, 500));
    }
}
