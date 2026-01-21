<?php

namespace App\Tools\Base64EncoderDecoder;

use Illuminate\Http\Request;
use Illuminate\View\View;

class Base64Controller
{
    public function __construct(
        private Base64Service $service
    ) {}

    /**
     * Show the Base64 encoder/decoder form.
     */
    public function show(): View
    {
        return view('tools.base64');
    }

    /**
     * Process Base64 encoding or decoding.
     */
    public function process(Request $request): View
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:100000'],
            'mode' => ['required', 'string', 'in:encode,decode'],
        ]);

        try {
            $result = $validated['mode'] === 'encode'
                ? $this->service->encode($validated['text'])
                : $this->service->decode($validated['text']);

            return view('tools.base64', [
                'result' => $result,
                'text' => $validated['text'],
                'mode' => $validated['mode'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return view('tools.base64', [
                'error' => $e->getMessage(),
                'text' => $validated['text'],
                'mode' => $validated['mode'],
            ]);
        }
    }
}
