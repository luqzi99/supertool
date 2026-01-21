<?php

namespace App\Tools\JsonFormatter;

use Illuminate\Http\Request;
use Illuminate\View\View;

class JsonFormatterController
{
    public function __construct(
        private JsonFormatterService $service
    ) {}

    /**
     * Show the JSON formatter form.
     */
    public function show(): View
    {
        return view('tools.json-formatter');
    }

    /**
     * Process JSON formatting and validation.
     */
    public function process(Request $request): View
    {
        $validated = $request->validate([
            'json_text' => ['required', 'string', 'max:500000'],
        ]);

        try {
            $formatted = $this->service->format($validated['json_text']);

            return view('tools.json-formatter', [
                'formatted' => $formatted,
                'json_text' => $validated['json_text'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return view('tools.json-formatter', [
                'error' => $e->getMessage(),
                'json_text' => $validated['json_text'],
            ]);
        }
    }
}
