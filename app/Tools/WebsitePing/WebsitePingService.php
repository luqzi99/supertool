<?php

namespace App\Tools\WebsitePing;

use Illuminate\Support\Facades\Http;

class WebsitePingService
{
    private const TIMEOUT_SECONDS = 2;

    /**
     * Ping a website and return status information.
     *
     * @throws \InvalidArgumentException
     */
    public function ping(string $url): array
    {
        $this->validateUrl($url);

        return $this->makeRequest($url);
    }

    /**
     * Validate URL and prevent SSRF attacks.
     *
     * @throws \InvalidArgumentException
     */
    private function validateUrl(string $url): void
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('URL is required');
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL format');
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new \InvalidArgumentException('Only HTTP and HTTPS protocols are allowed');
        }

        $host = parse_url($url, PHP_URL_HOST);
        if ($this->isInternalHost($host)) {
            throw new \InvalidArgumentException('Internal network access is not allowed');
        }
    }

    /**
     * Check if host is internal/localhost (SSRF prevention).
     */
    private function isInternalHost(string $host): bool
    {
        // Check for localhost
        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }

        // Resolve hostname to IP
        $ip = gethostbyname($host);

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Check for private IP ranges
        return !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Make HTTP request and measure response time.
     */
    private function makeRequest(string $url): array
    {
        $startTime = microtime(true);

        try {
            $response = Http::timeout(self::TIMEOUT_SECONDS)->get($url);
            $endTime = microtime(true);

            $responseTimeMs = round(($endTime - $startTime) * 1000);

            return [
                'status' => 'online',
                'http_code' => $response->status(),
                'response_time_ms' => $responseTimeMs,
            ];
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'timed out')) {
                throw new \RuntimeException('Request timed out');
            }

            throw new \RuntimeException('Website is not reachable');
        }
    }
}
