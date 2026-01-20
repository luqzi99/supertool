<?php

namespace App\Http\Controllers;

class ToolsController extends Controller
{
    public function index()
    {
        $tools = [
            [
                'name' => 'WhatsApp Link Generator',
                'description' => 'Generate WhatsApp chat links without saving phone numbers',
                'route' => 'whatsapp-link.show',
                'icon' => '💬',
            ],
        ];

        return view('tools.index', ['tools' => $tools]);
    }
}
