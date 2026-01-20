<?php

namespace App\Tools\WhatsappLink;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerateWhatsappLinkController extends Controller
{
    public function __construct(
        private WhatsappLinkService $service
    ) {}

    public function show()
    {
        return view('tools.whatsapp-link');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'message' => 'nullable|string|max:500',
        ]);

        try {
            $link = $this->service->generate(
                $validated['phone'],
                $validated['message'] ?? null
            );

            return view('tools.whatsapp-link', [
                'link' => $link,
                'phone' => $validated['phone'],
                'message' => $validated['message'] ?? null,
            ]);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['phone' => $e->getMessage()]);
        }
    }
}
