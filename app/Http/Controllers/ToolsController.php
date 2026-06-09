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
            [
                'name' => 'Base64 Encoder/Decoder',
                'description' => 'Encode plain text to Base64 or decode Base64 strings',
                'route' => 'tools.base64.show',
                'icon' => '🔐',
            ],
            [
                'name' => 'JSON Formatter & Validator',
                'description' => 'Format messy JSON and validate JSON syntax',
                'route' => 'tools.json-formatter.show',
                'icon' => '📋',
            ],
            [
                'name' => 'Image Converter',
                'description' => 'Convert, resize, and optimize images (PNG/JPG/WEBP)',
                'route' => 'tools.image-converter.index',
                'icon' => '🖼️',
            ],
            [
                'name' => 'MOLPay Skey Generator',
                'description' => 'Generate MOLPay payout security key (skey) from operator, bank details, and private vkey',
                'route' => 'tools.molpay-skey.show',
                'icon' => '🔑',
            ],
        ];

        return view('tools.index', ['tools' => $tools]);
    }
}
