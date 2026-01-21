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
            [
                'name' => 'Website Ping Checker',
                'description' => 'Check if a website is reachable and responding',
                'route' => 'tools.website-ping.show',
                'icon' => '🌐',
            ],
        ];

        return view('tools.index', ['tools' => $tools]);
    }
}
