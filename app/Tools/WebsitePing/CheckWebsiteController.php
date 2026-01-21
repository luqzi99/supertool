<?php

namespace App\Tools\WebsitePing;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckWebsiteController
{
    public function __construct(
        private WebsitePingService $service
    ) {}

    /**
     * Show the website ping form.
     */
    public function show(): View
    {
        return view('tools.website-ping');
    }

    /**
     * Check website status.
     */
    public function check(Request $request): View
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:2048'],
        ]);

        try {
            $result = $this->service->ping($validated['url']);

            return view('tools.website-ping', [
                'result' => $result,
                'url' => $validated['url'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return view('tools.website-ping', [
                'error' => $e->getMessage(),
                'url' => $validated['url'],
            ]);
        } catch (\RuntimeException $e) {
            return view('tools.website-ping', [
                'error' => $e->getMessage(),
                'url' => $validated['url'],
            ]);
        }
    }
}
